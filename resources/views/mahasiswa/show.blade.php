@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">👤 Detail Mahasiswa</h1>
                <p class="text-sm text-gray-500">Menampilkan data lengkap dan nilai mahasiswa.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <div>
                    <p class="text-sm text-gray-500">NIM</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->nim }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jurusan</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->jurusan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Angkatan</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->angkatan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->no_telepon ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="text-lg font-semibold">{{ $mahasiswa->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold">Nilai Mahasiswa</h2>
                        <p class="text-sm text-gray-500">Semua nilai yang dikaitkan dengan mahasiswa ini.</p>
                    </div>
                </div>

                @if($mahasiswa->nilais->isEmpty())
                    <div class="p-6 bg-yellow-50 rounded-lg text-yellow-800">
                        Belum ada data nilai untuk mahasiswa ini.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Semester</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Mata Kuliah</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nilai Akhir</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Grade</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @foreach($mahasiswa->nilais as $nilai)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $nilai->semester }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $nilai->mataKuliah->nama_mk ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $nilai->grade }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
