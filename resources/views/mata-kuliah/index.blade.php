@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">📚 Data Mata Kuliah</h1>
                <p class="text-gray-500 mt-1">Cari dan lihat mata kuliah yang tersedia.</p>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 w-full sm:w-auto">
                <form action="{{ route('mata-kuliah.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari kode, nama, atau dosen" class="form-input" />
                    <button type="submit" class="btn btn-secondary">Cari</button>
                </form>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary">➕ Tambah Mata Kuliah</a>
                @endif
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-teal-50 border border-teal-200 rounded-lg">
                <p class="text-teal-800">✅ {{ $message }}</p>
            </div>
        @endif

        <div class="card">
            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kode MK</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">SKS</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Semester</th>
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
                                        <a href="{{ route('mata-kuliah.show', $item) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">👁️ Lihat</a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('mata-kuliah.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">✏️ Edit</a>
                                            <form action="{{ route('mata-kuliah.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mata kuliah ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">🗑️ Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data mata kuliah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $mataKuliahs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
