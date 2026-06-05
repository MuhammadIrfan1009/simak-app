@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Tambah Mata Kuliah"
            subtitle="Isi data mata kuliah baru di sini."
            :paths="['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253']"
        >
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

        <form action="{{ route('mata-kuliah.store') }}" method="POST" class="card space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-form-field name="kode_mk" label="Kode Mata Kuliah" :value="old('kode_mk')" placeholder="IF101" required />
                <x-form-field name="nama_mk" label="Nama Mata Kuliah" :value="old('nama_mk')" placeholder="Pemrograman Web" required />
                <x-form-field name="sks"     label="SKS"      type="number" :value="old('sks')"      required />
                <x-form-field name="semester" label="Semester" type="number" :value="old('semester')" required />
            </div>

            <x-form-field
                name="user_id"
                label="Dosen Pengampu"
                type="select"
                :value="old('user_id')"
                required
                :options="$dosens->mapWithKeys(fn($d) => [$d->id => $d->name . ' (' . $d->email . ')'])->all()"
            />

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
</div>
@endsection
