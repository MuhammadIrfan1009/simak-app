@if(!$mahasiswa)
<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <div class="card border-dashed border-slate-300 text-center py-12">
            <div class="h-16 w-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-100">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Profil Mahasiswa Tidak Ditemukan</h1>
            <p class="text-slate-500 mt-2 max-w-md mx-auto">Akun Anda belum terhubung dengan profil mahasiswa aktif di sistem. Hubungi bagian Administrasi Akademik untuk sinkronisasi NIM Anda.</p>
        </div>
    </div>
</div>
@else
<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">🎓 Portal Mahasiswa</h1>
                <p class="text-sm text-slate-500 mt-1">Selamat datang kembali, <span class="font-bold text-slate-800">{{ $mahasiswa->nama }}</span>. Pantau perkembangan studi Anda di sini.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('nilai.rekap') }}" class="btn btn-primary">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12" />
                    </svg>
                    Lihat KHS Lengkap
                </a>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- IPK Card -->
            <div class="card hover:shadow-xl hover:shadow-indigo-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">IPK Kumulatif</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-indigo-600 transition-colors">{{ number_format($ipk, 2) }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold mt-1.5
                            @if($ipk >= 3.51) bg-amber-50 text-amber-700 border border-amber-100
                            @elseif($ipk >= 3.00) bg-emerald-50 text-emerald-700 border border-emerald-100
                            @else bg-slate-50 text-slate-700 border border-slate-100 @endif uppercase tracking-wider">
                            @if($ipk >= 3.51) Dengan Pujian (Cum Laude)
                            @elseif($ipk >= 3.00) Sangat Memuaskan
                            @else Memuaskan @endif
                        </span>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-500 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total SKS -->
            <div class="card hover:shadow-xl hover:shadow-emerald-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Kredit SKS</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-emerald-600 transition-colors">{{ $totalSks }} SKS</p>
                        <p class="text-xs text-slate-400 mt-1.5 font-medium">SKS berhasil diselesaikan</p>
                    </div>
                    <div class="bg-emerald-50 p-4 rounded-2xl text-emerald-500 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Courses -->
            <div class="card hover:shadow-xl hover:shadow-violet-100/30 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Mata Kuliah Aktif</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-violet-600 transition-colors">{{ $activeCoursesCount }} Kelas</p>
                        <p class="text-xs text-slate-400 mt-1.5 font-medium">Mata kuliah yang sedang berjalan</p>
                    </div>
                    <div class="bg-violet-50 p-4 rounded-2xl text-violet-500 shadow-inner group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Personal info & schedules -->
            <div class="lg:col-span-1 space-y-8">
                
                <!-- Profile details -->
                <div class="card border border-slate-100/60 shadow-md">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                        <span class="p-2 bg-indigo-50 rounded-lg text-indigo-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-800">Profil Akademik</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM (Nomor Induk Mahasiswa)</p>
                            <p class="text-base font-bold font-mono text-slate-800 mt-0.5">{{ $mahasiswa->nim }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jurusan / Program Studi</p>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 mt-1 font-sans">
                                {{ $mahasiswa->jurusan }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Angkatan</p>
                            <p class="text-base font-semibold text-slate-700 mt-0.5">{{ $mahasiswa->angkatan }}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-50">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Kampus</p>
                            <p class="text-sm font-medium text-slate-600 mt-0.5 truncate">{{ $mahasiswa->email }}</p>
                        </div>
                        @if($mahasiswa->no_telepon)
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">No. Telepon</p>
                            <p class="text-sm font-medium text-slate-600 mt-0.5">{{ $mahasiswa->no_telepon }}</p>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Columns: schedules & grades -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Class Schedule -->
                <div class="card border border-slate-100/60 shadow-md">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                        <span class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-800">Jadwal Kuliah Hari Ini</h2>
                    </div>
                    <div class="space-y-4">
                        @forelse($schedules as $item)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-emerald-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center font-bold font-mono text-sm">
                                        {{ $item->mataKuliah->sks }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm sm:text-base leading-tight">{{ $item->mataKuliah->nama_mk }}</p>
                                        <p class="text-xs text-slate-500 mt-1 font-medium">{{ $item->mataKuliah->kode_mk }} • {{ $item->ruangan }}</p>
                                        <p class="text-xs text-slate-400 font-medium mt-0.5">Dosen: {{ $item->mataKuliah->dosen->name ?? 'Staf Pengajar' }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 sm:mt-0 flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 bg-white border border-slate-200 px-3 py-1.5 rounded-xl shadow-xs self-start sm:self-auto">
                                    <span class="inline-flex items-center gap-1"><svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 19h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1Z"/></svg> {{ $item->hari }}</span>
                                    <span class="text-slate-300">|</span>
                                    <span>🕒 {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">Belum ada jadwal kuliah yang terdaftar.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Grades -->
                <div class="card border border-slate-100/60 shadow-md">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
                        <span class="p-2 bg-violet-50 rounded-lg text-violet-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-800">Daftar Nilai Terbaru</h2>
                    </div>
                    <div class="table-container">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tugas</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">UTS</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">UAS</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Akhir</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Grade</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentGrades as $nilai)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-5 py-4">
                                            <p class="text-sm font-semibold text-slate-800">{{ $nilai->mataKuliah->nama_mk }}</p>
                                            <p class="text-[10px] text-slate-500 mt-0.5">{{ $nilai->mataKuliah->kode_mk }} • Semester {{ $nilai->semester }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-600">{{ number_format($nilai->nilai_tugas, 1) }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-600">{{ number_format($nilai->nilai_uts, 1) }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-600">{{ number_format($nilai->nilai_uas, 1) }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-bold text-indigo-600">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                                        <td class="px-5 py-4 text-sm text-center">
                                            @php($grade = strtoupper($nilai->grade))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                                @if(in_array($grade, ['A', 'A-'])) badge-grade-a
                                                @elseif(in_array($grade, ['B+', 'B', 'B-'])) badge-grade-b
                                                @elseif(in_array($grade, ['C+', 'C'])) badge-grade-c
                                                @elseif($grade === 'D') badge-grade-d
                                                @else badge-grade-e @endif">
                                                {{ $nilai->grade }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-400">Belum ada nilai akademik yang diinputkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
