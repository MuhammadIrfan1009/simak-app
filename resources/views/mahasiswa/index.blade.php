@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 flex items-center gap-3"><svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Data Mahasiswa</h1>
                <p class="text-gray-500 mt-1">Cari dan lihat mahasiswa yang tersedia.</p>
            </div>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg> Tambah Mahasiswa</a>
            @endif
        </div>

        <!-- Success Message -->
        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-teal-50 border border-teal-200 rounded-lg">
                <p class="text-teal-800 inline-flex items-center gap-2"><svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> {{ $message }}</p>
            </div>
        @endif

        <!-- Table -->
        <div class="card">
            <div class="table-toolbar">
                <form action="{{ route('mahasiswa.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full" id="mahasiswaSearchForm">
                    <input type="hidden" name="sort" value="{{ request('sort', 'nama') }}">
                    <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                        <input type="search" name="q" value="{{ request('q') }}" data-live-search-form="mahasiswaSearchForm" placeholder="Cari NIM, nama, email, jurusan" class="w-full" />
                    </label>
                    <label class="table-control">
                        Show
                        <select name="per_page" onchange="this.form.submit()" class="w-24">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        entries
                    </label>
                </form>
            </div>

            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'nim', 'direction' => (request('sort') === 'nim' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">NIM @if(request('sort') === 'nim') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => (request('sort') === 'nama' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Nama @if(request('sort') === 'nama') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => (request('sort') === 'email' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Email @if(request('sort') === 'email') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'jurusan', 'direction' => (request('sort') === 'jurusan' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Jurusan @if(request('sort') === 'jurusan') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'angkatan', 'direction' => (request('sort') === 'angkatan' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Angkatan @if(request('sort') === 'angkatan') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
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
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('mahasiswa.show', $item) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg> Lihat
                                        </a>

                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('mahasiswa.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg> Edit
                                            </a>
                                            <form action="{{ route('mahasiswa.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin?')" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9 14 19M10 9l-.74 10M6 5h12M9 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/></svg> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr data-empty-row="true">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data mahasiswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">Showing {{ $mahasiswas->firstItem() ?? 0 }} to {{ $mahasiswas->lastItem() ?? 0 }} of {{ $mahasiswas->total() }} entries</p>
                <div class="text-sm text-slate-500">{{ $mahasiswas->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
