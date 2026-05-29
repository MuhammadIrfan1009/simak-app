@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📘 Detail Mata Kuliah</h1>
                <p class="text-sm text-gray-500">Informasi lengkap mata kuliah dan dosen pengampu.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('mata-kuliah.edit', $mataKuliah) }}" class="btn btn-primary">✏️ Edit</a>
                <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">Kode Mata Kuliah</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mataKuliah->kode_mk }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Mata Kuliah</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mataKuliah->nama_mk }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">SKS</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mataKuliah->sks }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Semester</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mataKuliah->semester }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-sm text-gray-500">Dosen Pengampu</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mataKuliah->dosen->name ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $mataKuliah->dosen->email ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 grid gap-6 sm:grid-cols-2">
            <div class="card">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Jadwal</h2>
                @if($mataKuliah->jadwals->isEmpty())
                    <p class="text-gray-500">Belum ada jadwal untuk mata kuliah ini.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($mataKuliah->jadwals as $jadwal)
                            <li class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-700">Hari: {{ $jadwal->hari }}</p>
                                <p class="text-sm text-gray-700">Waktu: {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                                <p class="text-sm text-gray-700">Ruangan: {{ $jadwal->ruangan }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="card">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Nilai Terkait</h2>
                @if($mataKuliah->nilais->isEmpty())
                    <p class="text-gray-500">Belum ada nilai yang tercatat untuk mata kuliah ini.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($mataKuliah->nilais as $nilai)
                            <li class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-700">Mahasiswa: {{ $nilai->mahasiswa->nama ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-700">Nilai Akhir: {{ $nilai->nilai_akhir }} (Grade: {{ $nilai->grade }})</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
