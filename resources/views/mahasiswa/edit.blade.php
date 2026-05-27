@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">✏️ Edit Mahasiswa</h1>
                <p class="text-sm text-gray-500">Perbarui data mahasiswa dengan benar.</p>
            </div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.update', $mahasiswa) }}" method="POST" class="card">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-input" required>
                        @foreach(['Informatika','Sistem Informasi','Teknik Komputer'] as $jurusan)
                            <option value="{{ $jurusan }}" {{ old('jurusan', $mahasiswa->jurusan) === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Angkatan</label>
                    <input type="text" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-input" rows="3">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                </div>
                <div>
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $mahasiswa->no_telepon) }}" class="form-input">
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-secondary">Lihat Profil</a>
            </div>
        </form>
    </div>
</div>
@endsection
