@extends('layouts.app')

@section('title', 'Laporan Peminjaman - SmartDigiLab')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-chart-bar text-orange-600 mr-2"></i>
                Laporan Peminjaman Alat
            </h1>
            <p class="text-gray-600 mt-1">Filter dan lihat laporan peminjaman berdasarkan kriteria</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-filter text-blue-600 mr-2"></i>
            Filter Laporan
        </h2>
        
        <form action="{{ route('reports.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Akhir
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="equipment_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Alat
                    </label>
                    <select name="equipment_id" id="equipment_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Semua Alat --</option>
                        @foreach($equipment as $item)
                            <option value="{{ $item->id }}" {{ request('equipment_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="borrower_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Peminjam
                    </label>
                    <select name="borrower_id" id="borrower_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Semua Peminjam --</option>
                        @foreach($borrowers as $borrower)
                            <option value="{{ $borrower->id }}" {{ request('borrower_id') == $borrower->id ? 'selected' : '' }}>
                                {{ $borrower->name }} ({{ $borrower->nim }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Semua Status --</option>
                        <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('reports.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-search mr-2"></i>Terapkan Filter
                </button>
                <a href="{{ route('reports.export', request()->all()) }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    <i class="fas fa-download mr-2"></i>Export CSV
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Summary -->
    @if(request()->hasAny(['start_date', 'end_date', 'equipment_id', 'borrower_id', 'status']))
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-500">Total Data</p>
            <p class="text-2xl font-bold text-gray-800">{{ $borrowings->total() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-500">Dipinjam</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $borrowings->where('status', 'dipinjam')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-500">Dikembalikan</p>
            <p class="text-2xl font-bold text-green-600">{{ $borrowings->where('status', 'dikembalikan')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-500">Alat Unik</p>
            <p class="text-2xl font-bold text-blue-600">{{ $borrowings->pluck('equipment_id')->unique()->count() }}</p>
        </div>
    </div>
    @endif

    <!-- Report Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($borrowings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($borrowings as $index => $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrower->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $borrowing->borrower->nim }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $borrowing->borrower->contact }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->equipment->name }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->equipment->code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $borrowing->borrow_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($borrowing->return_date)
                                    {{ $borrowing->return_date->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
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

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $borrowings->appends(request()->all())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-chart-line text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Tidak ada data yang sesuai dengan filter</p>
                <p class="text-gray-400 text-sm mt-2">Coba ubah kriteria filter atau reset filter</p>
            </div>
        @endif
    </div>
</div>
@endsection
