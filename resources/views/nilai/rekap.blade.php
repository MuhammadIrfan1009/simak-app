@extends('layouts.app')

@section('title', 'Rekap Nilai Akademik - SIMAK')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation & Export PDF -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('nilai.rekap') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-dark transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/></svg>
                    Kembali ke Pencarian
                </a>
                <h1 class="text-3xl font-extrabold text-gray-900 mt-2 flex items-center gap-3"><svg class="h-7 w-7 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6Zm3 3h10M7 12h6M7 15h4"/></svg> Transkrip Nilai Semester</h1>
            </div>
            <a href="{{ route('nilai.export-pdf', ['mahasiswa_id' => $mahasiswa->id, 'semester' => $request->semester]) }}" 
               class="btn btn-secondary flex items-center gap-2 hover:bg-gray-300 transition py-2.5 px-4 rounded-lg font-semibold shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                Unduh PDF Rekap Nilai
            </a>
        </div>

        <!-- Student Profile Card -->
        <div class="card mb-8 bg-white border border-gray-100 shadow-md">
            <div class="border-b border-gray-100 pb-4 mb-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary uppercase">
                    Profil Mahasiswa
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <span class="text-xs font-medium text-gray-400 uppercase block">Nama Lengkap</span>
                    <span class="text-base font-bold text-gray-900 block mt-1">{{ $mahasiswa->nama }}</span>
                </div>
                <div>
                    <span class="text-xs font-medium text-gray-400 uppercase block">Nomor Induk Mahasiswa (NIM)</span>
                    <span class="text-base font-bold text-gray-900 block mt-1">{{ $mahasiswa->nim }}</span>
                </div>
                <div>
                    <span class="text-xs font-medium text-gray-400 uppercase block">Program Studi / Jurusan</span>
                    <span class="text-base font-bold text-gray-900 block mt-1">{{ $mahasiswa->jurusan }}</span>
                </div>
                <div>
                    <span class="text-xs font-medium text-gray-400 uppercase block">Angkatan</span>
                    <span class="text-base font-bold text-gray-900 block mt-1">{{ $mahasiswa->angkatan }}</span>
                </div>
            </div>
        </div>

        <!-- GPA and Credits Stats Overview -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card bg-white border border-gray-100 shadow-sm flex flex-col justify-between">
                <span class="text-xs font-medium text-gray-400 uppercase">SKS Semester {{ $request->semester }}</span>
                <span class="text-4xl font-extrabold text-primary mt-2">{{ $totalSks }} SKS</span>
            </div>
            <div class="card bg-white border border-gray-100 shadow-sm flex flex-col justify-between">
                <span class="text-xs font-medium text-gray-400 uppercase">IP Semester (IPS)</span>
                <span class="text-4xl font-extrabold text-indigo-600 mt-2">{{ number_format($ip, 2) }}</span>
            </div>
            <div class="card bg-white border border-gray-100 shadow-sm flex flex-col justify-between">
                <span class="text-xs font-medium text-gray-400 uppercase">Total SKS Kumulatif</span>
                <span class="text-4xl font-extrabold text-emerald-600 mt-2">{{ $totalSksAll }} SKS</span>
            </div>
            <div class="card bg-white border border-gray-100 shadow-sm flex flex-col justify-between">
                <span class="text-xs font-medium text-gray-400 uppercase">IP Kumulatif (IPK)</span>
                <span class="text-4xl font-extrabold text-rose-600 mt-2">{{ number_format($ipk, 2) }}</span>
            </div>
        </div>

        <!-- Detailed Scores Table -->
        <div class="card bg-white border border-gray-100 shadow-md overflow-hidden">
            <div class="border-b border-gray-100 pb-4 mb-4 flex items-center justify-between">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 uppercase">
                    Rincian Mata Kuliah & Nilai
                </span>
                <span class="text-xs text-gray-400 font-medium">Semester {{ $request->semester }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">SKS</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Tugas (20%)</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UTS (30%)</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UAS (50%)</th>
                            <th scope="col" class="px-6 py-3.5 class text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Akhir</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Grade</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Bobot (Indeks)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($nilais as $nilai)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $nilai->mataKuliah->nama_mk }}</div>
                                    <div class="text-xs text-gray-500">{{ $nilai->mataKuliah->kode_mk }}</div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-semibold text-gray-800">
                                    {{ $nilai->mataKuliah->sks }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                                    {{ number_format($nilai->nilai_tugas, 1) }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                                    {{ number_format($nilai->nilai_uts, 1) }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                                    {{ number_format($nilai->nilai_uas, 1) }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-bold text-indigo-700">
                                    {{ number_format($nilai->nilai_akhir, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @php($grade = strtoupper($nilai->grade))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                        @if(in_array($grade, ['A', 'A-'])) bg-emerald-50 text-emerald-700
                                        @elseif(in_array($grade, ['B+', 'B', 'B-'])) bg-blue-50 text-blue-700
                                        @elseif(in_array($grade, ['C+', 'C'])) bg-amber-50 text-amber-700
                                        @elseif($grade === 'D') bg-orange-50 text-orange-700
                                        @else bg-rose-50 text-rose-700
                                        @endif">
                                        {{ $nilai->grade }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-extrabold text-gray-700">
                                    {{ number_format($nilai->indeks ?? 0, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                                    Belum ada data nilai untuk semester ini.
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
