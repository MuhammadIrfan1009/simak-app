@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">📝 Daftar Nilai</h1>
            <a href="{{ route('nilai.create') }}" class="btn btn-primary">➕ Tambah Nilai</a>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Mata Kuliah</th>
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
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->grade }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <a href="{{ route('nilai.edit', $nilai) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('nilai.destroy', $nilai) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data nilai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $nilais->links() }}
        </div>
    </div>
</div>
@endsection
