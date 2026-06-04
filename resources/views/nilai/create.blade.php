@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-start gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-7-7 7 7m-7-7h7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-500">Input Nilai</p>
                <h1 class="text-3xl font-bold text-slate-900">Catat nilai mahasiswa dengan cepat</h1>
                <p class="mt-1 text-sm text-slate-500">Pencarian yang lebih rapi, tampilan yang seragam, dan kalkulasi otomatis langsung terlihat.</p>
            </div>
        </div>

        <form action="{{ route('nilai.store') }}" method="POST" class="card border border-slate-100 shadow-xl" id="nilaiForm">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Mahasiswa -->
                <div>
                    <label class="form-label">Mahasiswa</label>
                    <input type="text" id="mahasiswaSearch" list="mahasiswaList" autocomplete="off" placeholder="Cari NIM / nama mahasiswa" class="form-input @error('mahasiswa_id') border-red-500 @enderror" required value="{{ old('mahasiswa_id') ? $mahasiswas->firstWhere('id', old('mahasiswa_id'))?->nim . ' - ' . $mahasiswas->firstWhere('id', old('mahasiswa_id'))?->nama : '' }}">
                    <datalist id="mahasiswaList">
                        @foreach($mahasiswas as $m)
                            <option value="{{ $m->nim }} - {{ $m->nama }}" data-id="{{ $m->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                    @error('mahasiswa_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Kuliah -->
                <div>
                    <label class="form-label">Mata Kuliah</label>
                    <input type="text" id="mataKuliahSearch" list="mataKuliahList" autocomplete="off" placeholder="Cari kode / nama mata kuliah" class="form-input @error('mata_kuliah_id') border-red-500 @enderror" required value="{{ old('mata_kuliah_id') ? $mataKuliahs->firstWhere('id', old('mata_kuliah_id'))?->kode_mk . ' - ' . $mataKuliahs->firstWhere('id', old('mata_kuliah_id'))?->nama_mk : '' }}">
                    <datalist id="mataKuliahList">
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->kode_mk }} - {{ $mk->nama_mk }}" data-id="{{ $mk->id }}" data-dosen="{{ $mk->dosen->name ?? '' }}" data-semester="{{ $mk->semester ?? '' }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="mata_kuliah_id" id="mataKuliahId" value="{{ old('mata_kuliah_id') }}">
                    @error('mata_kuliah_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="form-label">Dosen Pengampu</label>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-600 shadow-sm">
                        <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z"/>
                        </svg>
                        <input type="text" id="dosenPengampu" class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 focus:ring-0" value="" readonly>
                    </div>
                </div>
                <div>
                    <label class="form-label">Tahun Akademik</label>
                    <input type="text" name="tahun_akademik" class="form-input @error('tahun_akademik') border-red-500 @enderror" placeholder="2024/2025" value="{{ old('tahun_akademik') }}" required>
                    @error('tahun_akademik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Hidden semester will be filled from selected Mata Kuliah (or old value) --}}
            <input type="hidden" name="semester" id="semesterInput" value="{{ old('semester') }}">

            <!-- Nilai -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-lg font-semibold mb-6 flex items-center gap-2 text-slate-900"><svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M7 9h10M7 13h6"/></svg> Nilai Komponen</h3>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" name="nilai_tugas" id="nilaiTugas"
                               class="form-input @error('nilai_tugas') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_tugas') }}" required>
                        @error('nilai_tugas')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Nilai UTS (30%)</label>
                        <input type="number" name="nilai_uts" id="nilaiUts"
                               class="form-input @error('nilai_uts') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_uts') }}" required>
                        @error('nilai_uts')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Nilai UAS (50%)</label>
                        <input type="number" name="nilai_uas" id="nilaiUas"
                               class="form-input @error('nilai_uas') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_uas') }}" required>
                        @error('nilai_uas')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Auto Calculate -->
                <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50/70 p-5 shadow-sm">
                    <p class="mb-2 flex items-center gap-2 text-sm font-semibold text-indigo-700"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/></svg> Nilai Akhir & Prediksi Grade</p>
                    <div class="text-3xl font-bold text-blue-600">
                        <span id="nilaiAkhir">0.00</span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-white/80 bg-white/80 p-4 shadow-sm">
                            <p class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Grade</p>
                            <p id="gradePreview" class="mt-1 text-xl font-extrabold text-slate-900">E</p>
                        </div>
                        <div class="rounded-xl border border-white/80 bg-white/80 p-4 shadow-sm">
                            <p class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Bobot / Indeks</p>
                            <p id="indeksPreview" class="mt-1 text-xl font-extrabold text-emerald-600">0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-3 mt-8">
                <button type="submit" class="btn btn-primary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg> Simpan Nilai</button>
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg> Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function getGrade(nilai) {
    if (nilai >= 86) return 'A';
    if (nilai >= 80) return 'A-';
    if (nilai >= 75) return 'B+';
    if (nilai >= 70) return 'B';
    if (nilai >= 65) return 'B-';
    if (nilai >= 60) return 'C+';
    if (nilai >= 56) return 'C';
    if (nilai >= 41) return 'D';
    return 'E';
}

function getIndeks(grade) {
    return {
        'A': 4.00,
        'A-': 3.70,
        'B+': 3.30,
        'B': 3.00,
        'B-': 2.70,
        'C+': 2.30,
        'C': 2.00,
        'D': 1.00,
        'E': 0.00,
    }[grade] ?? 0.00;
}

function updateNilaiAkhir() {
    const tugas = parseFloat(document.getElementById('nilaiTugas').value) || 0;
    const uts = parseFloat(document.getElementById('nilaiUts').value) || 0;
    const uas = parseFloat(document.getElementById('nilaiUas').value) || 0;

    const nilaiAkhir = (0.20 * tugas) + (0.30 * uts) + (0.50 * uas);
    const grade = getGrade(nilaiAkhir);
    const indeks = getIndeks(grade);

    document.getElementById('nilaiAkhir').textContent = nilaiAkhir.toFixed(2);
    document.getElementById('gradePreview').textContent = grade;
    document.getElementById('indeksPreview').textContent = indeks.toFixed(2);
}

function syncHiddenValue(input, hiddenInput, options) {
    const matched = options.find(option => option.value === input.value);
    hiddenInput.value = matched?.dataset?.id || '';
    return matched;
}

function updateDosenPengampu() {
    const input = document.getElementById('mataKuliahSearch');
    const dosenInput = document.getElementById('dosenPengampu');
    const semesterInput = document.getElementById('semesterInput');
    const option = syncHiddenValue(input, document.getElementById('mataKuliahId'), Array.from(document.getElementById('mataKuliahList').options));

    dosenInput.value = option?.dataset?.dosen || '';
    semesterInput.value = option?.dataset?.semester || semesterInput.value || '';
}

document.querySelectorAll('#nilaiTugas, #nilaiUts, #nilaiUas').forEach(input => {
    input.addEventListener('input', updateNilaiAkhir);
});

document.getElementById('mahasiswaSearch').addEventListener('input', () => {
    syncHiddenValue(document.getElementById('mahasiswaSearch'), document.getElementById('mahasiswaId'), Array.from(document.getElementById('mahasiswaList').options));
});

document.getElementById('mataKuliahSearch').addEventListener('input', updateDosenPengampu);

updateNilaiAkhir();
updateDosenPengampu();
</script>
@endsection
