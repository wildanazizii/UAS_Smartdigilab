<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReportController;

// Home/Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Equipment Public Routes
Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])
    ->whereNumber('equipment')
    ->name('equipment.show');
Route::get('equipment/{equipment}/qrcode', [EquipmentController::class, 'qrcode'])
    ->whereNumber('equipment')
    ->name('equipment.qrcode');

Route::middleware(['auth'])->group(function () {
    // Borrowing Routes (User)
    Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('borrowings/success', [BorrowingController::class, 'success'])->name('borrowings.success');
    Route::get('my/borrowings', [BorrowingController::class, 'my'])->name('borrowings.my');
    Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('borrowings/{borrowing}/letter', [BorrowingController::class, 'letter'])->name('borrowings.letter');

    Route::middleware(['admin'])->group(function () {
        // Equipment Management Routes (Admin)
        Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');
        Route::get('equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
        Route::post('equipment', [EquipmentController::class, 'store'])->name('equipment.store');
        Route::get('equipment/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
        Route::put('equipment/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
        Route::delete('equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

        // Borrowing Admin Routes
        Route::get('borrowings/{borrowing}', [BorrowingController::class, 'show'])->name('borrowings.show');
        Route::get('borrowings/{borrowing}/edit', [BorrowingController::class, 'edit'])->name('borrowings.edit');
        Route::put('borrowings/{borrowing}', [BorrowingController::class, 'update'])->name('borrowings.update');
        Route::delete('borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');
        Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnEquipment'])->name('borrowings.return');

        // Report Routes
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
});
