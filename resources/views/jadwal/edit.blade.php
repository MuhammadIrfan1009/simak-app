@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Edit Jadwal"
            subtitle="Perbarui informasi jadwal."
            color="indigo"
            :paths="['m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125']"
        >
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/>
                </svg>
                Kembali
            </a>
        </x-page-header>

        @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form action="{{ route('jadwal.update', $jadwal) }}" method="POST" class="card">
            @csrf
            @method('PUT')

            <div class="grid gap-6">
                <x-form-field
                    name="mata_kuliah_id"
                    label="Mata Kuliah"
                    type="select"
                    :value="old('mata_kuliah_id', $jadwal->mata_kuliah_id)"
                    :options="$mataKuliahs->mapWithKeys(fn($mk) => [$mk->id => $mk->kode_mk . ' - ' . $mk->nama_mk])->toArray()"
                    required
                />

                <x-form-field
                    name="hari"
                    label="Hari"
                    type="select"
                    :value="old('hari', $jadwal->hari)"
                    :options="collect(['Senin','Selasa','Rabu','Kamis','Jumat'])->combine(['Senin','Selasa','Rabu','Kamis','Jumat'])->toArray()"
                    required
                />

                <x-form-field name="jam_mulai"   label="Jam Mulai"   type="time"
                              :value="old('jam_mulai',   $jadwal->jam_mulai)"   required />
                <x-form-field name="jam_selesai" label="Jam Selesai" type="time"
                              :value="old('jam_selesai', $jadwal->jam_selesai)" required />
                <x-form-field name="ruangan"     label="Ruangan"
                              :value="old('ruangan',     $jadwal->ruangan)"     required />
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('jadwal.show', $jadwal) }}" class="btn btn-secondary">Lihat</a>
            </div>
        </form>

    </div>
</div>
@endsection
