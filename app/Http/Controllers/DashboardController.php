<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total data
        $totalMahasiswa = Mahasiswa::count();
        $totalMataKuliah = MataKuliah::count();
        $totalNilai = Nilai::count();

        // Data untuk Chart - Distribusi Nilai
        $nilaiDistribusi = [
            'A' => Nilai::where('grade', 'A')->count(),
            'B' => Nilai::where('grade', 'B')->count(),
            'C' => Nilai::where('grade', 'C')->count(),
            'D' => Nilai::where('grade', 'D')->count(),
            'E' => Nilai::where('grade', 'E')->count(),
        ];

        // Data untuk Chart - Rata-rata per jurusan
        $nilaiPerJurusan = \DB::table('nilais')
            ->join('mahasiswas', 'nilais.mahasiswa_id', '=', 'mahasiswas.id')
            ->groupBy('mahasiswas.jurusan')
            ->selectRaw('mahasiswas.jurusan, AVG(nilais.nilai_akhir) as rata_rata')
            ->get();

        // Top 5 mahasiswa dengan nilai tertinggi
        $topMahasiswa = Nilai::with('mahasiswa')
                            ->orderBy('nilai_akhir', 'desc')
                            ->limit(5)
                            ->get();

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalMataKuliah',
            'totalNilai',
            'nilaiDistribusi',
            'nilaiPerJurusan',
            'topMahasiswa'
        ));
    }
}
