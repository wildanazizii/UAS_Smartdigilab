@extends('layouts.app')

@section('title', 'QR Code - SmartDigiLab')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                <i class="fas fa-qrcode text-purple-600 mr-2"></i>
                QR Code Alat
            </h1>
            <p class="text-gray-600 mb-6">Scan QR Code untuk melihat detail alat</p>

            <div class="bg-gray-50 rounded-lg p-8 mb-6">
                <div class="inline-block bg-white p-4 rounded-lg shadow-md">
                    {!! $qrCode !!}
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 text-left">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <div>
                        <p class="font-semibold text-blue-800">Informasi Alat</p>
                        <p class="text-sm text-blue-700 mt-1">Kode: <span class="font-mono font-bold">{{ $equipment->code }}</span></p>
                        <p class="text-sm text-blue-700">Nama: <span class="font-semibold">{{ $equipment->name }}</span></p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-4">
                <a href="{{ route('equipment.show', $equipment) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button onclick="window.print()" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    @media print {
        nav, footer, button, a {
            display: none !important;
        }
        body {
            background: white !important;
        }
    }
</style>
@endpush
@endsection
