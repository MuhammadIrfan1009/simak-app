@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Detail Mahasiswa"
            subtitle="Data lengkap dan transkrip nilai mahasiswa."
            :paths="['M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z']"
        >
            @if (auth()->user()->isAdmin())
                <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-primary">Edit</a>
            @endif
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </x-page-header>

        {{-- Info Card --}}
        <div class="card mb-6">
            <x-card-header
                color="indigo"
                title="Informasi Pribadi"
                :paths="['M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z']"
            />
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                @foreach ([
                    'NIM'       => $mahasiswa->nim,
                    'Nama'      => $mahasiswa->nama,
                    'Email'     => $mahasiswa->email,
                    'Jurusan'   => $mahasiswa->jurusan,
                    'Angkatan'  => $mahasiswa->angkatan,
                    'Telepon'   => $mahasiswa->no_telepon ?? '—',
                ] as $fieldLabel => $fieldValue)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $fieldLabel }}</dt>
                        <dd class="mt-1 text-base font-semibold text-slate-800">{{ $fieldValue }}</dd>
                    </div>
                @endforeach
                <div class="md:col-span-2">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-800">{{ $mahasiswa->alamat ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Nilai Card --}}
        <div class="card">
            <x-card-header
                color="emerald"
                title="Nilai Per Semester"
                :paths="['M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z']"
            />

            {{-- Semester filter --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
                <p class="text-sm text-slate-500">
                    Pilih "Lihat Semua" atau satu semester tertentu untuk melihat detail.
                </p>
                <form method="GET" action="{{ route('mahasiswa.show', $mahasiswa) }}"
                      class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-2 shadow-sm shrink-0">
                    <label for="semester" class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Filter</label>
                    <select id="semester" name="semester" onchange="this.form.submit()"
                            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                        <option value="" {{ ($selectedSemester === null || $selectedSemester === '') ? 'selected' : '' }}>
                            Lihat Semua
                        </option>
                        @foreach ($availableSemesters as $semester)
                            <option value="{{ $semester }}" {{ (string) $selectedSemester === (string) $semester ? 'selected' : '' }}>
                                Semester {{ $semester }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if ($mahasiswa->nilais->isEmpty())
                <x-alert type="warning" message="Belum ada data nilai untuk mahasiswa ini." />
            @else
                {{-- KPI row --}}
                <div class="grid gap-4 md:grid-cols-3 mb-6">
                    <x-stat-mini label="Total Semester" :value="$semesterSummaries->count()" color="indigo" />
                    <x-stat-mini label="Total SKS"      :value="$totalSksAll"                 color="emerald" />
                    <x-stat-mini label="IPK Kumulatif"  :value="number_format($ipk, 2)"       color="rose" />
                </div>

                @if ($selectedSemester !== null && $selectedSemester !== '')
                    <div class="mb-4">
                        <x-alert type="info">
                            Menampilkan hasil untuk <strong>Semester {{ $selectedSemester }}</strong>.
                            Pilih <em>Lihat Semua</em> untuk kembali ke ringkasan seluruh semester.
                        </x-alert>
                    </div>
                @endif

                <div class="space-y-6">
                    @foreach ($semesterSummaries as $summary)
                        <article class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">

                            {{-- Semester header --}}
                            <div class="border-b border-slate-100 px-5 py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.25em] text-indigo-500">Semester {{ $summary['semester'] }}</p>
                                    <h3 class="text-xl font-bold text-slate-900">IP Semester: {{ number_format($summary['ip'], 2) }}</h3>
                                    <p class="text-sm text-slate-500">{{ $summary['totalSks'] }} SKS • {{ $summary['items']->count() }} mata kuliah</p>
                                </div>
                                <div class="w-full md:w-64">
                                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                        <span>Progress IP</span>
                                        <span>{{ number_format($summary['ip'], 2) }}/4.00</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full rounded-full bg-indigo-500"
                                             style="width: {{ number_format($summary['progress'], 2) }}%"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Nilai table --}}
                            <div class="overflow-x-auto p-5">
                                <table class="min-w-full divide-y divide-slate-100 text-sm">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Mata Kuliah</th>
                                            <th class="px-4 py-3 text-center font-semibold text-slate-500">SKS</th>
                                            <th class="px-4 py-3 text-center font-semibold text-slate-500">Nilai Akhir</th>
                                            <th class="px-4 py-3 text-center font-semibold text-slate-500">Grade</th>
                                            <th class="px-4 py-3 text-center font-semibold text-slate-500">Indeks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @foreach ($summary['items'] as $nilai)
                                            @php
                                                $gradeClass = match (strtoupper($nilai->grade)) {
                                                    'A', 'A-'         => 'bg-emerald-50 text-emerald-700',
                                                    'B+', 'B', 'B-'   => 'bg-sky-50 text-sky-700',
                                                    'C+', 'C'         => 'bg-amber-50 text-amber-700',
                                                    'D'               => 'bg-orange-50 text-orange-700',
                                                    default           => 'bg-rose-50 text-rose-700',
                                                };
                                            @endphp
                                            <tr class="hover:bg-slate-50/80">
                                                <td class="px-4 py-3 text-slate-700">{{ $nilai->mataKuliah->nama_mk ?? '—' }}</td>
                                                <td class="px-4 py-3 text-center text-slate-700">{{ $nilai->mataKuliah->sks ?? 0 }}</td>
                                                <td class="px-4 py-3 text-center font-semibold text-slate-800">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $gradeClass }}">
                                                        {{ $nilai->grade }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-center text-slate-700">{{ number_format($nilai->indeks ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
