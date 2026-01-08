<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Equipment;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource (Admin page).
     */
    public function index()
    {
        $query = Borrowing::with(['borrower', 'equipment'])
            ->orderBy('created_at', 'desc');

        if (Auth::user()?->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $borrowings = $query->paginate(15);
        
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource (Borrowing form).
     */
    public function create()
    {
        $equipment = Equipment::where('availability_status', 'tersedia')
            ->where('quantity', '>', 0)
            ->get();
        return view('borrowings.create', compact('equipment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_nim' => 'required|string|max:255',
            'borrower_contact' => 'required|string|max:255',
            'equipment_id' => 'required|exists:equipment,id',
            'jumlah' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'request_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $requestLetterPath = null;
        if ($request->hasFile('request_letter')) {
            $requestLetterPath = $request->file('request_letter')->store('request_letters', 'public');
        }

        // Create or find borrower
        $borrower = Borrower::firstOrCreate(
            ['nim' => $validated['borrower_nim']],
            [
                'name' => $validated['borrower_name'],
                'contact' => $validated['borrower_contact']
            ]
        );

        DB::transaction(function () use ($validated, $borrower, $requestLetterPath) {
            $equipment = Equipment::lockForUpdate()->findOrFail($validated['equipment_id']);

            if ((int) $equipment->quantity < (int) $validated['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok alat tidak mencukupi.'
                ]);
            }

            // Create borrowing
            Borrowing::create([
                'user_id' => Auth::id(),
                'borrower_id' => $borrower->id,
                'equipment_id' => $validated['equipment_id'],
                'jumlah' => $validated['jumlah'],
                'request_letter_path' => $requestLetterPath,
                'borrow_date' => $validated['borrow_date'],
                'status' => 'dipinjam'
            ]);

            // Reduce stock
            $equipment->quantity = (int) $equipment->quantity - (int) $validated['jumlah'];
            $equipment->availability_status = ((int) $equipment->quantity === 0) ? 'dipinjam' : 'tersedia';
            $equipment->save();
        });

        return redirect()->route('borrowings.success')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        if (Auth::user()?->role !== 'admin' && (int) $borrowing->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $borrowing->load(['borrower', 'equipment']);
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        $equipment = Equipment::all();
        $borrowers = Borrower::all();
        return view('borrowings.edit', compact('borrowing', 'equipment', 'borrowers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'return_date' => 'nullable|date',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        DB::transaction(function () use ($validated, $borrowing) {
            $previousStatus = $borrowing->status;

            $borrowing->update($validated);

            if ($previousStatus !== 'dikembalikan' && $validated['status'] === 'dikembalikan') {
                $equipment = Equipment::lockForUpdate()->findOrFail($borrowing->equipment_id);
                $equipment->quantity = (int) $equipment->quantity + (int) ($borrowing->jumlah ?? 1);
                $equipment->availability_status = 'tersedia';
                $equipment->save();
            }
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        $requestLetterPath = $borrowing->request_letter_path;

        DB::transaction(function () use ($borrowing) {
            if ($borrowing->status === 'dipinjam') {
                $equipment = Equipment::lockForUpdate()->findOrFail($borrowing->equipment_id);
                $equipment->quantity = (int) $equipment->quantity + (int) ($borrowing->jumlah ?? 1);
                $equipment->availability_status = 'tersedia';
                $equipment->save();
            }

            $borrowing->delete();
        });

        if ($requestLetterPath) {
            Storage::disk('public')->delete($requestLetterPath);
        }

        return redirect()->route('borrowings.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    /**
     * Show success page after borrowing
     */
    public function success()
    {
        return view('borrowings.success');
    }

    public function my()
    {
        $borrowings = Borrowing::with(['borrower', 'equipment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('borrowings.my', compact('borrowings'));
    }

    /**
     * Return equipment
     */
    public function returnEquipment(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {
            if ($borrowing->status === 'dikembalikan') {
                return;
            }

            $borrowing->update([
                'return_date' => now(),
                'status' => 'dikembalikan'
            ]);

            $equipment = Equipment::lockForUpdate()->findOrFail($borrowing->equipment_id);
            $equipment->quantity = (int) $equipment->quantity + (int) ($borrowing->jumlah ?? 1);
            $equipment->availability_status = 'tersedia';
            $equipment->save();
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Alat berhasil dikembalikan!');
    }

    public function letter(Borrowing $borrowing)
    {
        if (Auth::user()?->role !== 'admin' && (int) $borrowing->user_id !== (int) Auth::id()) {
            abort(403);
        }

        if (! $borrowing->request_letter_path) {
            abort(404);
        }

        if (! Storage::disk('public')->exists($borrowing->request_letter_path)) {
            abort(404);
        }

        return Storage::disk('public')->response($borrowing->request_letter_path);
    }
}
