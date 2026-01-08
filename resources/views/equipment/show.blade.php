@extends('layouts.app')

@section('title', 'Detail Alat - SmartDigiLab')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-info-circle mr-2"></i>
                Detail Alat
            </h1>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kode Alat</label>
                    <p class="text-lg font-mono font-bold text-gray-900">{{ $equipment->code }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status Ketersediaan</label>
                    @if($equipment->availability_status === 'tersedia')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Tersedia
                        </span>
                    @elseif($equipment->availability_status === 'dipinjam')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            <i class="fas fa-hand-holding mr-1"></i> Dipinjam
                        </span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i> Rusak
                        </span>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Alat</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $equipment->name }}</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                    <p class="text-gray-700 leading-relaxed">{{ $equipment->description }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jumlah</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $equipment->quantity }} unit</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Ditambahkan</label>
                    <p class="text-gray-700">{{ $equipment->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <!-- Borrowing History -->
            <div class="border-t pt-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-history text-gray-600 mr-2"></i>
                    Riwayat Peminjaman
                </h2>
                @php
                    $borrowings = $equipment->borrowings()->with('borrower')->orderBy('created_at', 'desc')->limit(5)->get();
                @endphp

                @if($borrowings->count() > 0)
                    <div class="space-y-3">
                        @foreach($borrowings as $borrowing)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $borrowing->borrower->name }}</p>
                                    <p class="text-sm text-gray-600">NIM: {{ $borrowing->borrower->nim }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $borrowing->borrow_date->format('d/m/Y') }}
                                        @if($borrowing->return_date)
                                            - {{ $borrowing->return_date->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    @if($borrowing->status === 'dipinjam')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Dipinjam
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada riwayat peminjaman</p>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center pt-6 border-t">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <div class="flex space-x-3">
                    <a href="{{ route('equipment.qrcode', $equipment) }}" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                        <i class="fas fa-qrcode mr-2"></i>QR Code
                    </a>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('equipment.edit', $equipment) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
