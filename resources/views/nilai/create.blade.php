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
                    <select name="mahasiswa_id" class="form-input" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $m)
                            <option value="{{ $m->id }}">{{ $m->nim }} - {{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Kuliah -->
                <div>
                    <label class="form-label">Mata Kuliah</label>
                    <select name="mata_kuliah_id" class="form-input" required>
                        <option value="">-- Pilih MK --</option>
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="form-label">Semester</label>
                    <input type="number" name="semester" class="form-input" min="1" max="8" required>
                </div>
                <div>
                    <label class="form-label">Tahun Akademik</label>
                    <input type="text" name="tahun_akademik" class="form-input" placeholder="2024/2025" required>
                </div>
            </div>

            <!-- Nilai -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-lg font-semibold mb-6">📊 Nilai Komponen</h3>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" name="nilai_tugas" id="nilaiTugas" 
                               class="form-input" min="0" max="100" step="0.01" required>
                    </div>
                    <div>
                        <label class="form-label">Nilai UTS (30%)</label>
                        <input type="number" name="nilai_uts" id="nilaiUts" 
                               class="form-input" min="0" max="100" step="0.01" required>
                    </div>
                    <div>
                        <label class="form-label">Nilai UAS (50%)</label>
                        <input type="number" name="nilai_uas" id="nilaiUas" 
                               class="form-input" min="0" max="100" step="0.01" required>
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
// Auto-calculate nilai akhir saat input berubah
document.querySelectorAll('#nilaiTugas, #nilaiUts, #nilaiUas').forEach(input => {
    input.addEventListener('input', function() {
        const tugas = parseFloat(document.getElementById('nilaiTugas').value) || 0;
        const uts = parseFloat(document.getElementById('nilaiUts').value) || 0;
        const uas = parseFloat(document.getElementById('nilaiUas').value) || 0;

        const nilaiAkhir = (0.20 * tugas) + (0.30 * uts) + (0.50 * uas);
        document.getElementById('nilaiAkhir').textContent = nilaiAkhir.toFixed(2);
    });
});
</script>
@endsection
