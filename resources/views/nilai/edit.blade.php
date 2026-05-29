@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">✏️ Edit Nilai</h1>
                <p class="text-sm text-gray-500">Perbarui nilai tugas, UTS, atau UAS untuk mahasiswa ini.</p>
            </div>
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
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

        <form action="{{ route('nilai.update', $nilai) }}" method="POST" class="card">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <label class="form-label">Mahasiswa</label>
                    <input type="text" class="form-input" value="{{ $nilai->mahasiswa->nim }} - {{ $nilai->mahasiswa->nama }}" disabled>
                </div>
                <div>
                    <label class="form-label">Mata Kuliah</label>
                    <input type="text" class="form-input" value="{{ $nilai->mataKuliah->kode_mk ?? '-' }} - {{ $nilai->mataKuliah->nama_mk ?? '-' }}" disabled>
                </div>
                <div>
                    <label class="form-label">Dosen Pengampu</label>
                    <input type="text" class="form-input" value="{{ $nilai->mataKuliah->dosen->name ?? '-' }}" disabled>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Semester</label>
                        <input type="text" class="form-input" value="{{ $nilai->semester }}" disabled>
                    </div>
                    <div>
                        <label class="form-label">Tahun Akademik</label>
                        <input type="text" class="form-input" value="{{ $nilai->tahun_akademik }}" disabled>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Nilai Tugas (20%)</label>
                    <input type="number" name="nilai_tugas" class="form-input @error('nilai_tugas') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" required>
                    @error('nilai_tugas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Nilai UTS (30%)</label>
                    <input type="number" name="nilai_uts" class="form-input @error('nilai_uts') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_uts', $nilai->nilai_uts) }}" required>
                    @error('nilai_uts')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Nilai UAS (50%)</label>
                    <input type="number" name="nilai_uas" class="form-input @error('nilai_uas') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_uas', $nilai->nilai_uas) }}" required>
                    @error('nilai_uas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
