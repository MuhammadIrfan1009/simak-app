@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">➕ Tambah Mahasiswa</h1>

        <form action="{{ route('mahasiswa.store') }}" method="POST" class="card">
            @csrf

            <!-- NIM -->
            <div class="mb-6">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" id="nim" name="nim" class="form-input @error('nim') border-red-500 @enderror"
                       placeholder="Misal: 04112021001" value="{{ old('nim') }}" required>
                @error('nim')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div class="mb-6">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-input @error('nama') border-red-500 @enderror"
                       placeholder="Nama mahasiswa" value="{{ old('nama') }}" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input @error('email') border-red-500 @enderror"
                       placeholder="email@example.com" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jurusan -->
            <div class="mb-6">
                <label for="jurusan" class="form-label">Jurusan</label>
                <select id="jurusan" name="jurusan" class="form-input @error('jurusan') border-red-500 @enderror" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <option value="Informatika" {{ old('jurusan') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                    <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Teknik Komputer" {{ old('jurusan') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                </select>
                @error('jurusan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Angkatan -->
            <div class="mb-6">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="text" id="angkatan" name="angkatan" class="form-input @error('angkatan') border-red-500 @enderror"
                       placeholder="2024" value="{{ old('angkatan') }}" required>
                @error('angkatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-6">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-input @error('alamat') border-red-500 @enderror"
                          placeholder="Alamat lengkap" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Telepon -->
            <div class="mb-6">
                <label for="no_telepon" class="form-label">No. Telepon</label>
                <input type="tel" id="no_telepon" name="no_telepon" class="form-input @error('no_telepon') border-red-500 @enderror"
                       placeholder="08xx xxxx xxxx" value="{{ old('no_telepon') }}">
                @error('no_telepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">✅ Simpan</button>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
