@php
    $medalColors = ['text-amber-500', 'text-slate-400', 'text-amber-700'];

    $gradeBadge = [
        'A' => 'badge-grade-a', 'A-' => 'badge-grade-a',
        'B+' => 'badge-grade-b', 'B' => 'badge-grade-b', 'B-' => 'badge-grade-b',
        'C+' => 'badge-grade-c', 'C' => 'badge-grade-c',
        'D'  => 'badge-grade-d',
    ];

    $kpiCards = [
        [
            'label' => 'Total Mahasiswa',
            'value' => $totalMahasiswa,
            'sub'   => 'Siswa aktif terdaftar',
            'color' => 'indigo',
            'icon'  => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        ],
        [
            'label' => 'Total Mata Kuliah',
            'value' => $totalMataKuliah,
            'sub'   => 'Kurikulum aktif',
            'color' => 'emerald',
            'icon'  => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        [
            'label' => 'Total Nilai Terisi',
            'value' => $totalNilai,
            'sub'   => 'Lembar nilai mahasiswa',
            'color' => 'violet',
            'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        ],
    ];

    $chartCards = [
        [
            'id'    => 'chartDistribusi',
            'color' => 'indigo',
            'title' => 'Distribusi Grade Nilai',
            'paths' => [
                'M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z',
                'M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z',
            ],
        ],
        [
            'id'    => 'chartJurusan',
            'color' => 'emerald',
            'title' => 'Rata-rata Nilai per Jurusan',
            'paths' => [
                'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            ],
        ],
    ];
@endphp

<div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <x-page-header
            title="Dashboard Admin"
            subtitle="Sistem Manajemen Akademik SIMAK • Halaman Utama Administrator"
            color="indigo"
            :paths="['M9 17v-2m3 2v-4m3 2v-6m-9 9h12']"
        >
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wider">
                Tahun Akademik: 2024/2025
            </span>
        </x-page-header>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach ($kpiCards as $card)
                <x-kpi-card :card="$card" />
            @endforeach
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            @foreach ($chartCards as $chart)
                <div class="card border border-slate-100/60 shadow-md">
                    <x-card-header :color="$chart['color']" :title="$chart['title']" :paths="$chart['paths']" />
                    <div class="relative min-h-[280px] flex items-center justify-center">
                        <canvas id="{{ $chart['id'] }}" class="max-h-[260px]"></canvas>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Top 5 Mahasiswa Berprestasi --}}
        <div class="card border border-slate-100/60 shadow-md">
            <x-card-header
                color="amber"
                title="Top 5 Mahasiswa Berprestasi"
                :paths="['M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z']"
            />

            <div class="space-y-4">
                @forelse ($topMahasiswa as $index => $item)
                    @php $grade = strtoupper($item->grade) @endphp
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-indigo-50/20 hover:border-indigo-100 transition-all duration-200">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm">
                                <span class="text-lg font-extrabold {{ $medalColors[$index] ?? 'text-indigo-500' }}">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm sm:text-base">{{ $item->mahasiswa->nama }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                                    {{ $item->mahasiswa->nim }} •
                                    <span class="text-slate-600 font-semibold">{{ $item->mataKuliah->nama_mk }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-extrabold text-indigo-600 tracking-tight">
                                {{ number_format($item->nilai_akhir, 2) }}
                            </p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold mt-1 {{ $gradeBadge[$grade] ?? 'badge-grade-e' }}">
                                Grade: {{ $item->grade }}
                            </span>
                        </div>
                    </div>
                @empty
                    <x-empty-state text="Belum ada data prestasi mahasiswa terisi." />
                @endforelse
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tickFont = (size, weight, color = '#64748B') => ({
        font: { family: 'Inter', size, weight },
        color,
    });

    // Doughnut: Distribusi Grade
    new Chart(document.getElementById('chartDistribusi'), {
        type: 'doughnut',
        data: {
            labels: ['Grade A', 'Grade B', 'Grade C', 'Grade D', 'Grade E'],
            datasets: [{
                data: @json(array_values($nilaiDistribusi)),
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#F97316', '#EF4444'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 4,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { ...tickFont(11, '500'), color: '#475569', usePointStyle: true, padding: 15 },
                },
            },
        },
    });

    // Bar: Rata-rata Nilai per Jurusan
    const ctx = document.getElementById('chartJurusan').getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 400, 0);
    grad.addColorStop(0, '#4F46E5');
    grad.addColorStop(1, '#6366F1');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($nilaiPerJurusan->pluck('jurusan')),
            datasets: [{
                label: 'Rata-rata Nilai',
                data: @json($nilaiPerJurusan->pluck('rata_rata')),
                backgroundColor: grad,
                borderRadius: 10,
                borderSkipped: false,
                barThickness: 24,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    max: 100,
                    grid: { color: '#F1F5F9' },
                    ticks: tickFont(10, '500'),
                },
                y: {
                    grid: { display: false },
                    ticks: tickFont(11, '600', '#334155'),
                },
            },
        },
    });
});
</script>
@endpush
