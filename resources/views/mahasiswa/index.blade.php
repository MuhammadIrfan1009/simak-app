@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">👥 Data Mahasiswa</h1>
                <p class="text-gray-500 mt-1">Cari dan lihat mahasiswa yang tersedia.</p>
            </div>

            <form action="{{ route('mahasiswa.index') }}" method="GET" class="flex gap-2">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari NIM, nama, email, jurusan"
                    class="form-input" />
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="mb-6">
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">➕ Tambah Mahasiswa</a>
            </div>
        @endif

        <!-- Success Message -->
        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-teal-50 border border-teal-200 rounded-lg">
                <p class="text-teal-800">✅ {{ $message }}</p>
            </div>
        @endif

        <!-- Table -->
        <div class="card">
            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NIM</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jurusan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Angkatan</th>
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
                                            👁️ Lihat
                                        </a>

                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('mahasiswa.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('mahasiswa.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin?')" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data mahasiswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
