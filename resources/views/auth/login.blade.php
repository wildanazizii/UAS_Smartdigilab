@extends('layouts.app')

@section('title', 'Login - SmartDigiLab')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-right-to-bracket text-blue-600 mr-2"></i>
                Login
            </h1>
            <p class="text-gray-600 mt-1">Masuk sebagai admin atau user</p>
        </div>

        <div class="flex gap-2 mb-6">
            <a href="{{ route('login', ['role' => 'user']) }}" class="w-1/2 text-center px-4 py-2 rounded-lg border {{ request('role') === 'admin' ? 'bg-white text-gray-700 border-gray-300' : 'bg-blue-600 text-white border-blue-600' }}">
                User
            </a>
            <a href="{{ route('login', ['role' => 'admin']) }}" class="w-1/2 text-center px-4 py-2 rounded-lg border {{ request('role') === 'admin' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300' }}">
                Admin
            </a>
        </div>

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="{{ request('role') }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="fas fa-right-to-bracket mr-2"></i>Masuk
            </button>
        </form>

        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-sm font-semibold text-gray-700 mb-2">Akun demo</p>
            <p class="text-sm text-gray-600">Admin: admin@smartdigilab.test / password</p>
            <p class="text-sm text-gray-600">User: user@smartdigilab.test / password</p>
        </div>
    </div>
</div>
@endsection
