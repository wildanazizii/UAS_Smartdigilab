@extends('layouts.app')

@section('title', 'Pengajuan Saya - SmartDigiLab')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-list-check text-blue-600 mr-2"></i>
            Pengajuan Saya
        </h1>
        <p class="text-gray-600 mt-1">Riwayat pengajuan/peminjaman yang Anda buat</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($borrowings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($borrowings as $borrowing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $borrowing->equipment->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $borrowing->equipment->code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $borrowing->borrow_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($borrowing->return_date)
                                        <i class="fas fa-calendar-check mr-1"></i>
                                        {{ $borrowing->return_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($borrowing->status === 'dipinjam')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-hand-holding mr-1"></i> Dipinjam
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($borrowing->request_letter_path)
                                        <a href="{{ asset('storage/' . $borrowing->request_letter_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-file-arrow-up mr-1"></i>Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50">
                {{ $borrowings->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada pengajuan</p>
                <a href="{{ route('borrowings.create') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Buat Pengajuan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
