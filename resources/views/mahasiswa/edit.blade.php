@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Edit Mahasiswa"
            subtitle="Perbarui data mahasiswa dengan benar."
            :paths="['m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z']"
            color="amber"
        >
            <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-secondary">Lihat Profil</a>
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

        <form action="{{ route('mahasiswa.update', $mahasiswa) }}" method="POST" class="card space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-form-field name="nim"      label="NIM"      :value="old('nim', $mahasiswa->nim)"           required />
                <x-form-field name="angkatan" label="Angkatan" :value="old('angkatan', $mahasiswa->angkatan)" required />
            </div>

            <x-form-field name="nama"  label="Nama Lengkap" :value="old('nama', $mahasiswa->nama)"   required />
            <x-form-field name="email" label="Email" type="email" :value="old('email', $mahasiswa->email)" required />

            <x-form-field
                name="jurusan"
                label="Jurusan"
                type="select"
                :value="old('jurusan', $mahasiswa->jurusan)"
                required
                :options="['Informatika' => 'Informatika', 'Sistem Informasi' => 'Sistem Informasi', 'Teknik Komputer' => 'Teknik Komputer']"
            />

            <x-form-field name="alamat"     label="Alamat"      type="textarea" :value="old('alamat', $mahasiswa->alamat)"           :rows="3" />
            <x-form-field name="no_telepon" label="No. Telepon" type="tel"      :value="old('no_telepon', $mahasiswa->no_telepon)" />

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
</div>
@endsection
