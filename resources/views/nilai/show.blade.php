@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4">

        <x-page-header
            title="Detil Nilai"
            subtitle="Informasi lengkap nilai mahasiswa."
            color="indigo"
            :paths="['M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z']"
        >
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/>
                </svg>
                Kembali
            </a>
        </x-page-header>

        <div class="card">
            <x-card-header
                color="indigo"
                title="Informasi Nilai"
                :paths="['M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-7-7 7 7m-7-7h7']"
            />

            <div class="grid gap-6 sm:grid-cols-2">
                @php
                    $fields = [
                        'Mahasiswa'      => $nilai->mahasiswa->nim . ' - ' . $nilai->mahasiswa->nama,
                        'Mata Kuliah'    => ($nilai->mataKuliah->kode_mk ?? '-') . ' - ' . ($nilai->mataKuliah->nama_mk ?? '-'),
                        'Dosen'          => $nilai->mataKuliah->dosen->name ?? '-',
                        'Semester'       => $nilai->semester,
                        'Tahun Akademik' => $nilai->tahun_akademik,
                        'Nilai Tugas'    => number_format($nilai->nilai_tugas, 2),
                        'Nilai UTS'      => number_format($nilai->nilai_uts, 2),
                        'Nilai UAS'      => number_format($nilai->nilai_uas, 2),
                        'Nilai Akhir'    => number_format($nilai->nilai_akhir, 2),
                        'Bobot / Indeks' => number_format($nilai->indeks ?? 0, 2),
                    ];
                @endphp

                @foreach ($fields as $label => $val)
                    <div>
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $val }}</p>
                    </div>
                @endforeach

                <div class="sm:col-span-2">
                    <p class="text-sm text-gray-500">Grade</p>
                    @php
                        $grade     = strtoupper($nilai->grade);
                        $gradeColor = match(true) {
                            in_array($grade, ['A', 'A-'])           => 'emerald',
                            in_array($grade, ['B+', 'B', 'B-'])     => 'blue',
                            in_array($grade, ['C+', 'C'])           => 'amber',
                            $grade === 'D'                          => 'orange',
                            default                                 => 'rose',
                        };
                    @endphp
                    <x-stat-mini :label="'Grade'" :value="$nilai->grade" :color="$gradeColor" />
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
