<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Inventaris Laboratorium')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <i class="fas fa-flask text-white text-2xl mr-3"></i>
                        <span class="text-white text-xl font-bold">SmartDigiLab</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('equipment.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-box mr-1"></i> Inventaris
                    </a>
                    <a href="{{ route('borrowings.create') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-hand-holding mr-1"></i> Pinjam Alat
                    </a>
                    <a href="{{ route('borrowings.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-list mr-1"></i> Admin
                    </a>
                    <a href="{{ route('reports.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-chart-bar mr-1"></i> Laporan
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} SmartDigiLab - Sistem Inventaris Laboratorium dan Peminjaman Alat</p>
                <p class="text-sm text-gray-400 mt-2">Dibuat untuk UTS Pemrograman Web</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
