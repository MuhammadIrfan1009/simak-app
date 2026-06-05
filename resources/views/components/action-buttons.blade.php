{{--
    Props:
      $showRoute    = string      — route name for "Lihat" action
      $showParam    = mixed       — route param for show
      $editRoute    = string|null — route name for "Edit" (admin only)
      $editParam    = mixed|null  — route param for edit
      $deleteRoute  = string|null — route name for "Hapus" (admin only)
      $deleteParam  = mixed|null  — route param for delete
      $deleteConfirm = string     — confirm message (default: 'Yakin ingin menghapus data ini?')

    Usage:
      <x-action-buttons
          show-route="mahasiswa.show" :show-param="$item"
          edit-route="mahasiswa.edit" :edit-param="$item"
          delete-route="mahasiswa.destroy" :delete-param="$item"
      />
--}}
@props([
    'showRoute'     => null,
    'showParam'     => null,
    'editRoute'     => null,
    'editParam'     => null,
    'deleteRoute'   => null,
    'deleteParam'   => null,
    'deleteConfirm' => 'Yakin ingin menghapus data ini?',
])

<div class="flex items-center justify-center gap-1">

    {{-- Lihat --}}
    @if ($showRoute)
        <a href="{{ route($showRoute, $showParam) }}"
           class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/>
            </svg>
            Lihat
        </a>
    @endif

    {{-- Edit (admin only) --}}
    @if ($editRoute && auth()->user()->isAdmin())
        <a href="{{ route($editRoute, $editParam) }}"
           class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-amber-600 hover:bg-amber-50 transition-colors">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
            </svg>
            Edit
        </a>
    @endif

    {{-- Hapus (admin only) --}}
    @if ($deleteRoute && auth()->user()->isAdmin())
        <form action="{{ route($deleteRoute, $deleteParam) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('{{ $deleteConfirm }}')"
                    class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9 14 19M10 9l-.74 10M6 5h12M9 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/>
                </svg>
                Hapus
            </button>
        </form>
    @endif

</div>
