@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>

                <h1 class="text-4xl font-bold text-gray-900 flex items-center gap-3"><svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg> Data Mata Kuliah</h1>
            
                <p class="text-gray-500 mt-1">Cari dan lihat mata kuliah yang tersedia.</p>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 w-full sm:w-auto">

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg> Tambah Mata Kuliah</a>
                @endif

            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-teal-50 border border-teal-200 rounded-lg">
                <p class="text-teal-800 inline-flex items-center gap-2"><svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> {{ $message }}</p>
            </div>
        @endif

        <div class="card">
            <div class="table-toolbar">
                <form action="{{ route('mata-kuliah.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full" id="mataKuliahSearchForm">
                    <input type="hidden" name="sort" value="{{ request('sort', 'nama_mk') }}">
                    <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                        <input type="search" name="q" value="{{ request('q') }}" data-live-search-form="mataKuliahSearchForm" placeholder="Cari kode, nama, atau dosen" class="w-full" />
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'kode_mk', 'direction' => (request('sort') === 'kode_mk' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Kode MK @if(request('sort') === 'kode_mk') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'nama_mk', 'direction' => (request('sort') === 'nama_mk' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Nama Mata Kuliah @if(request('sort') === 'nama_mk') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'sks', 'direction' => (request('sort') === 'sks' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">SKS @if(request('sort') === 'sks') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700"><a class="flex items-center gap-1 hover:text-indigo-700" href="{{ request()->fullUrlWithQuery(['sort' => 'semester', 'direction' => (request('sort') === 'semester' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">Semester @if(request('sort') === 'semester') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif</a></th>
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
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->dosen->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('mata-kuliah.show', $item) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg> Lihat</a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('mata-kuliah.edit', $item) }}" class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-800 text-sm font-medium"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg> Edit</a>
                                            <form action="{{ route('mata-kuliah.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mata kuliah ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-sm font-medium"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9 14 19M10 9l-.74 10M6 5h12M9 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/></svg> Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr data-empty-row="true">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data mata kuliah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">Showing {{ $mataKuliahs->firstItem() ?? 0 }} to {{ $mataKuliahs->lastItem() ?? 0 }} of {{ $mataKuliahs->total() }} entries</p>
                <div class="text-sm text-slate-500">{{ $mataKuliahs->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
