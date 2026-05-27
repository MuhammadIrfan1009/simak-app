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

    // CRUD Nilai
    Route::resource('nilai', NilaiController::class);

    // Export PDF Nilai
    Route::get('nilai/export/pdf', [NilaiController::class, 'exportPdf'])->name('nilai.export-pdf');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('nilai/{id}/export-pdf', [NilaiController::class, 'exportPdf'])->name('nilai.export-pdf');

require __DIR__.'/auth.php';
