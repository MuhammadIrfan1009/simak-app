@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Data Mata Kuliah"
            subtitle="Cari dan lihat mata kuliah yang tersedia."
            :paths="['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253']"
        >
            @if (auth()->user()->isAdmin())
                <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Mata Kuliah
                </a>
            @endif
        </x-page-header>

        @if (session('success'))
            <div class="mb-6">
                <x-alert type="success" :message="session('success')" />
            </div>
        @endif

        <div class="card">
            {{-- Toolbar --}}
            <div class="table-toolbar">
                <form action="{{ route('mata-kuliah.index') }}" method="GET"
                      class="flex flex-wrap items-center gap-3 w-full" id="mataKuliahSearchForm">
                    <input type="hidden" name="sort"      value="{{ request('sort', 'nama_mk') }}">
                    <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">

                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                        </svg>
                        <input type="search" name="q" value="{{ request('q') }}"
                               data-live-search-form="mataKuliahSearchForm"
                               placeholder="Cari kode, nama, atau dosen" class="w-full" />
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

            {{-- Table --}}
            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            @foreach ([
                                'kode_mk'  => 'Kode MK',
                                'nama_mk'  => 'Nama Mata Kuliah',
                                'sks'      => 'SKS',
                                'semester' => 'Semester',
                            ] as $col => $label)
                                @php
                                    $dir = (request('sort') === $col && request('direction') === 'asc') ? 'desc' : 'asc';
                                    $url = request()->fullUrlWithQuery(['sort' => $col, 'direction' => $dir]);
                                @endphp
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    <a class="flex items-center gap-1 hover:text-indigo-700" href="{{ $url }}">
                                        {{ $label }}
                                        @if (request('sort') === $col)
                                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </a>
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dosen</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($mataKuliahs as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $item->kode_mk }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->nama_mk }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->sks }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->semester }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->dosen->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <x-action-buttons
                                        show-route="mata-kuliah.show"    :show-param="$item"
                                        edit-route="mata-kuliah.edit"    :edit-param="$item"
                                        delete-route="mata-kuliah.destroy" :delete-param="$item"
                                        delete-confirm="Hapus mata kuliah {{ $item->nama_mk }}?"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4">
                                    <x-empty-state text="Belum ada data mata kuliah." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ $mataKuliahs->firstItem() ?? 0 }} to {{ $mataKuliahs->lastItem() ?? 0 }}
                    of {{ $mataKuliahs->total() }} entries
                </p>
                <div class="text-sm text-slate-500">
                    {{ $mataKuliahs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
