@extends('layouts.app')

@section('title', 'Peminjaman - SmartDigiLab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-tasks text-purple-600 mr-2"></i>
                {{ auth()->user()->role === 'admin' ? 'Admin Peminjaman Alat' : 'Peminjaman Saya' }}
            </h1>
            <p class="text-gray-600 mt-1">Kelola data peminjaman dan pengembalian alat</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ auth()->user()->role === 'admin' ? \App\Models\Borrowing::count() : \App\Models\Borrowing::where('user_id', auth()->id())->count() }}
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-list text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ auth()->user()->role === 'admin' ? \App\Models\Borrowing::where('status', 'dipinjam')->count() : \App\Models\Borrowing::where('user_id', auth()->id())->where('status', 'dipinjam')->count() }}
                    </p>
                </div>
                <div class="bg-yellow-100 rounded-full p-4">
                    <i class="fas fa-hand-holding text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sudah Dikembalikan</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ auth()->user()->role === 'admin' ? \App\Models\Borrowing::where('status', 'dikembalikan')->count() : \App\Models\Borrowing::where('user_id', auth()->id())->where('status', 'dikembalikan')->count() }}
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowings List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($borrowings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surat</th>
                            @if(auth()->user()->role === 'admin')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrower->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $borrowing->borrower->nim }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->equipment->name }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->equipment->code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $borrowing->jumlah ?? 1 }}
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
                                    <a href="{{ route('borrowings.letter', $borrowing) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-file-arrow-up mr-1"></i>Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($borrowing->status === 'dipinjam')
                                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Kembalikan" onclick="return confirm('Tandai alat sebagai dikembalikan?')">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('borrowings.edit', $borrowing) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $borrowings->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada data peminjaman</p>
            </div>
        @endif
    </div>
</div>
@endsection
