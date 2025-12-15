@extends('layouts.app')

@section('title', 'Detail Peminjaman - SmartDigiLab')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-info-circle mr-2"></i>
                Detail Peminjaman
            </h1>
        </div>

        <div class="p-6 space-y-6">
            <!-- Borrower Information -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <h2 class="font-semibold text-blue-800 mb-3">
                    <i class="fas fa-user mr-2"></i>Data Peminjam
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                        <p class="text-gray-900 font-semibold">{{ $borrowing->borrower->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">NIM</label>
                        <p class="text-gray-900 font-semibold">{{ $borrowing->borrower->nim }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kontak</label>
                        <p class="text-gray-900">{{ $borrowing->borrower->contact }}</p>
                    </div>
                </div>
            </div>

            <!-- Equipment Information -->
            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                <h2 class="font-semibold text-green-800 mb-3">
                    <i class="fas fa-box mr-2"></i>Data Alat
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Alat</label>
                        <p class="text-gray-900 font-semibold">{{ $borrowing->equipment->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kode Alat</label>
                        <p class="text-gray-900 font-mono font-bold">{{ $borrowing->equipment->code }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                        <p class="text-gray-700">{{ $borrowing->equipment->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Borrowing Details -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                <h2 class="font-semibold text-yellow-800 mb-3">
                    <i class="fas fa-calendar mr-2"></i>Detail Peminjaman
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pinjam</label>
                        <p class="text-gray-900 font-semibold">{{ $borrowing->borrow_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Kembali</label>
                        <p class="text-gray-900 font-semibold">
                            @if($borrowing->return_date)
                                {{ $borrowing->return_date->format('d/m/Y') }}
                            @else
                                <span class="text-gray-400">Belum dikembalikan</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        @if($borrowing->status === 'dipinjam')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-hand-holding mr-1"></i> Dipinjam
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Dikembalikan
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center pt-6 border-t">
                <a href="{{ route('borrowings.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <div class="flex space-x-3">
                    @if($borrowing->status === 'dipinjam')
                        <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition" onclick="return confirm('Tandai alat sebagai dikembalikan?')">
                                <i class="fas fa-undo mr-2"></i>Kembalikan
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('borrowings.edit', $borrowing) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
