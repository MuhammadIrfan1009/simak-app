{{--
    Props:
      $color  = string  — Tailwind color name, e.g. 'indigo'
      $title  = string
      $paths  = string[] — one or more SVG path d="..." values
--}}
@props(['color', 'title', 'paths'])

<div class="flex items-center gap-2 mb-6 border-b border-slate-50 pb-4">
    <span class="p-2 bg-{{ $color }}-50 rounded-lg text-{{ $color }}-500">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            @foreach ($paths as $d)
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}" />
            @endforeach
        </svg>
    </span>
    <h2 class="text-lg font-bold text-slate-800">{{ $title }}</h2>
</div>
