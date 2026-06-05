@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Catat nilai mahasiswa dengan cepat"
            subtitle="Pencarian yang lebih rapi, tampilan yang seragam, dan kalkulasi otomatis langsung terlihat."
            color="indigo"
            :paths="['M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-7-7 7 7m-7-7h7']"
        />

        @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form action="{{ route('nilai.store') }}" method="POST"
              class="card border border-slate-100 shadow-xl" id="nilaiForm">
            @csrf

            {{-- Mahasiswa & Mata Kuliah --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Mahasiswa</label>
                    <input type="text" id="mahasiswaSearch" list="mahasiswaList" autocomplete="off"
                           placeholder="Cari NIM / nama mahasiswa"
                           class="form-input @error('mahasiswa_id') border-red-400 bg-red-50 @enderror"
                           required
                           value="{{ old('mahasiswa_id') ? $mahasiswas->firstWhere('id', old('mahasiswa_id'))?->nim . ' - ' . $mahasiswas->firstWhere('id', old('mahasiswa_id'))?->nama : '' }}">
                    <datalist id="mahasiswaList">
                        @foreach ($mahasiswas as $m)
                            <option value="{{ $m->nim }} - {{ $m->nama }}" data-id="{{ $m->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                    @error('mahasiswa_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Mata Kuliah</label>
                    <input type="text" id="mataKuliahSearch" list="mataKuliahList" autocomplete="off"
                           placeholder="Cari kode / nama mata kuliah"
                           class="form-input @error('mata_kuliah_id') border-red-400 bg-red-50 @enderror"
                           required
                           value="{{ old('mata_kuliah_id') ? $mataKuliahs->firstWhere('id', old('mata_kuliah_id'))?->kode_mk . ' - ' . $mataKuliahs->firstWhere('id', old('mata_kuliah_id'))?->nama_mk : '' }}">
                    <datalist id="mataKuliahList">
                        @foreach ($mataKuliahs as $mk)
                            <option value="{{ $mk->kode_mk }} - {{ $mk->nama_mk }}"
                                    data-id="{{ $mk->id }}"
                                    data-dosen="{{ $mk->dosen->name ?? '' }}"
                                    data-semester="{{ $mk->semester ?? '' }}">
                            </option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="mata_kuliah_id" id="mataKuliahId" value="{{ old('mata_kuliah_id') }}">
                    @error('mata_kuliah_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Dosen & Tahun Akademik --}}
            <div class="grid grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="form-label">Dosen Pengampu</label>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm">
                        <svg class="h-5 w-5 shrink-0 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z"/>
                        </svg>
                        <input type="text" id="dosenPengampu"
                               class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 focus:ring-0"
                               readonly>
                    </div>
                </div>

                <x-form-field
                    name="tahun_akademik"
                    label="Tahun Akademik"
                    :value="old('tahun_akademik')"
                    placeholder="2024/2025"
                    required
                />
            </div>

            <input type="hidden" name="semester" id="semesterInput" value="{{ old('semester') }}">

            {{-- Nilai Komponen --}}
            <div class="mt-8 pt-8 border-t">
                <x-card-header
                    color="emerald"
                    title="Nilai Komponen"
                    :paths="['M3 5h18M7 9h10M7 13h6']"
                />

                <div class="grid grid-cols-3 gap-4">
                    <x-form-field name="nilai_tugas" label="Nilai Tugas (20%)" type="number"
                                  :value="old('nilai_tugas')" required />
                    <x-form-field name="nilai_uts"   label="Nilai UTS (30%)"   type="number"
                                  :value="old('nilai_uts')"   required />
                    <x-form-field name="nilai_uas"   label="Nilai UAS (50%)"   type="number"
                                  :value="old('nilai_uas')"   required />
                </div>

                @include('nilai._grade-preview')
            </div>

            <div class="flex flex-wrap gap-3 mt-8">
                <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Simpan Nilai
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
function syncHiddenValue(input, hiddenInput, options) {
    const matched = options.find(o => o.value === input.value);
    hiddenInput.value = matched?.dataset?.id || '';
    return matched;
}

function updateDosenPengampu() {
    const input   = document.getElementById('mataKuliahSearch');
    const options = Array.from(document.getElementById('mataKuliahList').options);
    const match   = syncHiddenValue(input, document.getElementById('mataKuliahId'), options);
    document.getElementById('dosenPengampu').value   = match?.dataset?.dosen    || '';
    document.getElementById('semesterInput').value   = match?.dataset?.semester || document.getElementById('semesterInput').value || '';
}

document.getElementById('mahasiswaSearch').addEventListener('input', () => {
    syncHiddenValue(
        document.getElementById('mahasiswaSearch'),
        document.getElementById('mahasiswaId'),
        Array.from(document.getElementById('mahasiswaList').options)
    );
});

document.getElementById('mataKuliahSearch').addEventListener('input', updateDosenPengampu);

updateDosenPengampu();
updateGradePreview();
</script>
@endpush
@endsection
