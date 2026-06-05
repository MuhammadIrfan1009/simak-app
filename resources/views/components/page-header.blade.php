{{--
    Props:
      $title    = string
      $subtitle = string|null
      $paths    = string[]|null  — SVG path d="..." values for the icon
      $color    = string         — Tailwind color name, e.g. 'indigo' (default)

    Slots:
      $actions  — optional slot for right-side buttons/links
--}}
@props([
    'title',
    'subtitle' => null,
    'paths'    => null,
    'color'    => 'indigo',
])

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        @if ($paths)
            <span class="p-2.5 bg-{{ $color }}-50 rounded-xl text-{{ $color }}-500 shrink-0">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    @foreach ($paths as $d)
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}" />
                    @endforeach
                </svg>
            </span>
        @endif
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-sm text-slate-500 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if ($slot->isNotEmpty())
        <div class="flex items-center gap-2 shrink-0">
            {{ $slot }}
        </div>
    @endif
</div>
