@extends('layouts.app')

@section('title', 'Form Peminjaman - SmartDigiLab')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-hand-holding text-green-600 mr-2"></i>
                Form Peminjaman Alat
            </h1>
            <p class="text-gray-600 mt-1">Isi formulir di bawah untuk meminjam alat laboratorium</p>
        </div>

        @if($equipment->count() > 0)
            <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Borrower Information -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <h2 class="font-semibold text-blue-800 mb-3">
                        <i class="fas fa-user mr-2"></i>Data Peminjam
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="borrower_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="borrower_name" id="borrower_name" value="{{ old('borrower_name') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('borrower_name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap" required>
                            @error('borrower_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="borrower_nim" class="block text-sm font-medium text-gray-700 mb-2">
                                NIM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="borrower_nim" id="borrower_nim" value="{{ old('borrower_nim') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('borrower_nim') border-red-500 @enderror"
                                placeholder="Masukkan NIM" required>
                            @error('borrower_nim')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="borrower_contact" class="block text-sm font-medium text-gray-700 mb-2">
                                Kontak (No. HP/Email) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="borrower_contact" id="borrower_contact" value="{{ old('borrower_contact') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('borrower_contact') border-red-500 @enderror"
                                placeholder="Masukkan nomor HP atau email" required>
                            @error('borrower_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Equipment Selection -->
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <h2 class="font-semibold text-green-800 mb-3">
                        <i class="fas fa-box mr-2"></i>Pilih Alat
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="equipment_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Alat yang Dipinjam <span class="text-red-500">*</span>
                            </label>
                            <select name="equipment_id" id="equipment_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('equipment_id') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Alat --</option>
                                @foreach($equipment as $item)
                                    <option value="{{ $item->id }}" {{ old('equipment_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->code }}) - Tersedia: {{ $item->quantity }}
                                    </option>
                                @endforeach
                            </select>
                            @error('equipment_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Pinjam <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('borrow_date') border-red-500 @enderror"
                                required>
                            @error('borrow_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                    <h3 class="font-semibold text-yellow-800 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Perhatian
                    </h3>
                    <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside">
                        <li>Pastikan data yang diisi sudah benar</li>
                        <li>Alat harus dikembalikan dalam kondisi baik</li>
                        <li>Kerusakan alat menjadi tanggung jawab peminjam</li>
                        <li>Hubungi admin untuk pengembalian alat</li>
                    </ul>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>Ajukan Peminjaman
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-4">Maaf, saat ini tidak ada alat yang tersedia untuk dipinjam</p>
                <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
