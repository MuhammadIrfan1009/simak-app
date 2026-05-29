<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMAK - Sistem Manajemen Akademik')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800">
    <div class="flex flex-col md:flex-row min-h-screen">
        
        <!-- Mobile Top Navbar -->
        <header class="flex items-center justify-between bg-slate-900 text-white p-4 md:hidden border-b border-slate-800 shadow-md">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-xl text-white shadow-md shadow-indigo-600/30">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-base leading-none tracking-wide text-white">SIMAK</h1>
                    <p class="text-[10px] text-slate-400 font-medium">Sistem Manajemen Akademik</p>
                </div>
            </div>
            <button id="hamburger-menu" class="p-2 text-slate-400 hover:text-white focus:outline-none hover:bg-slate-800 rounded-xl transition" aria-label="Toggle Menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <!-- Sidebar Navigation -->
        <nav id="sidebar" class="sidebar w-64 bg-slate-950 text-white flex flex-col justify-between h-screen sticky top-0 z-30 shrink-0 shadow-2xl transition-all duration-300">
            <div>
                <!-- Logo -->
                <div class="p-6 border-b border-slate-900/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-600 p-2.5 rounded-xl text-white shadow-lg shadow-indigo-600/30">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold tracking-wider bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">SIMAK</h1>
                            <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mt-0.5">Akademik Portal</p>
                        </div>
                    </div>
                    <!-- Close button on mobile -->
                    <button id="close-sidebar" class="p-2 text-slate-400 hover:text-white md:hidden focus:outline-none hover:bg-slate-800 rounded-xl transition" aria-label="Close Menu">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Menu Items -->
                <ul class="space-y-1.5 p-4 overflow-y-auto">
                    <!-- Dashboard (All Roles) -->
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Mahasiswa (Admin & Dosen) -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'dosen')
                    <li>
                        <a href="{{ route('mahasiswa.index') }}" 
                           class="sidebar-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Mahasiswa
                        </a>
                    </li>
                    @endif

                    <!-- Mata Kuliah (Admin & Dosen) -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'dosen')
                    <li>
                        <a href="{{ route('mata-kuliah.index') }}" 
                           class="sidebar-link {{ request()->routeIs('mata-kuliah.*') ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Mata Kuliah
                        </a>
                    </li>
                    @endif

                    <!-- Jadwal (All Roles - dynamic target / filter) -->
                    <li>
                        <a href="{{ route('jadwal.index') }}" 
                           class="sidebar-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jadwal Kuliah
                        </a>
                    </li>

                    <!-- Nilai (Admin & Dosen) -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'dosen')
                    <li>
                        <a href="{{ route('nilai.index') }}" 
                           class="sidebar-link {{ request()->routeIs('nilai.*') && !request()->routeIs('nilai.rekap') ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Input Nilai
                        </a>
                    </li>
                    @endif

                    <!-- Rekap Nilai (All Roles) -->
                    <li>
                        <a href="{{ auth()->user()->isMahasiswa() ? route('nilai.rekap') : route('nilai.rekap') }}" 
                           class="sidebar-link {{ request()->routeIs('nilai.rekap') ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Rekap Nilai
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Profile Section in Sidebar -->
            <div class="p-4 border-t border-slate-900 bg-slate-950/40">
                <div class="flex items-center justify-between gap-3 p-2 rounded-xl bg-white/5 border border-white/5 backdrop-blur-md">
                    <div class="overflow-hidden flex items-center gap-2">
                        <div class="h-9 w-9 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold font-mono">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="font-semibold text-white text-xs truncate max-w-[110px]">{{ auth()->user()->name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-indigo-400/10 text-indigo-400 uppercase tracking-wide mt-0.5">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all cursor-pointer" title="Keluar">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Overlay backdrop on mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-20 hidden md:hidden"></div>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0 bg-[#F8FAFC] pb-12">
            @yield('content')
        </main>
    </div>

    <!-- Script for mobile sidebar toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger-menu');
            const closeBtn = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleMenu() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('hidden');
            }

            if(hamburger) hamburger.addEventListener('click', toggleMenu);
            if(closeBtn) closeBtn.addEventListener('click', toggleMenu);
            if(overlay) overlay.addEventListener('click', toggleMenu);
        });
    </script>
</body>
</html>
