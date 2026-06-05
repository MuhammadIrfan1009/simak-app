{{--
    Props:
      $item      — jadwal model (has mataKuliah relation)
      $accent    = string — Tailwind color name, e.g. 'indigo' | 'emerald'
      $showDosen = bool   — show dosen name row (mahasiswa view only)
--}}
@props(['item', 'accent' => 'indigo', 'showDosen' => false])

<div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-{{ $accent }}-100 transition-colors">
    <div class="flex items-start gap-3">
        <div class="h-10 w-10 shrink-0 rounded-xl bg-{{ $accent }}-500/10 text-{{ $accent }}-500 flex items-center justify-center font-bold font-mono text-sm">
            {{ $item->mataKuliah->sks }}
        </div>
        <div>
            <p class="font-bold text-slate-800 text-sm sm:text-base leading-tight">{{ $item->mataKuliah->nama_mk }}</p>
            <p class="text-xs text-slate-500 mt-1 font-medium">{{ $item->mataKuliah->kode_mk }} • {{ $item->ruangan }}</p>
            @if ($showDosen)
                <p class="text-xs text-slate-400 font-medium mt-0.5">Dosen: {{ $item->mataKuliah->dosen->name ?? 'Staf Pengajar' }}</p>
            @endif
        </div>
    </div>
    <div class="mt-3 sm:mt-0 flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 bg-white border border-slate-200 px-3 py-1.5 rounded-xl shadow-xs self-start sm:self-auto">
        <span class="inline-flex items-center gap-1">
            <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 19h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1Z"/>
            </svg>
            {{ $item->hari }}
        </span>
        <span class="text-slate-300">|</span>
        <span class="inline-flex items-center gap-1">
            <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}
        </span>
    </div>
</div>
