@php
    $kpiCards = [
        [
            'label' => 'Total SKS Diampu',
            'value' => "$totalSks SKS",
            'sub'   => 'Beban mengajar semester ini',
            'color' => 'indigo',
            'icon'  => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'label' => 'Mata Kuliah Diampu',
            'value' => "$totalMatakuliah Kelas",
            'sub'   => 'Kelas aktif yang diajar',
            'color' => 'emerald',
            'icon'  => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        [
            'label' => 'Mahasiswa Diajar',
            'value' => "$totalStudents Orang",
            'sub'   => 'Total mahasiswa unik kelas Anda',
            'color' => 'violet',
            'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        ],
    ];

    $gradeColors = [
        'A' => 'emerald', 'B' => 'blue',
        'C' => 'amber',   'D' => 'orange', 'E' => 'red',
    ];
@endphp

<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <x-page-header
            title="Portal Dosen"
            :subtitle="'Selamat datang kembali, ' . auth()->user()->name . '. Kelola kegiatan belajar mengajar Anda di sini.'"
            color="indigo"
            :paths="['M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z']"
        >
            <a href="{{ route('nilai.create') }}" class="btn btn-primary">
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Input Nilai Mahasiswa
            </a>
        </x-page-header>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach ($kpiCards as $card)
                <x-kpi-card :card="$card" />
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            {{-- Left 2 cols: Jadwal & Mata Kuliah --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Jadwal Mengajar --}}
                <div class="card border border-slate-100/60 shadow-md">
                    <x-card-header
                        color="indigo"
                        title="Jadwal Mengajar"
                        :paths="['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z']"
                    />
                    <div class="space-y-4">
                        @forelse ($schedules as $item)
                            <x-schedule-row :item="$item" accent="indigo" />
                        @empty
                            <x-empty-state text="Belum ada jadwal mengajar terdaftar." />
                        @endforelse
                    </div>
                </div>

                {{-- Mata Kuliah Diampu --}}
                <div class="card border border-slate-100/60 shadow-md">
                    <x-card-header
                        color="emerald"
                        title="Mata Kuliah yang Diampu"
                        :paths="['M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10']"
                    />
                    <div class="table-container">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    @foreach (['Kode', 'Nama Mata Kuliah', 'SKS', 'Semester', 'Mahasiswa'] as $i => $th)
                                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider {{ $i < 2 ? 'text-left' : 'text-center' }}">
                                            {{ $th }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($coursesList as $course)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-5 py-4 text-sm font-mono font-bold text-slate-900">{{ $course->kode_mk }}</td>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-800">{{ $course->nama_mk }}</td>
                                        <td class="px-5 py-4 text-sm text-center font-bold text-indigo-600">{{ $course->sks }}</td>
                                        <td class="px-5 py-4 text-sm text-center text-slate-600">{{ $course->semester }}</td>
                                        <td class="px-5 py-4 text-sm text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                                {{ $course->student_count }} Mahasiswa
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-400">
                                            Tidak ada kelas yang diampu semester ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Right 1 col: Distribusi Nilai --}}
            <div class="card border border-slate-100/60 shadow-md">
                <x-card-header
                    color="violet"
                    title="Distribusi Nilai Mahasiswa"
                    :paths="['M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z', 'M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z']"
                />

                <div class="relative min-h-[250px] flex items-center justify-center">
                    <canvas id="chartDosenGrade" class="max-h-[240px]"></canvas>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-50 space-y-2">
                    @foreach ($gradeColors as $grade => $color)
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-{{ $color }}-500"></span>
                                Grade {{ $grade }}
                            </span>
                            <span class="text-slate-800 font-bold">{{ $gradeDistribution[$grade] }} Mahasiswa</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    new Chart(document.getElementById('chartDosenGrade'), {
        type: 'doughnut',
        data: {
            labels: ['Grade A', 'Grade B', 'Grade C', 'Grade D', 'Grade E'],
            datasets: [{
                data: @json(array_values($gradeDistribution)),
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#F97316', '#EF4444'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 4,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: false } },
        },
    });
});
</script>
@endpush
