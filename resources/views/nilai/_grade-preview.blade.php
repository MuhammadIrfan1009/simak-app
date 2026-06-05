{{--
    Partial: nilai/_grade-preview.blade.php
    Dipakai di create.blade.php dan edit.blade.php.
    Gunakan id="nilaiTugas", id="nilaiUts", id="nilaiUas" pada input nilai.
--}}
<div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50/70 p-5 shadow-sm">
    <p class="mb-2 flex items-center gap-2 text-sm font-semibold text-indigo-700">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/>
        </svg>
        Nilai Akhir &amp; Prediksi Grade
    </p>
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
