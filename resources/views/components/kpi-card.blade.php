{{-- 
    Props:
      $card = [
        'label' => string,
        'value' => string,
        'sub'   => string|null,
        'color' => string,   // e.g. 'indigo', 'emerald', 'violet'
        'icon'  => string,   // SVG path d="..."
        'badge' => ['text' => string, 'class' => string] | null,
      ]
--}}
@props(['card'])

<div class="card hover:shadow-xl hover:shadow-{{ $card['color'] }}-100/30 transition-all duration-300 group">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">{{ $card['label'] }}</p>
            <p class="text-4xl font-extrabold text-slate-900 mt-2 tracking-tight group-hover:text-{{ $card['color'] }}-600 transition-colors">{{ $card['value'] }}</p>
            @if (!empty($card['badge']))
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold mt-1.5 border uppercase tracking-wider {{ $card['badge']['class'] }}">
                    {{ $card['badge']['text'] }}
                </span>
            @elseif (!empty($card['sub']))
                <p class="text-xs text-slate-400 mt-1 font-medium">{{ $card['sub'] }}</p>
            @endif
        </div>
        <div class="bg-{{ $card['color'] }}-50 p-4 rounded-2xl text-{{ $card['color'] }}-500 shadow-inner group-hover:bg-{{ $card['color'] }}-600 group-hover:text-white transition-all duration-300">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
            </svg>
        </div>
    </div>
</div>
