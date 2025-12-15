@extends('layouts.app')

@section('title', 'Dashboard - SmartDigiLab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-flask text-blue-600 mr-2"></i>
            Sistem Inventaris Laboratorium dan Peminjaman Alat
        </h1>
        <p class="text-gray-600">Selamat datang di SmartDigiLab - Kelola inventaris dan peminjaman alat laboratorium dengan mudah</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Alat</p>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Equipment::count() }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-4">
                    <i class="fas fa-box text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Alat Tersedia</p>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Equipment::where('availability_status', 'tersedia')->count() }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-4">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Borrowing::where('status', 'dipinjam')->count() }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-4">
                    <i class="fas fa-hand-holding text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total Peminjam</p>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Borrower::count() }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-4">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i>
            Aksi Cepat
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('equipment.create') }}" class="bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 rounded-lg p-4 text-center transition transform hover:scale-105">
                <i class="fas fa-plus-circle text-blue-600 text-3xl mb-2"></i>
                <p class="text-blue-800 font-semibold">Tambah Alat</p>
            </a>
            <a href="{{ route('borrowings.create') }}" class="bg-green-50 hover:bg-green-100 border-2 border-green-200 rounded-lg p-4 text-center transition transform hover:scale-105">
                <i class="fas fa-hand-holding text-green-600 text-3xl mb-2"></i>
                <p class="text-green-800 font-semibold">Pinjam Alat</p>
            </a>
            <a href="{{ route('borrowings.index') }}" class="bg-purple-50 hover:bg-purple-100 border-2 border-purple-200 rounded-lg p-4 text-center transition transform hover:scale-105">
                <i class="fas fa-tasks text-purple-600 text-3xl mb-2"></i>
                <p class="text-purple-800 font-semibold">Kelola Peminjaman</p>
            </a>
            <a href="{{ route('reports.index') }}" class="bg-orange-50 hover:bg-orange-100 border-2 border-orange-200 rounded-lg p-4 text-center transition transform hover:scale-105">
                <i class="fas fa-chart-line text-orange-600 text-3xl mb-2"></i>
                <p class="text-orange-800 font-semibold">Lihat Laporan</p>
            </a>
        </div>
    </div>

    <!-- Recent Borrowings -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-history text-gray-600 mr-2"></i>
            Peminjaman Terbaru
        </h2>
        @php
            $recentBorrowings = \App\Models\Borrowing::with(['borrower', 'equipment'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        @endphp
        
        @if($recentBorrowings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentBorrowings as $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrower->name }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->borrower->nim }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $borrowing->equipment->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($borrowing->status === 'dipinjam')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada data peminjaman</p>
        @endif
    </div>
</div>
@endsection
