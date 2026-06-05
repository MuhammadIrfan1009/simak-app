@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Data Jadwal"
            subtitle="Cari dan lihat jadwal mata kuliah Anda."
            color="indigo"
            :paths="['M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z']"
        >
            @if (auth()->user()->isAdmin())
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Jadwal
                </a>
            @endif
        </x-page-header>

        @if (session('success'))
            <x-alert type="success" :message="session('success')" class="mb-6" />
        @endif

        <div class="card">
            <div class="table-toolbar">
                <form action="{{ route('jadwal.index') }}" method="GET"
                      class="flex flex-wrap items-center gap-3 w-full" id="jadwalSearchForm">
                    <input type="hidden" name="sort"      value="{{ request('sort', 'hari') }}">
                    <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">

                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                        </svg>
                        <input type="search" name="q" value="{{ request('q') }}"
                               data-live-search-form="jadwalSearchForm"
                               placeholder="Cari hari, ruangan, mata kuliah"
                               class="w-full" />
                    </label>

                    <label class="table-control">
                        Show
                        <select name="per_page" onchange="this.form.submit()" class="w-24">
                            @foreach ([10, 50, 100] as $n)
                                <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                        entries
                    </label>
                </form>
            </div>

            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dosen</th>

                            @foreach ([
                                ['col' => 'hari',      'label' => 'Hari'],
                                ['col' => 'jam_mulai', 'label' => 'Jam'],
                                ['col' => 'ruangan',   'label' => 'Ruangan'],
                            ] as $th)
                                @php
                                    $active    = request('sort') === $th['col'];
                                    $nextDir   = ($active && request('direction') === 'asc') ? 'desc' : 'asc';
                                    $sortUrl   = request()->fullUrlWithQuery(['sort' => $th['col'], 'direction' => $nextDir]);
                                @endphp
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    <a href="{{ $sortUrl }}" class="inline-flex items-center gap-1 hover:text-indigo-700">
                                        {{ $th['label'] }}
                                        @if ($active)
                                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </a>
                                </th>
                            @endforeach

                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($jadwals as $jadwal)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $jadwal->mataKuliah->kode_mk ?? '-' }} - {{ $jadwal->mataKuliah->nama_mk ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $jadwal->mataKuliah->dosen->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->ruangan }}</td>
                                <td class="px-6 py-4 text-center">
                                    <x-action-buttons
                                        show-route="jadwal.show" :show-param="$jadwal"
                                        :edit-route="auth()->user()->isAdmin() ? 'jadwal.edit' : null"
                                        :edit-param="$jadwal"
                                        :delete-route="auth()->user()->isAdmin() ? 'jadwal.destroy' : null"
                                        :delete-param="$jadwal"
                                        delete-confirm="Hapus jadwal ini?"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2">
                                    <x-empty-state text="Belum ada jadwal." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ $jadwals->firstItem() ?? 0 }} to {{ $jadwals->lastItem() ?? 0 }}
                    of {{ $jadwals->total() }} entries
                </p>
                <div class="text-sm text-slate-500">
                    {{ $jadwals->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
