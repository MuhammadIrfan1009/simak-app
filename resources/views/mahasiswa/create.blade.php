@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Tambah Mahasiswa"
            subtitle="Isi data mahasiswa baru dengan lengkap dan benar."
            :paths="['M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z']"
        >
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
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

        <form action="{{ route('mahasiswa.store') }}" method="POST" class="card space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-form-field name="nim"    label="NIM"           :value="old('nim')"    placeholder="04112021001" required />
                <x-form-field name="angkatan" label="Angkatan"    :value="old('angkatan')" placeholder="2024"      required />
            </div>

            <x-form-field name="nama"  label="Nama Lengkap"  :value="old('nama')"  placeholder="Nama mahasiswa" required />
            <x-form-field name="email" label="Email"  type="email" :value="old('email')" placeholder="email@example.com" required />

            <x-form-field
                name="jurusan"
                label="Jurusan"
                type="select"
                :value="old('jurusan')"
                required
                :options="['Informatika' => 'Informatika', 'Sistem Informasi' => 'Sistem Informasi', 'Teknik Komputer' => 'Teknik Komputer']"
            />

            <x-form-field name="alamat"     label="Alamat"      type="textarea" :value="old('alamat')"     placeholder="Alamat lengkap" :rows="3" />
            <x-form-field name="no_telepon" label="No. Telepon" type="tel"      :value="old('no_telepon')" placeholder="08xx xxxx xxxx" />

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
</div>
@endsection
