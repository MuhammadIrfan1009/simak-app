<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Mahasiswa
    Route::resource('mahasiswa', MahasiswaController::class);

    // CRUD Mata Kuliah
    Route::resource('mata-kuliah', MataKuliahController::class);

    // CRUD Jadwal
    Route::resource('jadwal', JadwalController::class);

    // Rekap Nilai & Export PDF (declared before resource route to avoid conflicts with 'nilai/{nilai}')
    Route::get('nilai/rekap', [NilaiController::class, 'rekapNilai'])->name('nilai.rekap');
    Route::get('nilai/export/pdf', [NilaiController::class, 'exportPdf'])->name('nilai.export-pdf');
    Route::resource('nilai', NilaiController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
