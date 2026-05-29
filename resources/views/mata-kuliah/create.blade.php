@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">➕ Tambah Mata Kuliah</h1>
                <p class="text-sm text-gray-500">Isi data mata kuliah baru di sini.</p>
            </div>
            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('mata-kuliah.store') }}" method="POST" class="card">
            @csrf

            <div class="grid gap-6">
                <div>
                    <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
                    <input type="text" id="kode_mk" name="kode_mk" value="{{ old('kode_mk') }}" class="form-input @error('kode_mk') border-red-500 @enderror" placeholder="Contoh: IF101" required>
                    @error('kode_mk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" id="nama_mk" name="nama_mk" value="{{ old('nama_mk') }}" class="form-input @error('nama_mk') border-red-500 @enderror" placeholder="Contoh: Pemrograman Web" required>
                    @error('nama_mk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" id="sks" name="sks" value="{{ old('sks') }}" class="form-input @error('sks') border-red-500 @enderror" min="1" max="4" required>
                    @error('sks')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" id="semester" name="semester" value="{{ old('semester') }}" class="form-input @error('semester') border-red-500 @enderror" min="1" max="8" required>
                    @error('semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_id" class="form-label">Dosen Pengampu</label>
                    <select id="user_id" name="user_id" class="form-input @error('user_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('user_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->name }} ({{ $dosen->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
