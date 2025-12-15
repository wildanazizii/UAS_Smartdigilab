@extends('layouts.app')

@section('title', 'Edit Alat - SmartDigiLab')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-edit text-yellow-600 mr-2"></i>
                Edit Alat
            </h1>
            <p class="text-gray-600 mt-1">Perbarui informasi alat laboratorium</p>
        </div>

        <form action="{{ route('equipment.update', $equipment) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Alat <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $equipment->name) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Alat <span class="text-red-500">*</span>
                </label>
                <input type="text" name="code" id="code" value="{{ old('code', $equipment->code) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                    required>
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                    required>{{ old('description', $equipment->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah <span class="text-red-500">*</span>
                </label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $equipment->quantity) }}" min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('quantity') border-red-500 @enderror"
                    required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="availability_status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Ketersediaan <span class="text-red-500">*</span>
                </label>
                <select name="availability_status" id="availability_status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('availability_status') border-red-500 @enderror"
                    required>
                    <option value="tersedia" {{ old('availability_status', $equipment->availability_status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ old('availability_status', $equipment->availability_status) === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak" {{ old('availability_status', $equipment->availability_status) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
                @error('availability_status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('equipment.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
