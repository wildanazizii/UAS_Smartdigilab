@extends('layouts.app')

@section('title', 'Inventaris Alat - SmartDigiLab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-box text-blue-600 mr-2"></i>
                Manajemen Inventaris Alat
            </h1>
            <p class="text-gray-600 mt-1">Kelola data alat laboratorium</p>
        </div>
        <a href="{{ route('equipment.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Tambah Alat
        </a>
    </div>

    <!-- Equipment List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($equipment->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($equipment as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono font-bold text-gray-900">{{ $item->code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->availability_status === 'tersedia')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Tersedia
                                    </span>
                                @elseif($item->availability_status === 'dipinjam')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hand-holding mr-1"></i> Dipinjam
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Rusak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('equipment.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('equipment.qrcode', $item) }}" class="text-purple-600 hover:text-purple-900" title="QR Code">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                    <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $equipment->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada data alat</p>
                <a href="{{ route('equipment.create') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Alat Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
