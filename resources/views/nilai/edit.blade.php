@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4">

        <x-page-header
            title="Edit Nilai"
            subtitle="Perbarui nilai tugas, UTS, atau UAS untuk mahasiswa ini."
            color="indigo"
            :paths="['m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125']"
        >
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/>
                </svg>
                Kembali
            </a>
        </x-page-header>

        @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form action="{{ route('nilai.update', $nilai) }}" method="POST" class="card">
            @csrf
            @method('PUT')

            {{-- Info read-only --}}
            <div class="grid grid-cols-1 gap-6 mb-6">
                <x-form-field name="_mahasiswa" label="Mahasiswa"
                              :value="$nilai->mahasiswa->nim . ' - ' . $nilai->mahasiswa->nama" />
                <x-form-field name="_mk" label="Mata Kuliah"
                              :value="($nilai->mataKuliah->kode_mk ?? '-') . ' - ' . ($nilai->mataKuliah->nama_mk ?? '-')" />
                <x-form-field name="_dosen" label="Dosen Pengampu"
                              :value="$nilai->mataKuliah->dosen->name ?? '-'" />
                <div class="grid grid-cols-2 gap-6">
                    <x-form-field name="_semester"       label="Semester"        :value="$nilai->semester" />
                    <x-form-field name="_tahun_akademik" label="Tahun Akademik"  :value="$nilai->tahun_akademik" />
                </div>
            </div>

            {{-- Catatan: field read-only di atas memakai prefix _ agar tidak dikirim ke controller.
                 Bila ingin benar-benar disabled (tidak dikirim), tambahkan atribut `disabled` lewat
                 modifikasi kecil pada x-form-field, atau biarkan controller mengabaikan field _ tersebut. --}}

            {{-- Nilai yang bisa diedit --}}
            <div class="grid grid-cols-3 gap-4">
                <x-form-field name="nilai_tugas" label="Nilai Tugas (20%)" type="number"
                              :value="old('nilai_tugas', $nilai->nilai_tugas)" required />
                <x-form-field name="nilai_uts"   label="Nilai UTS (30%)"   type="number"
                              :value="old('nilai_uts',   $nilai->nilai_uts)"   required />
                <x-form-field name="nilai_uas"   label="Nilai UAS (50%)"   type="number"
                              :value="old('nilai_uas',   $nilai->nilai_uas)"   required />
            </div>

            @include('nilai._grade-preview')

            <div class="flex gap-4 mt-8">
                <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@include('nilai._grade-script')
<script>
// Set nilai awal dari data existing agar preview langsung akurat
document.getElementById('nilaiTugas').value = '{{ old('nilai_tugas', $nilai->nilai_tugas) }}';
document.getElementById('nilaiUts').value   = '{{ old('nilai_uts',   $nilai->nilai_uts)   }}';
document.getElementById('nilaiUas').value   = '{{ old('nilai_uas',   $nilai->nilai_uas)   }}';
updateGradePreview();
</script>
@endpush
@endsection
