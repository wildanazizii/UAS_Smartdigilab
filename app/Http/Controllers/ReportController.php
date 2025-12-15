<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Equipment;
use App\Models\Borrower;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display report page with filters
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['borrower', 'equipment']);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('borrow_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('borrow_date', '<=', $request->end_date);
        }

        // Filter by equipment
        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->equipment_id);
        }

        // Filter by borrower
        if ($request->filled('borrower_id')) {
            $query->where('borrower_id', $request->borrower_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->orderBy('borrow_date', 'desc')->paginate(20);
        $equipment = Equipment::all();
        $borrowers = Borrower::all();

        return view('reports.index', compact('borrowings', 'equipment', 'borrowers'));
    }

    /**
     * Export report to CSV
     */
    public function export(Request $request)
    {
        $query = Borrowing::with(['borrower', 'equipment']);

        // Apply same filters as index
        if ($request->filled('start_date')) {
            $query->where('borrow_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('borrow_date', '<=', $request->end_date);
        }

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->equipment_id);
        }

        if ($request->filled('borrower_id')) {
            $query->where('borrower_id', $request->borrower_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->orderBy('borrow_date', 'desc')->get();

        $filename = 'laporan_peminjaman_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($borrowings) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['No', 'Nama Peminjam', 'NIM', 'Kontak', 'Alat', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);

            // Data
            $no = 1;
            foreach ($borrowings as $borrowing) {
                fputcsv($file, [
                    $no++,
                    $borrowing->borrower->name,
                    $borrowing->borrower->nim,
                    $borrowing->borrower->contact,
                    $borrowing->equipment->name,
                    $borrowing->borrow_date->format('d/m/Y'),
                    $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-',
                    ucfirst($borrowing->status)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
