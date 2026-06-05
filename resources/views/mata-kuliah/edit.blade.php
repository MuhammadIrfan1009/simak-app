@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Edit Mata Kuliah"
            subtitle="Perbarui data mata kuliah."
            :paths="['m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z']"
            color="amber"
        >
            <a href="{{ route('mata-kuliah.show', $mataKuliah) }}" class="btn btn-secondary">Lihat</a>
            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
        </x-page-header>

        @if ($errors->any())
            <div class="mb-6">
                <x-alert type="error">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            </div>
        @endif

        <form action="{{ route('mata-kuliah.update', $mataKuliah) }}" method="POST" class="card space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-form-field name="kode_mk"  label="Kode Mata Kuliah" :value="old('kode_mk', $mataKuliah->kode_mk)"   required />
                <x-form-field name="nama_mk"  label="Nama Mata Kuliah" :value="old('nama_mk', $mataKuliah->nama_mk)"   required />
                <x-form-field name="sks"      label="SKS"      type="number" :value="old('sks', $mataKuliah->sks)"           required />
                <x-form-field name="semester" label="Semester" type="number" :value="old('semester', $mataKuliah->semester)" required />
            </div>

            <x-form-field
                name="user_id"
                label="Dosen Pengampu"
                type="select"
                :value="old('user_id', $mataKuliah->user_id)"
                required
                :options="$dosens->mapWithKeys(fn($d) => [$d->id => $d->name . ' (' . $d->email . ')'])->all()"
            />

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('mata-kuliah.show', $mataKuliah) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
</div>
@endsection
