@extends('layouts.app')

@section('title', 'Cari Rekap Nilai - SIMAK')

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 shadow-sm">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6Zm3 3h10M7 12h6M7 15h4"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4">Rekap Nilai Akademik</h1>
            <p class="text-sm text-gray-500 mt-2">Cari mahasiswa dan semester dengan pencarian cepat, tanpa daftar panjang yang membosankan.</p>
        </div>

        <div class="card shadow-xl border border-gray-100 bg-white">
            <form action="{{ route('nilai.rekap') }}" method="GET" class="space-y-6">
                <div>
                    <label for="mahasiswa_search" class="form-label font-semibold text-gray-700">Mahasiswa</label>
                    <input type="text" id="mahasiswa_search" list="mahasiswa_options" autocomplete="off" placeholder="Cari NIM / nama mahasiswa" class="form-input block w-full bg-white" required value="{{ old('mahasiswa_id') ? $mahasiswas->firstWhere('id', old('mahasiswa_id'))?->nim . ' - ' . $mahasiswas->firstWhere('id', old('mahasiswa_id'))?->nama : '' }}">
                    <datalist id="mahasiswa_options">
                        @foreach($mahasiswas as $mhs)
                            <option value="{{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->jurusan }})" data-id="{{ $mhs->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="mahasiswa_id" id="mahasiswa_id" value="{{ old('mahasiswa_id') }}">
                </div>

                <div>
                    <label for="semester_search" class="form-label font-semibold text-gray-700">Semester</label>
                    <input type="text" id="semester_search" list="semester_options" autocomplete="off" placeholder="Cari semester, contoh: 4" class="form-input block w-full bg-white" required value="{{ old('semester') ? 'Semester ' . old('semester') : '' }}">
                    <datalist id="semester_options">
                        @for($i = 1; $i <= 8; $i++)
                            <option value="Semester {{ $i }}" data-value="{{ $i }}"></option>
                        @endfor
                    </datalist>
                    <input type="hidden" name="semester" id="semester" value="{{ old('semester') }}">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn btn-primary inline-flex items-center justify-center gap-2 py-3 shadow-md hover:shadow-lg transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                        Cari Rekap Nilai
                    </button>
                </div>
                <script>
                    const mahasiswaSearch = document.getElementById('mahasiswa_search');
                    const mahasiswaHidden = document.getElementById('mahasiswa_id');
                    const semesterSearch = document.getElementById('semester_search');
                    const semesterHidden = document.getElementById('semester');
                    const mahasiswaOptions = Array.from(document.getElementById('mahasiswa_options').options);
                    const semesterOptions = Array.from(document.getElementById('semester_options').options);

                    function syncHiddenFromDatalist(searchInput, hiddenInput, options) {
                        const match = options.find(option => option.value === searchInput.value);
                        hiddenInput.value = match?.dataset?.id || match?.dataset?.value || '';
                    }

                    mahasiswaSearch.addEventListener('input', () => syncHiddenFromDatalist(mahasiswaSearch, mahasiswaHidden, mahasiswaOptions));
                    semesterSearch.addEventListener('input', () => syncHiddenFromDatalist(semesterSearch, semesterHidden, semesterOptions));
                    syncHiddenFromDatalist(mahasiswaSearch, mahasiswaHidden, mahasiswaOptions);
                    syncHiddenFromDatalist(semesterSearch, semesterHidden, semesterOptions);
                </script>
            </form>
        </div>
    </div>
</div>
@endsection
