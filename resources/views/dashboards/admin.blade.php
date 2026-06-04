<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">📊 Dashboard Admin</h1>
                <p class="text-sm text-slate-500 mt-1">Sistem Manajemen Akademik SIMAK • Halaman Utama Administrator</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wider">
                    Tahun Akademik: 2024/2025
                </span>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Mahasiswa -->
            <div class="card hover:shadow-xl hover:shadow-indigo-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Mahasiswa</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $totalMahasiswa }}</p>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Siswa aktif terdaftar</p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-500 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Mata Kuliah -->
            <div class="card hover:shadow-xl hover:shadow-emerald-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Mata Kuliah</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-emerald-600 transition-colors">{{ $totalMataKuliah }}</p>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Kurikulum aktif</p>
                    </div>
                    <div class="bg-emerald-50 p-4 rounded-2xl text-emerald-500 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Nilai -->
            <div class="card hover:shadow-xl hover:shadow-violet-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Nilai Terisi</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-violet-600 transition-colors">{{ $totalNilai }}</p>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Lembar nilai mahasiswa</p>
                    </div>
                    <div class="bg-violet-50 p-4 rounded-2xl text-violet-500 shadow-inner group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Chart 1: Distribusi Grade -->
            <div class="card border border-slate-100/60 shadow-md">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                    <span class="p-2 bg-indigo-50 rounded-lg text-indigo-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </span>
                    <h2 class="text-lg font-bold text-slate-800">Distribusi Grade Nilai</h2>
                </div>
                <div class="relative min-h-[280px] flex items-center justify-center">
                    <canvas id="chartDistribusi" class="max-h-[260px]"></canvas>
                </div>
            </div>

            <!-- Chart 2: Rata-rata per Jurusan -->
            <div class="card border border-slate-100/60 shadow-md">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                    <span class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </span>
                    <h2 class="text-lg font-bold text-slate-800">Rata-rata Nilai per Jurusan</h2>
                </div>
                <div class="relative min-h-[280px] flex items-center justify-center">
                    <canvas id="chartJurusan" class="max-h-[260px]"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Mahasiswa -->
        <div class="card border border-slate-100/60 shadow-md">
            <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                <span class="p-2 bg-amber-50 rounded-lg text-amber-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-slate-800">Top 5 Mahasiswa Berprestasi</h2>
            </div>
            <div class="space-y-4">
                @forelse($topMahasiswa as $index => $item)
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-indigo-50/20 hover:border-indigo-100 transition-all duration-200">
                        <div class="flex items-center gap-4">
                            <!-- Medal badge -->
                            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm">
                                <span class="text-lg font-extrabold 
                                    @if($index == 0) text-amber-500
                                    @elseif($index == 1) text-slate-400
                                    @elseif($index == 2) text-amber-700
                                    @else text-indigo-500 @endif">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm sm:text-base">{{ $item->mahasiswa->nama }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ $item->mahasiswa->nim }} • <span class="text-slate-600 font-semibold">{{ $item->mataKuliah->nama_mk }}</span></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-extrabold text-indigo-600 tracking-tight">{{ number_format($item->nilai_akhir, 2) }}</p>
                            @php($grade = strtoupper($item->grade))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold mt-1
                                @if(in_array($grade, ['A', 'A-'])) badge-grade-a
                                @elseif(in_array($grade, ['B+', 'B', 'B-'])) badge-grade-b
                                @elseif(in_array($grade, ['C+', 'C'])) badge-grade-c
                                @elseif($grade === 'D') badge-grade-d
                                @else badge-grade-e @endif">
                                Grade: {{ $item->grade }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm text-center py-6">Belum ada data prestasi mahasiswa terisi.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart 1: Distribusi Grade
        const ctxDistribusi = document.getElementById('chartDistribusi').getContext('2d');
        new Chart(ctxDistribusi, {
            type: 'doughnut',
            data: {
                labels: ['Grade A', 'Grade B', 'Grade C', 'Grade D', 'Grade E'],
                datasets: [{
                    data: [
                        {{ $nilaiDistribusi['A'] }},
                        {{ $nilaiDistribusi['B'] }},
                        {{ $nilaiDistribusi['C'] }},
                        {{ $nilaiDistribusi['D'] }},
                        {{ $nilaiDistribusi['E'] }}
                    ],
                    backgroundColor: [
                        '#10B981', // Emerald A
                        '#3B82F6', // Blue B
                        '#F59E0B', // Amber C
                        '#F97316', // Orange D
                        '#EF4444'  // Rose E
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: '500'
                            },
                            color: '#475569',
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Chart 2: Rata-rata per Jurusan
        const ctxJurusan = document.getElementById('chartJurusan').getContext('2d');
        
        // Dynamic colors per bar
        const gradient = ctxJurusan.createLinearGradient(0, 0, 400, 0);
        gradient.addColorStop(0, '#4F46E5');
        gradient.addColorStop(1, '#6366F1');

        new Chart(ctxJurusan, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($nilaiPerJurusan as $item)
                        '{{ $item->jurusan }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: [
                        @foreach($nilaiPerJurusan as $item)
                            {{ $item->rata_rata }},
                        @endforeach
                    ],
                    backgroundColor: gradient,
                    borderRadius: 10,
                    borderSkipped: false,
                    barThickness: 24
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        max: 100,
                        grid: {
                            color: '#F1F5F9'
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 10,
                                weight: '500'
                            },
                            color: '#64748B'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: '600'
                            },
                            color: '#334155'
                        }
                    }
                }
            }
        });
    });
</script>
