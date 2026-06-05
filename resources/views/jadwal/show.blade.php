@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Detail Jadwal"
            subtitle="Lihat detail jadwal mata kuliah."
            color="indigo"
            :paths="['M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z']"
        >
            @if (auth()->user()->isAdmin())
                <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                    </svg>
                    Edit
                </a>
            @endif
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/>
                </svg>
                Kembali
            </a>
        </x-page-header>

        <div class="card">
            <x-card-header
                color="indigo"
                title="Informasi Jadwal"
                :paths="['M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z']"
            />

            {{-- Tampilan jadwal pakai schedule-row --}}
            <x-schedule-row :item="$jadwal" accent="indigo" />

            {{-- Field tambahan yang tidak ada di schedule-row --}}
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">Mata Kuliah</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $jadwal->mataKuliah->kode_mk ?? '-' }} — {{ $jadwal->mataKuliah->nama_mk ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dosen Pengampu</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $jadwal->mataKuliah->dosen->name ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">SKS</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $jadwal->mataKuliah->sks ?? '-' }} SKS
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
