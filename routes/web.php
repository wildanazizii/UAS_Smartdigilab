<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReportController;

// Home/Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Equipment Management Routes
Route::resource('equipment', EquipmentController::class);
Route::get('equipment/{equipment}/qrcode', [EquipmentController::class, 'qrcode'])->name('equipment.qrcode');

// Borrowing Routes
Route::get('borrowings/success', [BorrowingController::class, 'success'])->name('borrowings.success');
Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnEquipment'])->name('borrowings.return');
Route::resource('borrowings', BorrowingController::class);

// Report Routes
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
