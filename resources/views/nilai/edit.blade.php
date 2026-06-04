@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 flex items-center gap-3"><svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg> Edit Nilai</h1>
                <p class="text-sm text-gray-500">Perbarui nilai tugas, UTS, atau UAS untuk mahasiswa ini.</p>
            </div>
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19 3 12l7-7M3 12h18"/></svg> Kembali</a>
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
                    <input type="number" name="nilai_tugas" id="nilaiTugas" class="form-input @error('nilai_tugas') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" required>
                    @error('nilai_tugas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Nilai UTS (30%)</label>
                    <input type="number" name="nilai_uts" id="nilaiUts" class="form-input @error('nilai_uts') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_uts', $nilai->nilai_uts) }}" required>
                    @error('nilai_uts')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Nilai UAS (50%)</label>
                    <input type="number" name="nilai_uas" id="nilaiUas" class="form-input @error('nilai_uas') border-red-500 @enderror" min="0" max="100" step="0.01" value="{{ old('nilai_uas', $nilai->nilai_uas) }}" required>
                    @error('nilai_uas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50/70 p-5 shadow-sm">
                <p class="mb-2 flex items-center gap-2 text-sm font-semibold text-indigo-700"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/></svg> Prediksi Grade & Bobot</p>
                <div class="text-3xl font-bold text-blue-600">
                    <span id="nilaiAkhir">{{ number_format(App\Models\Nilai::hitungNilaiAkhir(old('nilai_tugas', $nilai->nilai_tugas), old('nilai_uts', $nilai->nilai_uts), old('nilai_uas', $nilai->nilai_uas)), 2) }}</span>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-white/80 bg-white/80 p-4 shadow-sm">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Grade</p>
                        <p id="gradePreview" class="mt-1 text-xl font-extrabold text-slate-900">{{ App\Models\Nilai::nilaiKeGrade(App\Models\Nilai::hitungNilaiAkhir(old('nilai_tugas', $nilai->nilai_tugas), old('nilai_uts', $nilai->nilai_uts), old('nilai_uas', $nilai->nilai_uas))) }}</p>
                    </div>
                    <div class="rounded-xl border border-white/80 bg-white/80 p-4 shadow-sm">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Bobot / Indeks</p>
                        <p id="indeksPreview" class="mt-1 text-xl font-extrabold text-emerald-600">{{ number_format(App\Models\Nilai::gradeToIndeks(App\Models\Nilai::nilaiKeGrade(App\Models\Nilai::hitungNilaiAkhir(old('nilai_tugas', $nilai->nilai_tugas), old('nilai_uts', $nilai->nilai_uts), old('nilai_uas', $nilai->nilai_uas)))), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="btn btn-primary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Simpan Perubahan</button>
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

function updatePreview() {
    const tugas = parseFloat(document.getElementById('nilaiTugas').value) || 0;
    const uts = parseFloat(document.getElementById('nilaiUts').value) || 0;
    const uas = parseFloat(document.getElementById('nilaiUas').value) || 0;

    const nilaiAkhir = (0.20 * tugas) + (0.30 * uts) + (0.50 * uas);
    const grade = getGrade(nilaiAkhir);

    document.getElementById('nilaiAkhir').textContent = nilaiAkhir.toFixed(2);
    document.getElementById('gradePreview').textContent = grade;
    document.getElementById('indeksPreview').textContent = getIndeks(grade).toFixed(2);
}

['nilaiTugas', 'nilaiUts', 'nilaiUas'].forEach((id) => {
    document.getElementById(id)?.addEventListener('input', updatePreview);
});

updatePreview();
</script>
@endsection
