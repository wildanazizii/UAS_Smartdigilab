<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipment = Equipment::orderBy('created_at', 'desc')->paginate(10);
        return view('equipment.index', compact('equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:equipment,code|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'availability_status' => 'required|in:tersedia,dipinjam,rusak'
        ]);

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:equipment,code,' . $equipment->id,
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'availability_status' => 'required|in:tersedia,dipinjam,rusak'
        ]);

        $equipment->update($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Alat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Alat berhasil dihapus!');
    }

    /**
     * Generate QR Code for equipment
     */
    public function qrcode(Equipment $equipment)
    {
        $qrCode = QrCode::size(300)
            ->generate(route('equipment.show', $equipment->id));
        
        return view('equipment.qrcode', compact('equipment', 'qrCode'));
    }
}
