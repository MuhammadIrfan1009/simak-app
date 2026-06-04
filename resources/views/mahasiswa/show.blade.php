@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">👤 Detail Mahasiswa</h1>
                <p class="text-sm text-gray-500">Menampilkan data lengkap dan nilai mahasiswa.</p>
            </div>
            <div class="flex gap-2">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-primary">Edit</a>
                @endif
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <div>
                    <p class="text-sm text-gray-500">NIM</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->nim }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jurusan</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->jurusan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Angkatan</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->angkatan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->no_telepon ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold">Nilai Per Semester</h2>
                        <p class="text-sm text-gray-500">Pilih “Lihat Semua” atau satu semester tertentu untuk melihat detail yang lebih ringkas.</p>
                    </div>
                    <form method="GET" action="{{ route('mahasiswa.show', $mahasiswa) }}" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-2 shadow-sm">
                        <label for="semester" class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Filter</label>
                        <select id="semester" name="semester" onchange="this.form.submit()" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                            <option value="" {{ $selectedSemester === null || $selectedSemester === '' ? 'selected' : '' }}>Lihat Semua</option>
                            @foreach($availableSemesters as $semester)
                                <option value="{{ $semester }}" {{ (string) $selectedSemester === (string) $semester ? 'selected' : '' }}>Semester {{ $semester }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if($mahasiswa->nilais->isEmpty())
                    <div class="p-6 bg-yellow-50 rounded-lg text-yellow-800">
                        Belum ada data nilai untuk mahasiswa ini.
                    </div>
                @else
                    <div class="grid gap-4 md:grid-cols-3 mb-6">
                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-4 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.25em] text-indigo-500">Total Semester</p>
                            <p class="mt-2 text-3xl font-extrabold text-indigo-700">{{ $semesterSummaries->count() }}</p>
                        </div>
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.25em] text-emerald-500">Total SKS</p>
                            <p class="mt-2 text-3xl font-extrabold text-emerald-700">{{ $totalSksAll }}</p>
                        </div>
                        <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.25em] text-rose-500">IPK Kumulatif</p>
                            <p class="mt-2 text-3xl font-extrabold text-rose-700">{{ number_format($ipk, 2) }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @if($selectedSemester !== null && $selectedSemester !== '')
                            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/80 px-4 py-3 text-sm text-indigo-700">
                                Menampilkan hasil untuk <strong>Semester {{ $selectedSemester }}</strong>. Pilih “Lihat Semua” untuk kembali ke ringkasan seluruh semester.
                            </div>
                        @endif
                        @foreach($semesterSummaries as $summary)
                            <article class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
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
                                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ number_format($summary['progress'], 2) }}%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="overflow-x-auto p-5">
                                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                                        <thead class="bg-slate-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Mata Kuliah</th>
                                                <th class="px-4 py-3 text-center font-semibold text-slate-500">SKS</th>
                                                <th class="px-4 py-3 text-center font-semibold text-slate-500">Nilai Akhir</th>
                                                <th class="px-4 py-3 text-center font-semibold text-slate-500">Grade</th>
                                                <th class="px-4 py-3 text-center font-semibold text-slate-500">Bobot / Indeks</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 bg-white">
                                            @foreach($summary['items'] as $nilai)
                                                <tr class="hover:bg-slate-50/80">
                                                    <td class="px-4 py-3 text-slate-700">{{ $nilai->mataKuliah->nama_mk ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-center text-slate-700">{{ $nilai->mataKuliah->sks ?? 0 }}</td>
                                                    <td class="px-4 py-3 text-center font-semibold text-slate-800">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        @php($gradeClass = match (strtoupper($nilai->grade)) {
                                                            'A', 'A-' => 'bg-emerald-50 text-emerald-700',
                                                            'B+', 'B', 'B-' => 'bg-sky-50 text-sky-700',
                                                            'C+', 'C' => 'bg-amber-50 text-amber-700',
                                                            'D' => 'bg-orange-50 text-orange-700',
                                                            default => 'bg-rose-50 text-rose-700',
                                                        })
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
</div>
@endsection
