{{--
    Props:
      $label = string
      $value = string
      $color = string  — Tailwind color name, e.g. 'indigo', 'emerald', 'rose'

    Usage:
      <x-stat-mini label="Total SKS" value="{{ $totalSks }}" color="emerald" />
      <x-stat-mini label="IPK" value="{{ number_format($ipk, 2) }}" color="rose" />
--}}
@props(['label', 'value', 'color' => 'indigo'])

<div class="rounded-2xl border border-{{ $color }}-100 bg-{{ $color }}-50 p-4 shadow-sm">
    <p class="text-xs uppercase tracking-[0.25em] font-semibold text-{{ $color }}-500">{{ $label }}</p>
    <p class="mt-2 text-3xl font-extrabold text-{{ $color }}-700">{{ $value }}</p>
</div>
