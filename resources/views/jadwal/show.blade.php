@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📘 Detail Jadwal</h1>
                <p class="text-sm text-gray-500">Lihat detail jadwal mata kuliah.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-primary">✏️ Edit</a>
                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">Mata Kuliah</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $jadwal->mataKuliah->kode_mk ?? '-' }} - {{ $jadwal->mataKuliah->nama_mk ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Hari</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $jadwal->hari }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jam</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Ruangan</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $jadwal->ruangan }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
