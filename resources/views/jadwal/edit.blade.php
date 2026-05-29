@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">✏️ Edit Jadwal</h1>
                <p class="text-sm text-gray-500">Perbarui informasi jadwal.</p>
            </div>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
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

        <form action="{{ route('jadwal.update', $jadwal) }}" method="POST" class="card">
            @csrf
            @method('PUT')

            <div class="grid gap-6">
                <div>
                    <label for="mata_kuliah_id" class="form-label">Mata Kuliah</label>
                    <select id="mata_kuliah_id" name="mata_kuliah_id" class="form-input @error('mata_kuliah_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}" {{ old('mata_kuliah_id', $jadwal->mata_kuliah_id) == $mk->id ? 'selected' : '' }}>{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="hari" class="form-label">Hari</label>
                    <select id="hari" name="hari" class="form-input @error('hari') border-red-500 @enderror" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" class="form-input @error('jam_mulai') border-red-500 @enderror" required>
                </div>

                <div>
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" class="form-input @error('jam_selesai') border-red-500 @enderror" required>
                </div>

                <div>
                    <label for="ruangan" class="form-label">Ruangan</label>
                    <input type="text" id="ruangan" name="ruangan" value="{{ old('ruangan', $jadwal->ruangan) }}" class="form-input @error('ruangan') border-red-500 @enderror" required>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('jadwal.show', $jadwal) }}" class="btn btn-secondary">Lihat</a>
            </div>
        </form>
    </div>
</div>
@endsection
