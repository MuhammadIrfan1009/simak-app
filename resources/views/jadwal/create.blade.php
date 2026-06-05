@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Tambah Jadwal"
            subtitle="Tambahkan jadwal kelas baru."
            color="indigo"
            :paths="['M12 5v14M5 12h14']"
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

        <form action="{{ route('jadwal.store') }}" method="POST" class="card">
            @csrf

            <div class="grid gap-6">
                <x-form-field
                    name="mata_kuliah_id"
                    label="Mata Kuliah"
                    type="select"
                    :value="old('mata_kuliah_id')"
                    :options="$mataKuliahs->mapWithKeys(fn($mk) => [$mk->id => $mk->kode_mk . ' - ' . $mk->nama_mk])->toArray()"
                    required
                />

                <x-form-field
                    name="hari"
                    label="Hari"
                    type="select"
                    :value="old('hari')"
                    :options="collect(['Senin','Selasa','Rabu','Kamis','Jumat'])->combine(['Senin','Selasa','Rabu','Kamis','Jumat'])->toArray()"
                    required
                />

                <x-form-field name="jam_mulai"   label="Jam Mulai"   type="time" :value="old('jam_mulai')"   required />
                <x-form-field name="jam_selesai" label="Jam Selesai" type="time" :value="old('jam_selesai')" required />
                <x-form-field name="ruangan"     label="Ruangan"     :value="old('ruangan')"
                              placeholder="Contoh: R1.101" required />
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
</div>
@endsection
