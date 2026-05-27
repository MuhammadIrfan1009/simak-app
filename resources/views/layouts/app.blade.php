<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMAK - Sistem Manajemen Akademik')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Sidebar Navigation -->
    <div class="flex h-screen">
        <nav class="w-64 bg-gray-900 text-white shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold">🎓 SIMAK</h1>
                <p class="text-gray-400 text-sm mt-1">Sistem Manajemen Akademik</p>
            </div>

            <!-- Menu Items -->
            <ul class="space-y-2 p-4">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-800' }} transition">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('mahasiswa.*') ? 'bg-primary' : 'hover:bg-gray-800' }} transition">
                        👥 Mahasiswa
                    </a>
                </li>
                <li>
                    <a href="{{ route('mata-kuliah.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('mata-kuliah.*') ? 'bg-primary' : 'hover:bg-gray-800' }} transition">
                        📚 Mata Kuliah
                    </a>
                </li>
                <li>
                    <a href="{{ route('jadwal.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('jadwal.*') ? 'bg-primary' : 'hover:bg-gray-800' }} transition">
                        🕐 Jadwal
                    </a>
                </li>
                <li>
                    <a href="{{ route('nilai.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('nilai.*') ? 'bg-primary' : 'hover:bg-gray-800' }} transition">
                        📝 Nilai
                    </a>
                </li>
            </ul>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800 bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-white text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-gray-400 text-xs">{{ auth()->user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition">
                            🚪
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
