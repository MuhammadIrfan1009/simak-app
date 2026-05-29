@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">📝 Input Nilai</h1>

        <form action="{{ route('nilai.store') }}" method="POST" class="card" id="nilaiForm">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Mahasiswa -->
                <div>
                    <label class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-input @error('mahasiswa_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $m)
                            <option value="{{ $m->id }}" {{ old('mahasiswa_id') == $m->id ? 'selected' : '' }}>{{ $m->nim }} - {{ $m->nama }}</option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Kuliah -->
                <div>
                    <label class="form-label">Mata Kuliah</label>
                    <select id="mataKuliahSelect" name="mata_kuliah_id" class="form-input @error('mata_kuliah_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih MK --</option>
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}" data-dosen="{{ $mk->dosen->name ?? '' }}" data-semester="{{ $mk->semester ?? '' }}" {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                        @endforeach
                    </select>
                    @error('mata_kuliah_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="form-label">Dosen Pengampu</label>
                    <input type="text" id="dosenPengampu" class="form-input bg-gray-50" value="" readonly>
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
                <h3 class="text-lg font-semibold mb-6">📊 Nilai Komponen</h3>

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
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-700 mb-2">💡 Nilai Akhir (Auto Calculate)</p>
                    <div class="text-3xl font-bold text-blue-600">
                        <span id="nilaiAkhir">0.00</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-8">
                <button type="submit" class="btn btn-primary">✅ Simpan Nilai</button>
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function updateNilaiAkhir() {
    const tugas = parseFloat(document.getElementById('nilaiTugas').value) || 0;
    const uts = parseFloat(document.getElementById('nilaiUts').value) || 0;
    const uas = parseFloat(document.getElementById('nilaiUas').value) || 0;

    const nilaiAkhir = (0.20 * tugas) + (0.30 * uts) + (0.50 * uas);
    document.getElementById('nilaiAkhir').textContent = nilaiAkhir.toFixed(2);
}

function updateDosenPengampu() {
    const select = document.getElementById('mataKuliahSelect');
    const dosenInput = document.getElementById('dosenPengampu');
    const option = select.selectedOptions[0];
    dosenInput.value = option?.dataset?.dosen || '';
    const semesterInput = document.getElementById('semesterInput');
    // use option dataset semester, fallback to old value already in hidden input
    semesterInput.value = option?.dataset?.semester || semesterInput.value || '';
}

document.querySelectorAll('#nilaiTugas, #nilaiUts, #nilaiUas').forEach(input => {
    input.addEventListener('input', updateNilaiAkhir);
});

document.getElementById('mataKuliahSelect').addEventListener('change', updateDosenPengampu);

updateNilaiAkhir();
updateDosenPengampu();
</script>
@endsection
