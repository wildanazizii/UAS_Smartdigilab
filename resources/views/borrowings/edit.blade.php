@extends('layouts.app')

@section('title', 'Edit Peminjaman - SmartDigiLab')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-edit text-yellow-600 mr-2"></i>
                Edit Data Peminjaman
            </h1>
            <p class="text-gray-600 mt-1">Perbarui informasi peminjaman alat</p>
        </div>

        <form action="{{ route('borrowings.update', $borrowing) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Information -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h2 class="font-semibold text-gray-800 mb-3">Informasi Saat Ini</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Peminjam</p>
                        <p class="font-semibold">{{ $borrowing->borrower->name }} ({{ $borrowing->borrower->nim }})</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Alat</p>
                        <p class="font-semibold">{{ $borrowing->equipment->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Pinjam</p>
                        <p class="font-semibold">{{ $borrowing->borrow_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <p class="font-semibold">{{ ucfirst($borrowing->status) }}</p>
                    </div>
                </div>
            </div>

            <div>
                <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Kembali
                </label>
                <input type="date" name="return_date" id="return_date" 
                    value="{{ old('return_date', $borrowing->return_date ? $borrowing->return_date->format('Y-m-d') : '') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('return_date') border-red-500 @enderror">
                @error('return_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Kosongkan jika belum dikembalikan</p>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                    required>
                    <option value="dipinjam" {{ old('status', $borrowing->status) === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ old('status', $borrowing->status) === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    Jika status diubah menjadi "Dikembalikan", status alat akan otomatis diubah menjadi "Tersedia"
                </p>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('borrowings.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
