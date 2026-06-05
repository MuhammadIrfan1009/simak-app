{{--
    Props:
      $type    = 'success'|'error'|'warning'|'info'  (default: 'info')
      $message = string|null  — simple string message

    Slot:
      Use default slot for richer content (e.g. error list), overrides $message.

    Usage:
      — session flash:
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

      — validation errors:
        @if ($errors->any())
            <x-alert type="error">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif
--}}
@props([
    'type'    => 'info',
    'message' => null,
])

@php
    $styles = [
        'success' => [
            'wrapper' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
            'icon'    => 'text-emerald-500',
            'path'    => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        ],
        'error'   => [
            'wrapper' => 'bg-red-50 border-red-200 text-red-800',
            'icon'    => 'text-red-500',
            'path'    => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z',
        ],
        'warning' => [
            'wrapper' => 'bg-amber-50 border-amber-200 text-amber-800',
            'icon'    => 'text-amber-500',
            'path'    => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126Z',
        ],
        'info'    => [
            'wrapper' => 'bg-blue-50 border-blue-200 text-blue-800',
            'icon'    => 'text-blue-500',
            'path'    => 'M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z',
        ],
    ];
    $s = $styles[$type] ?? $styles['info'];
@endphp

<div class="flex items-start gap-3 rounded-xl border px-4 py-3 text-sm {{ $s['wrapper'] }}">
    <svg class="h-5 w-5 shrink-0 mt-0.5 {{ $s['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['path'] }}" />
    </svg>
    <div class="flex-1 min-w-0">
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{ $message }}
        @endif
    </div>
</div>
