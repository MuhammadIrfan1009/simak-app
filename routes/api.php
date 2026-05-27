<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::middleware('auth:sanctum')->group(function () {
    // Get mahasiswa by NIM (untuk autocomplete)
    Route::get('/mahasiswa/search/{nim}', function ($nim) {
        $mahasiswa = \App\Models\Mahasiswa::where('nim', 'like', "%{$nim}%")
            ->select('id', 'nim', 'nama', 'email')
            ->limit(10)
            ->get();
        return response()->json($mahasiswa);
    });

    // Get mata kuliah options
    Route::get('/mata-kuliah/select', function () {
        $mataKuliahs = \App\Models\MataKuliah::select('id', 'kode_mk', 'nama_mk')->get();
        return response()->json($mataKuliahs);
    });
});
