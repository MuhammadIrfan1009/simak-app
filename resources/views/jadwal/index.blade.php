@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">🕐 Data Jadwal</h1>
                <p class="text-gray-500 mt-1">Cari dan lihat jadwal mata kuliah Anda.</p>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 w-full sm:w-auto">
                <form action="{{ route('jadwal.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari hari, ruangan, mata kuliah" class="form-input" />
                    <button type="submit" class="btn btn-secondary">Cari</button>
                </form>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary">➕ Tambah Jadwal</a>
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dosen</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Hari</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jam</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Ruangan</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($jadwals as $jadwal)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->mataKuliah->kode_mk ?? '-' }} - {{ $jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->mataKuliah->dosen->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jadwal->ruangan }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('jadwal.show', $jadwal) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">👁️ Lihat</a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('jadwal.edit', $jadwal) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">✏️ Edit</a>
                                            <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?');">
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
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $jadwals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
