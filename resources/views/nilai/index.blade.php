@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-page-header
            title="Daftar Nilai"
            subtitle="Cari nilai berdasarkan mahasiswa, mata kuliah, atau dosen."
            color="indigo"
            :paths="['M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-7-7 7 7m-7-7h7']"
        >
            @if (auth()->user()->isDosen())
                <a href="{{ route('nilai.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Nilai
                </a>
            @endif
        </x-page-header>

        @if (session('success'))
            <x-alert type="success" :message="session('success')" class="mb-6" />
        @endif

        <div class="card">
            <div class="table-toolbar">
                <form action="{{ route('nilai.index') }}" method="GET"
                      class="flex flex-wrap items-center gap-3 w-full" id="nilaiSearchForm">
                    <label class="table-control flex-1 min-w-72">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                        </svg>
                        <input type="search" name="q" value="{{ request('q') }}"
                               data-live-search-form="nilaiSearchForm"
                               placeholder="Cari mahasiswa, mata kuliah, dosen"
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
                        @forelse ($nilais as $nilai)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $loop->iteration + ($nilais->currentPage() - 1) * $nilais->perPage() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $nilai->mahasiswa->nim }} - {{ $nilai->mahasiswa->nama }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $nilai->mataKuliah->kode_mk ?? '-' }} - {{ $nilai->mataKuliah->nama_mk ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $nilai->mataKuliah->dosen->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ number_format($nilai->indeks ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ number_format($nilai->nilai_akhir, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->grade }}</td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <x-action-buttons
                                        show-route="nilai.show" :show-param="$nilai"
                                        :edit-route="auth()->user()->isDosen() && $nilai->mataKuliah->user_id === auth()->id() ? 'nilai.edit' : null"
                                        :edit-param="$nilai"
                                        :delete-route="auth()->user()->isDosen() && $nilai->mataKuliah->user_id === auth()->id() ? 'nilai.destroy' : null"
                                        :delete-param="$nilai"
                                        delete-confirm="Hapus nilai ini?"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-2">
                                    <x-empty-state text="Belum ada data nilai." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ $nilais->firstItem() ?? 0 }} to {{ $nilais->lastItem() ?? 0 }}
                    of {{ $nilais->total() }} entries
                </p>
                <div class="text-sm text-slate-500">
                    {{ $nilais->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
