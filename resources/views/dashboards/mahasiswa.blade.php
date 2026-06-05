@php
    $ipkLabel = match(true) {
        $ipk >= 3.51 => ['text' => 'Dengan Pujian (Cum Laude)', 'class' => 'bg-amber-50 text-amber-700 border-amber-100'],
        $ipk >= 3.00 => ['text' => 'Sangat Memuaskan',          'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100'],
        default      => ['text' => 'Memuaskan',                  'class' => 'bg-slate-50 text-slate-700 border-slate-100'],
    };

    $kpiCards = [
        [
            'label' => 'IPK Kumulatif',
            'value' => number_format($ipk, 2),
            'sub'   => null,
            'badge' => $ipkLabel,
            'color' => 'indigo',
            'icon'  => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
        ],
        [
            'label' => 'Total Kredit SKS',
            'value' => "$totalSks SKS",
            'sub'   => 'SKS berhasil diselesaikan',
            'badge' => null,
            'color' => 'emerald',
            'icon'  => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        [
            'label' => 'Mata Kuliah Aktif',
            'value' => "$activeCoursesCount Kelas",
            'sub'   => 'Mata kuliah yang sedang berjalan',
            'badge' => null,
            'color' => 'violet',
            'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
    ];

    $gradeBadge = [
        'A' => 'badge-grade-a', 'A-' => 'badge-grade-a',
        'B+' => 'badge-grade-b', 'B' => 'badge-grade-b', 'B-' => 'badge-grade-b',
        'C+' => 'badge-grade-c', 'C' => 'badge-grade-c',
        'D'  => 'badge-grade-d',
    ];
@endphp

{{-- State: Profil tidak ditemukan --}}
@if (!$mahasiswa)
    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">
            <div class="card border-dashed border-slate-300 text-center py-12">
                <div class="h-16 w-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-100">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-800">Profil Mahasiswa Tidak Ditemukan</h1>
                <p class="text-slate-500 mt-2 max-w-md mx-auto">
                    Akun Anda belum terhubung dengan profil mahasiswa aktif di sistem.
                    Hubungi bagian Administrasi Akademik untuk sinkronisasi NIM Anda.
                </p>
            </div>
        </div>
    </div>

@else

<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <x-page-header
            title="Portal Mahasiswa"
            :subtitle="'Selamat datang kembali, ' . $mahasiswa->nama . '. Pantau perkembangan studi Anda di sini.'"
            color="indigo"
            :paths="['M12 14l9-5-9-5-9 5 9 5z', 'M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z']"
        >
            <a href="{{ route('nilai.rekap') }}" class="btn btn-primary">
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12" />
                </svg>
                Lihat KHS Lengkap
            </a>
        </x-page-header>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach ($kpiCards as $card)
                <x-kpi-card :card="$card" />
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Profil Akademik --}}
            <div class="lg:col-span-1">
                <div class="card border border-slate-100/60 shadow-md">
                    <x-card-header
                        color="indigo"
                        title="Profil Akademik"
                        :paths="['M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z']"
                    />

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM</p>
                            <p class="text-base font-bold font-mono text-slate-800 mt-0.5">{{ $mahasiswa->nim }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jurusan / Program Studi</p>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 mt-1">
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
                        @if ($mahasiswa->no_telepon)
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">No. Telepon</p>
                                <p class="text-sm font-medium text-slate-600 mt-0.5">{{ $mahasiswa->no_telepon }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Jadwal & Nilai --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Jadwal Kuliah --}}
                <div class="card border border-slate-100/60 shadow-md">
                    <x-card-header
                        color="emerald"
                        title="Jadwal Kuliah Hari Ini"
                        :paths="['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z']"
                    />
                    <div class="space-y-4">
                        @forelse ($schedules as $item)
                            <x-schedule-row :item="$item" accent="emerald" :show-dosen="true" />
                        @empty
                            <x-empty-state text="Belum ada jadwal kuliah yang terdaftar." />
                        @endforelse
                    </div>
                </div>

                {{-- Daftar Nilai Terbaru --}}
                <div class="card border border-slate-100/60 shadow-md">
                    <x-card-header
                        color="violet"
                        title="Daftar Nilai Terbaru"
                        :paths="['M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z']"
                    />
                    <div class="table-container">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    @foreach (['Mata Kuliah', 'Tugas', 'UTS', 'UAS', 'Akhir', 'Grade'] as $i => $th)
                                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider {{ $i === 0 ? 'text-left' : 'text-center' }}">
                                            {{ $th }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($recentGrades as $nilai)
                                    @php $grade = strtoupper($nilai->grade) @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-5 py-4">
                                            <p class="text-sm font-semibold text-slate-800">{{ $nilai->mataKuliah->nama_mk }}</p>
                                            <p class="text-[10px] text-slate-500 mt-0.5">
                                                {{ $nilai->mataKuliah->kode_mk }} • Semester {{ $nilai->semester }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-600">{{ number_format($nilai->nilai_tugas, 1) }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-600">{{ number_format($nilai->nilai_uts, 1) }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-medium text-slate-600">{{ number_format($nilai->nilai_uas, 1) }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-bold text-indigo-600">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                                        <td class="px-5 py-4 text-sm text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $gradeBadge[$grade] ?? 'badge-grade-e' }}">
                                                {{ $nilai->grade }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-400">
                                            Belum ada nilai akademik yang diinputkan.
                                        </td>
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
