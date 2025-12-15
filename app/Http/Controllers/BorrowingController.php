<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Equipment;
use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource (Admin page).
     */
    public function index()
    {
        $borrowings = Borrowing::with(['borrower', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource (Borrowing form).
     */
    public function create()
    {
        $equipment = Equipment::where('availability_status', 'tersedia')->get();
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
            'borrow_date' => 'required|date',
        ]);

        // Create or find borrower
        $borrower = Borrower::firstOrCreate(
            ['nim' => $validated['borrower_nim']],
            [
                'name' => $validated['borrower_name'],
                'contact' => $validated['borrower_contact']
            ]
        );

        // Create borrowing
        Borrowing::create([
            'borrower_id' => $borrower->id,
            'equipment_id' => $validated['equipment_id'],
            'borrow_date' => $validated['borrow_date'],
            'status' => 'dipinjam'
        ]);

        // Update equipment status
        $equipment = Equipment::find($validated['equipment_id']);
        $equipment->update(['availability_status' => 'dipinjam']);

        return redirect()->route('borrowings.success')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
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

        $borrowing->update($validated);

        // Update equipment status if returned
        if ($validated['status'] === 'dikembalikan') {
            $borrowing->equipment->update(['availability_status' => 'tersedia']);
        }

        return redirect()->route('borrowings.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        // Update equipment status back to available if borrowed
        if ($borrowing->status === 'dipinjam') {
            $borrowing->equipment->update(['availability_status' => 'tersedia']);
        }

        $borrowing->delete();

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

    /**
     * Return equipment
     */
    public function returnEquipment(Borrowing $borrowing)
    {
        $borrowing->update([
            'return_date' => now(),
            'status' => 'dikembalikan'
        ]);

        $borrowing->equipment->update(['availability_status' => 'tersedia']);

        return redirect()->route('borrowings.index')
            ->with('success', 'Alat berhasil dikembalikan!');
    }
}
