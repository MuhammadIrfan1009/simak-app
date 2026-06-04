@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">📄 Detil Nilai</h1>
                <p class="text-sm text-gray-500">Informasi lengkap nilai mahasiswa.</p>
            </div>
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">Mahasiswa</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $nilai->mahasiswa->nim }} - {{ $nilai->mahasiswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mata Kuliah</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $nilai->mataKuliah->kode_mk ?? '-' }} - {{ $nilai->mataKuliah->nama_mk ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dosen</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $nilai->mataKuliah->dosen->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Semester</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $nilai->semester }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tahun Akademik</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $nilai->tahun_akademik }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nilai Tugas</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($nilai->nilai_tugas, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nilai UTS</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($nilai->nilai_uts, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nilai UAS</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($nilai->nilai_uas, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nilai Akhir</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($nilai->nilai_akhir, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Bobot / Indeks</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($nilai->indeks ?? 0, 2) }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-sm text-gray-500">Grade</p>
                    <span class="inline-flex items-center rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-2xl font-bold text-emerald-700">{{ $nilai->grade }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
