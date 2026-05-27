@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <h1 class="text-4xl font-bold text-gray-900 mb-8">📊 Dashboard</h1>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Mahasiswa -->
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Mahasiswa</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalMahasiswa }}</p>
                    </div>
                    <div class="text-5xl opacity-20">👥</div>
                </div>
            </div>

            <!-- Total Mata Kuliah -->
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Mata Kuliah</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalMataKuliah }}</p>
                    </div>
                    <div class="text-5xl opacity-20">📚</div>
                </div>
            </div>

            <!-- Total Nilai -->
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Nilai Terisi</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalNilai }}</p>
                    </div>
                    <div class="text-5xl opacity-20">📝</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Chart 1: Distribusi Grade -->
            <div class="card">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">📊 Distribusi Grade</h2>
                <canvas id="chartDistribusi" class="mx-auto"></canvas>
            </div>

            <!-- Chart 2: Rata-rata per Jurusan -->
            <div class="card">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">📈 Rata-rata Nilai per Jurusan</h2>
                <canvas id="chartJurusan" class="mx-auto"></canvas>
            </div>
        </div>

        <!-- Top Mahasiswa -->
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">🏆 Top 5 Mahasiswa Berprestasi</h2>
            <div class="space-y-4">
                @foreach($topMahasiswa as $index => $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl font-bold text-primary">{{ $index + 1 }}</span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item->mahasiswa->nama }}</p>
                                <p class="text-sm text-gray-600">{{ $item->mahasiswa->nim }} - {{ $item->mataKuliah->nama_mk }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-primary">{{ number_format($item->nilai_akhir, 2) }}</p>
                            <p class="text-sm text-gray-600">Grade: <span class="font-semibold">{{ $item->grade }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
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
                    '#10B981', // Green for A
                    '#3B82F6', // Blue for B
                    '#F59E0B', // Amber for C
                    '#EF4444', // Red for D
                    '#6B7280'  // Gray for E
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Chart 2: Rata-rata per Jurusan
    const ctxJurusan = document.getElementById('chartJurusan').getContext('2d');
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
                backgroundColor: '#0D9488',
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    max: 100
                }
            }
        }
    });
</script>
@endsection
