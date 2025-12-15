@extends('layouts.app')

@section('title', 'Peminjaman Berhasil - SmartDigiLab')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="fas fa-check-circle text-green-600 text-5xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Peminjaman Berhasil!
            </h1>
            <p class="text-gray-600">Pengajuan peminjaman alat Anda telah berhasil dicatat</p>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 text-left">
            <h2 class="font-semibold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Langkah Selanjutnya
            </h2>
            <ul class="text-sm text-blue-700 space-y-2 list-disc list-inside">
                <li>Silakan datang ke laboratorium untuk mengambil alat</li>
                <li>Tunjukkan identitas (KTM) kepada petugas</li>
                <li>Pastikan memeriksa kondisi alat sebelum membawa</li>
                <li>Hubungi admin untuk proses pengembalian alat</li>
            </ul>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 text-left">
            <h2 class="font-semibold text-yellow-800 mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>Penting!
            </h2>
            <p class="text-sm text-yellow-700">
                Jaga alat dengan baik dan kembalikan sesuai waktu yang ditentukan. 
                Kerusakan atau keterlambatan pengembalian akan dikenakan sanksi sesuai peraturan yang berlaku.
            </p>
        </div>

        <div class="flex justify-center space-x-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">
                <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
            </a>
            <a href="{{ route('borrowings.create') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-semibold">
                <i class="fas fa-plus mr-2"></i>Pinjam Lagi
            </a>
        </div>
    </div>
</div>
@endsection
