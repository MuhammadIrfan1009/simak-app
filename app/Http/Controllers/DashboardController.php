<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // 1. ADMIN DASHBOARD
        if ($user->isAdmin()) {
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

        // 2. DOSEN (LECTURER) DASHBOARD
        if ($user->isDosen()) {
            // Get all courses taught by this Dosen
            $courses = MataKuliah::where('user_id', $user->id)->with('nilais')->get();
            $courseIds = $courses->pluck('id')->toArray();

            $totalSks = $courses->sum('sks');
            $totalMatakuliah = $courses->count();

            // Get total unique students enrolled in their courses
            $totalStudents = Nilai::whereIn('mata_kuliah_id', $courseIds)
                ->distinct('mahasiswa_id')
                ->count('mahasiswa_id');

            // Schedules for their courses
            $schedules = Jadwal::whereIn('mata_kuliah_id', $courseIds)
                ->with('mataKuliah')
                ->get();

            // Grade distribution in Dosen's courses
            $gradeDistribution = [
                'A' => Nilai::whereIn('mata_kuliah_id', $courseIds)->where('grade', 'A')->count(),
                'B' => Nilai::whereIn('mata_kuliah_id', $courseIds)->where('grade', 'B')->count(),
                'C' => Nilai::whereIn('mata_kuliah_id', $courseIds)->where('grade', 'C')->count(),
                'D' => Nilai::whereIn('mata_kuliah_id', $courseIds)->where('grade', 'D')->count(),
                'E' => Nilai::whereIn('mata_kuliah_id', $courseIds)->where('grade', 'E')->count(),
            ];

            // List of taught courses with active student count
            $coursesList = \DB::table('mata_kuliahs')
                ->where('mata_kuliahs.user_id', $user->id)
                ->leftJoin('nilais', 'mata_kuliahs.id', '=', 'nilais.mata_kuliah_id')
                ->groupBy('mata_kuliahs.id', 'mata_kuliahs.nama_mk', 'mata_kuliahs.kode_mk', 'mata_kuliahs.sks', 'mata_kuliahs.semester')
                ->selectRaw('mata_kuliahs.id, mata_kuliahs.nama_mk, mata_kuliahs.kode_mk, mata_kuliahs.sks, mata_kuliahs.semester, COUNT(nilais.id) as student_count')
                ->get();

            return view('dashboard', compact(
                'totalSks',
                'totalMatakuliah',
                'totalStudents',
                'schedules',
                'gradeDistribution',
                'coursesList'
            ));
        }

        // 3. MAHASISWA (STUDENT) DASHBOARD
        if ($user->isMahasiswa()) {
            // Find student profile by email
            $mahasiswa = Mahasiswa::where('email', $user->email)->first();

            if (!$mahasiswa) {
                // Return fallback state if profile doesn't exist
                return view('dashboard', [
                    'mahasiswa' => null,
                    'ipk' => 0.00,
                    'totalSks' => 0,
                    'activeCoursesCount' => 0,
                    'schedules' => collect(),
                    'recentGrades' => collect()
                ]);
            }

            // Fetch all grade records for this student
            $nilais = Nilai::where('mahasiswa_id', $mahasiswa->id)
                ->with(['mataKuliah.dosen'])
                ->get();

            $enrolledCourseIds = $nilais->pluck('mata_kuliah_id')->toArray();

            // Total SKS completed
            $totalSks = $nilais->sum(function($n) {
                return $n->mataKuliah->sks ?? 0;
            });

            // Active course count
            $activeCoursesCount = count($enrolledCourseIds);

            // Compute dynamic cumulative GPA (IPK)
            $totalBobot = $nilais->sum(function ($n) {
                return ($n->indeks ?? 0) * ($n->mataKuliah->sks ?? 0);
            });
            $totalSksAll = $nilais->sum(fn($n) => $n->mataKuliah->sks ?? 0);
            $ipk = $totalSksAll ? round($totalBobot / $totalSksAll, 2) : 0.00;

            // Class schedules based on enrolled courses
            $schedules = Jadwal::whereIn('mata_kuliah_id', $enrolledCourseIds)
                ->with('mataKuliah.dosen')
                ->get();

            // Recent 5 grades
            $recentGrades = Nilai::where('mahasiswa_id', $mahasiswa->id)
                ->with('mataKuliah')
                ->latest()
                ->limit(5)
                ->get();

            return view('dashboard', compact(
                'mahasiswa',
                'ipk',
                'totalSks',
                'activeCoursesCount',
                'schedules',
                'recentGrades'
            ));
        }

        abort(403, 'User role not defined.');
    }
}
