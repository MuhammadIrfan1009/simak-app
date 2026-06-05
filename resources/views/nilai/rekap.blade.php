@extends('layouts.app')

@section('title', 'Rekap Nilai Akademik - SIMAK')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Transkrip Nilai Semester"
            subtitle="Semester {{ $request->semester }} · {{ $mahasiswa->nama }}"
            color="indigo"
            :paths="['M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6Zm3 3h10M7 12h6M7 15h4']"
        >
            <a href="{{ route('nilai.rekap') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('nilai.export-pdf', ['mahasiswa_id' => $mahasiswa->id, 'semester' => $request->semester]) }}"
               class="btn btn-primary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                </svg>
                Unduh PDF
            </a>
        </x-page-header>

        {{-- Profil Mahasiswa --}}
        <div class="card mb-8">
            <x-card-header color="indigo" title="Profil Mahasiswa"
                           :paths="['M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z']" />
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ([
                    'Nama Lengkap'              => $mahasiswa->nama,
                    'NIM'                       => $mahasiswa->nim,
                    'Program Studi / Jurusan'   => $mahasiswa->jurusan,
                    'Angkatan'                  => $mahasiswa->angkatan,
                ] as $label => $val)
                    <div>
                        <span class="text-xs font-medium text-gray-400 uppercase block">{{ $label }}</span>
                        <span class="text-base font-bold text-gray-900 block mt-1">{{ $val }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- KPI Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-stat-mini label="SKS Semester {{ $request->semester }}" :value="$totalSks . ' SKS'"    color="indigo" />
            <x-stat-mini label="IP Semester (IPS)"                     :value="number_format($ip, 2)" color="indigo" />
            <x-stat-mini label="Total SKS Kumulatif"                   :value="$totalSksAll . ' SKS'" color="emerald" />
            <x-stat-mini label="IP Kumulatif (IPK)"                    :value="number_format($ipk, 2)" color="rose" />
        </div>

        {{-- Tabel Nilai --}}
        <div class="card overflow-hidden">
            <x-card-header color="indigo" title="Rincian Mata Kuliah & Nilai"
                           :paths="['M3 5h18M7 9h10M7 13h6']" />

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach (['Mata Kuliah', 'SKS', 'Tugas (20%)', 'UTS (30%)', 'UAS (50%)', 'Akhir', 'Grade', 'Indeks'] as $col)
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider
                                    {{ $col === 'Mata Kuliah' ? 'text-left' : 'text-center' }}">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($nilais as $nilai)
                            @php
                                $grade      = strtoupper($nilai->grade);
                                $badgeClass = match(true) {
                                    in_array($grade, ['A', 'A-'])        => 'bg-emerald-50 text-emerald-700',
                                    in_array($grade, ['B+', 'B', 'B-'])  => 'bg-blue-50 text-blue-700',
                                    in_array($grade, ['C+', 'C'])        => 'bg-amber-50 text-amber-700',
                                    $grade === 'D'                       => 'bg-orange-50 text-orange-700',
                                    default                              => 'bg-rose-50 text-rose-700',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $nilai->mataKuliah->nama_mk }}</div>
                                    <div class="text-xs text-gray-500">{{ $nilai->mataKuliah->kode_mk }}</div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-gray-800">{{ $nilai->mataKuliah->sks }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">{{ number_format($nilai->nilai_tugas, 1) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">{{ number_format($nilai->nilai_uts, 1) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">{{ number_format($nilai->nilai_uas, 1) }}</td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-indigo-700">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $badgeClass }}">
                                        {{ $nilai->grade }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-extrabold text-gray-700">{{ number_format($nilai->indeks ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4">
                                    <x-empty-state text="Belum ada data nilai untuk semester ini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
