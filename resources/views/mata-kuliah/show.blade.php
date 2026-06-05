@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Detail Mata Kuliah"
            subtitle="Informasi lengkap mata kuliah dan dosen pengampu."
            :paths="['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253']"
        >
            @if (auth()->user()->isAdmin())
                <a href="{{ route('mata-kuliah.edit', $mataKuliah) }}" class="btn btn-primary">Edit</a>
            @endif
            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
        </x-page-header>

        {{-- Info Card --}}
        <div class="card mb-6">
            <x-card-header
                color="indigo"
                title="Informasi Mata Kuliah"
                :paths="['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253']"
            />
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                @foreach ([
                    'Kode MK'  => $mataKuliah->kode_mk,
                    'Nama MK'  => $mataKuliah->nama_mk,
                    'SKS'      => $mataKuliah->sks,
                    'Semester' => $mataKuliah->semester,
                ] as $fieldLabel => $fieldValue)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $fieldLabel }}</dt>
                        <dd class="mt-1 text-base font-semibold text-slate-800">{{ $fieldValue }}</dd>
                    </div>
                @endforeach

                <div class="sm:col-span-2">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Dosen Pengampu</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-800">{{ $mataKuliah->dosen->name ?? '—' }}</dd>
                    @if ($mataKuliah->dosen?->email)
                        <dd class="text-sm text-slate-500">{{ $mataKuliah->dosen->email }}</dd>
                    @endif
                </div>
            </dl>
        </div>

        {{-- Jadwal & Nilai --}}
        <div class="grid gap-6 sm:grid-cols-2">

            {{-- Jadwal --}}
            <div class="card">
                <x-card-header
                    color="emerald"
                    title="Jadwal"
                    :paths="['M8 7V3m8 4V3M4 11h16M5 19h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1Z']"
                />
                @if ($mataKuliah->jadwals->isEmpty())
                    <x-empty-state text="Belum ada jadwal untuk mata kuliah ini." />
                @else
                    <ul class="space-y-3">
                        @foreach ($mataKuliah->jadwals as $jadwal)
                            <x-schedule-row :item="$jadwal" accent="emerald" />
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Nilai --}}
            <div class="card">
                <x-card-header
                    color="violet"
                    title="Nilai Terkait"
                    :paths="['M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z']"
                />
                @if ($mataKuliah->nilais->isEmpty())
                    <x-empty-state text="Belum ada nilai yang tercatat." />
                @else
                    <ul class="space-y-2">
                        @foreach ($mataKuliah->nilais as $nilai)
                            <li class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-xl text-sm">
                                <span class="font-medium text-slate-700">{{ $nilai->mahasiswa->nama ?? 'N/A' }}</span>
                                <span class="flex items-center gap-2">
                                    <span class="text-slate-500">{{ number_format($nilai->nilai_akhir, 2) }}</span>
                                    @php
                                        $gradeClass = match (strtoupper($nilai->grade)) {
                                            'A', 'A-'         => 'bg-emerald-50 text-emerald-700',
                                            'B+', 'B', 'B-'   => 'bg-sky-50 text-sky-700',
                                            'C+', 'C'         => 'bg-amber-50 text-amber-700',
                                            'D'               => 'bg-orange-50 text-orange-700',
                                            default           => 'bg-rose-50 text-rose-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $gradeClass }}">
                                        {{ $nilai->grade }}
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
