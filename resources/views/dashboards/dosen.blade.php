<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl flex items-center gap-3"><svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z"/></svg> Portal Dosen</h1>
                <p class="text-sm text-slate-500 mt-1">Selamat datang kembali, <span class="font-bold text-slate-800">{{ auth()->user()->name }}</span>. Kelola kegiatan belajar mengajar Anda di sini.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('nilai.create') }}" class="btn btn-primary">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Input Nilai Mahasiswa
                </a>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total SKS -->
            <div class="card hover:shadow-xl hover:shadow-indigo-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total SKS Diampu</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $totalSks }} SKS</p>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Beban mengajar semester ini</p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-500 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Mata Kuliah -->
            <div class="card hover:shadow-xl hover:shadow-emerald-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Mata Kuliah Diampu</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-emerald-600 transition-colors">{{ $totalMatakuliah }} Kelas</p>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Kelas aktif yang diajar</p>
                    </div>
                    <div class="bg-emerald-50 p-4 rounded-2xl text-emerald-500 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="card hover:shadow-xl hover:shadow-violet-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Mahasiswa Diajar</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-violet-600 transition-colors">{{ $totalStudents }} Orang</p>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Total mahasiswa unik kelas Anda</p>
                    </div>
                    <div class="bg-violet-50 p-4 rounded-2xl text-violet-500 shadow-inner group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Left 2 Cols: Schedule & Courses -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Teaching Schedule -->
                <div class="card border border-slate-100/60 shadow-md">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                        <span class="p-2 bg-indigo-50 rounded-lg text-indigo-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-800 font-sans">Jadwal Mengajar</h2>
                    </div>
                    <div class="space-y-4">
                        @forelse($schedules as $item)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-indigo-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center font-bold font-mono text-sm">
                                        {{ $item->mataKuliah->sks }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm sm:text-base leading-tight">{{ $item->mataKuliah->nama_mk }}</p>
                                        <p class="text-xs text-slate-500 mt-1 font-medium">{{ $item->mataKuliah->kode_mk }} • {{ $item->ruangan }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 sm:mt-0 flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 bg-white border border-slate-200 px-3 py-1.5 rounded-xl shadow-xs self-start sm:self-auto">
                                    <span class="inline-flex items-center gap-1"><svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 19h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1Z"/></svg> {{ $item->hari }}</span>
                                    <span class="text-slate-300">|</span>
                                    <span class="inline-flex items-center gap-1"><svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">Belum ada jadwal mengajar terdaftar.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Teaching Classes Table -->
                <div class="card border border-slate-100/60 shadow-md">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                        <span class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-800 font-sans">Mata Kuliah yang Diampu</h2>
                    </div>
                    <div class="table-container">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Mata Kuliah</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">SKS</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Semester</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($coursesList as $course)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-5 py-4 text-sm font-mono font-bold text-slate-900">{{ $course->kode_mk }}</td>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-800">{{ $course->nama_mk }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-bold text-indigo-600 bg-indigo-50/20 rounded-lg max-w-[40px] mx-auto">{{ $course->sks }}</td>
                                        <td class="px-5 py-4 text-sm text-center text-slate-600">{{ $course->semester }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-800">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                                {{ $course->student_count }} Mahasiswa
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-400">Tidak ada kelas yang diampu semester ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right 1 Col: Grade Distribution Chart -->
            <div class="space-y-8">
                
                <div class="card border border-slate-100/60 shadow-md h-full">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                        <span class="p-2 bg-violet-50 rounded-lg text-violet-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-800">Distribusi Nilai Mahasiswa</h2>
                    </div>
                    <div class="relative min-h-[250px] flex items-center justify-center">
                        <canvas id="chartDosenGrade" class="max-h-[240px]"></canvas>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-50 space-y-2">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Grade A</span>
                            <span class="text-slate-800 font-bold">{{ $gradeDistribution['A'] }} Mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span> Grade B</span>
                            <span class="text-slate-800 font-bold">{{ $gradeDistribution['B'] }} Mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> Grade C</span>
                            <span class="text-slate-800 font-bold">{{ $gradeDistribution['C'] }} Mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span> Grade D</span>
                            <span class="text-slate-800 font-bold">{{ $gradeDistribution['D'] }} Mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-red-500"></span> Grade E</span>
                            <span class="text-slate-800 font-bold">{{ $gradeDistribution['E'] }} Mahasiswa</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxDosenDist = document.getElementById('chartDosenGrade').getContext('2d');
        new Chart(ctxDosenDist, {
            type: 'doughnut',
            data: {
                labels: ['Grade A', 'Grade B', 'Grade C', 'Grade D', 'Grade E'],
                datasets: [{
                    data: [
                        {{ $gradeDistribution['A'] }},
                        {{ $gradeDistribution['B'] }},
                        {{ $gradeDistribution['C'] }},
                        {{ $gradeDistribution['D'] }},
                        {{ $gradeDistribution['E'] }}
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
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
