@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 flex items-center gap-3"><svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-7-7 7 7m-7-7h7"/></svg> Daftar Nilai</h1>
                <p class="text-gray-500 mt-1">Cari nilai berdasarkan mahasiswa, mata kuliah, atau dosen.</p>
            </div>
            @if(auth()->user()->isDosen())
                <a href="{{ route('nilai.create') }}" class="btn btn-primary inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg> Tambah Nilai</a>
            @endif
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="table-toolbar">
                <form action="{{ route('nilai.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full" id="nilaiSearchForm">
                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                        <input type="search" name="q" value="{{ request('q') }}" data-live-search-form="nilaiSearchForm" placeholder="Cari mahasiswa, mata kuliah, dosen" class="w-full" />
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
                <table class="min-w-full divide-y">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Mata Kuliah</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Dosen</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Indeks</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nilai Akhir</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Grade</th>
                        <th class="px-6 py-3 text-right text-sm font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @forelse($nilais as $nilai)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration + ($nilais->currentPage()-1)*$nilais->perPage() }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->mahasiswa->nim }} - {{ $nilai->mahasiswa->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->mataKuliah->kode_mk ?? '-' }} - {{ $nilai->mataKuliah->nama_mk ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->mataKuliah->dosen->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($nilai->indeks ?? 0, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->grade }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <a href="{{ route('nilai.show', $nilai) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium mr-3"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg> Lihat</a>
                                @if(auth()->user()->isDosen() && $nilai->mataKuliah->user_id === auth()->id())
                                    <a href="{{ route('nilai.edit', $nilai) }}" class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-800 text-sm font-medium mr-3"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-3.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg> Edit</a>
                                    <form action="{{ route('nilai.destroy', $nilai) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-sm font-medium"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9 14 19M10 9l-.74 10M6 5h12M9 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/></svg> Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data nilai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Showing {{ $nilais->firstItem() ?? 0 }} to {{ $nilais->lastItem() ?? 0 }} of {{ $nilais->total() }} entries</p>
            <div class="text-sm text-slate-500">{{ $nilais->appends(request()->query())->links() }}</div>
        </div>
    </div>
</div>
@endsection
