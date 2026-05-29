@extends('layouts.app')

@section('title', 'Cari Rekap Nilai - SIMAK')

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <span class="text-5xl">📊</span>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4">Rekap Nilai Akademik</h1>
            <p class="text-sm text-gray-500 mt-2">Pilih mahasiswa dan semester untuk melihat lembar rekapitulasi nilai dan IP/IPK.</p>
        </div>

        <div class="card shadow-xl border border-gray-100 bg-white">
            <form action="{{ route('nilai.rekap') }}" method="GET" class="space-y-6">
                <!-- Select Mahasiswa -->
                <div>
                    <label for="mahasiswa_id" class="form-label font-semibold text-gray-700">Mahasiswa</label>
                    <div class="relative mt-1">
                        <select name="mahasiswa_id" id="mahasiswa_id" class="form-input block w-full bg-white pr-10 appearance-none" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}">{{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->jurusan }})</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            ▼
                        </div>
                    </div>
                </div>

                <!-- Select Semester -->
                <div>
                    <label for="semester" class="form-label font-semibold text-gray-700">Semester</label>
                    <div class="relative mt-1">
                        <select name="semester" id="semester" class="form-input block w-full bg-white pr-10 appearance-none" required>
                            <option value="">-- Pilih Semester --</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Semester {{ $i }}</option>
                            @endfor
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            ▼
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn btn-primary flex items-center justify-center gap-2 py-3 shadow-md hover:shadow-lg transition">
                        <span>🔍</span> Cari Rekap Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
