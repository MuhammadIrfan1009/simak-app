@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Data Mahasiswa"
            subtitle="Cari dan kelola data mahasiswa yang terdaftar."
            :paths="['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z']"
        >
            @if (auth()->user()->isAdmin())
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Mahasiswa
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
                <form action="{{ route('mahasiswa.index') }}" method="GET"
                      class="flex flex-wrap items-center gap-3 w-full" id="mahasiswaSearchForm">
                    <input type="hidden" name="sort"      value="{{ request('sort', 'nama') }}">
                    <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">

                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                        </svg>
                        <input type="search" name="q" value="{{ request('q') }}"
                               data-live-search-form="mahasiswaSearchForm"
                               placeholder="Cari NIM, nama, email, jurusan" class="w-full" />
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
                                'nim'      => 'NIM',
                                'nama'     => 'Nama',
                                'email'    => 'Email',
                                'jurusan'  => 'Jurusan',
                                'angkatan' => 'Angkatan',
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
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($mahasiswas as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $item->nim }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $item->jurusan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->angkatan }}</td>
                                <td class="px-6 py-4">
                                    <x-action-buttons
                                        show-route="mahasiswa.show" :show-param="$item"
                                        edit-route="mahasiswa.edit" :edit-param="$item"
                                        delete-route="mahasiswa.destroy" :delete-param="$item"
                                        delete-confirm="Yakin ingin menghapus mahasiswa {{ $item->nama }}?"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4">
                                    <x-empty-state text="Belum ada data mahasiswa yang ditemukan." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ $mahasiswas->firstItem() ?? 0 }} to {{ $mahasiswas->lastItem() ?? 0 }}
                    of {{ $mahasiswas->total() }} entries
                </p>
                <div class="text-sm text-slate-500">
                    {{ $mahasiswas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
