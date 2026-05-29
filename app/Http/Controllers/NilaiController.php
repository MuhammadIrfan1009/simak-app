<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    /**
     * Tampilkan semua data nilai
     */
    public function index()
    {
        $nilais = Nilai::with(['mahasiswa', 'mataKuliah.dosen'])
            ->latest()
            ->paginate(15);

        return view('nilai.index', compact('nilais'));
    }

    /**
     * Form tambah nilai
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::with('dosen')->get();

        return view('nilai.create', compact('mahasiswas', 'mataKuliahs'));
    }

    /**
     * Simpan nilai baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswas,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'semester'       => 'required|integer|min:1|max:14',
            'tahun_akademik' => 'required|string|max:20',
            'nilai_tugas'    => 'required|numeric|min:0|max:100',
            'nilai_uts'      => 'required|numeric|min:0|max:100',
            'nilai_uas'      => 'required|numeric|min:0|max:100',
        ]);

        // Hitung nilai akhir
        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $validated['nilai_tugas'],
            $validated['nilai_uts'],
            $validated['nilai_uas']
        );

        // Konversi grade dan indeks
        $grade = Nilai::nilaiKeGrade($nilaiAkhir);
        $indeks = Nilai::gradeToIndeks($grade);

        // Simpan data (simpan indeks juga)
        Nilai::create([
            ...$validated,
            'nilai_akhir' => $nilaiAkhir,
            'grade'       => $grade,
            'indeks'      => $indeks,
        ]);

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail nilai
     */
    public function show(Nilai $nilai)
    {
        $nilai->load('mahasiswa', 'mataKuliah.dosen');
        return view('nilai.show', compact('nilai'));
    }

    /**
     * Form edit nilai
     */
    public function edit(Nilai $nilai)
    {
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::with('dosen')->get();

        return view(
            'nilai.edit',
            compact('nilai', 'mahasiswas', 'mataKuliahs')
        );
    }

    /**
     * Update data nilai
     */
    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts'   => 'required|numeric|min:0|max:100',
            'nilai_uas'   => 'required|numeric|min:0|max:100',
        ]);

        // Hitung ulang nilai akhir
        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $validated['nilai_tugas'],
            $validated['nilai_uts'],
            $validated['nilai_uas']
        );

        // Konversi grade dan indeks
        $grade = Nilai::nilaiKeGrade($nilaiAkhir);
        $indeks = Nilai::gradeToIndeks($grade);

        // Update data
        $nilai->update([
            ...$validated,
            'nilai_akhir' => $nilaiAkhir,
            'grade'       => $grade,
            'indeks'      => $indeks,
        ]);

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    /**
     * Hapus nilai
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }

    /**
     * Rekap nilai mahasiswa per semester
     */
    public function rekapNilai(Request $request)
    {
        if (!$request->filled('mahasiswa_id') || !$request->filled('semester')) {
            $mahasiswas = Mahasiswa::orderBy('nama')->get();
            return view('nilai.rekap_form', compact('mahasiswas'));
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'semester'     => 'required|integer|min:1|max:14',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

        $nilais = $mahasiswa->nilais()
            ->where('semester', $request->semester)
            ->with('mataKuliah')
            ->get();

        // Hitung IP (indeks berbobot oleh SKS)
        $totalBobot = $nilais->sum(function ($n) {
            return ($n->indeks ?? 0) * ($n->mataKuliah->sks ?? 0);
        });
        $totalSks = $nilais->sum(fn($n) => $n->mataKuliah->sks ?? 0);
        $ip = $totalSks ? round($totalBobot / $totalSks, 2) : 0.00;

        // Hitung IPK (kumulatif semua semester)
        $allNilais = $mahasiswa->nilais()->with('mataKuliah')->get();
        $totalBobotAll = $allNilais->sum(function ($n) {
            return ($n->indeks ?? 0) * ($n->mataKuliah->sks ?? 0);
        });
        $totalSksAll = $allNilais->sum(fn($n) => $n->mataKuliah->sks ?? 0);
        $ipk = $totalSksAll ? round($totalBobotAll / $totalSksAll, 2) : 0.00;

        return view(
            'nilai.rekap',
            compact('mahasiswa', 'nilais', 'ip', 'totalSks', 'ipk', 'totalSksAll', 'request')
        );
    }

    /**
     * Export rekap nilai ke PDF
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'semester'     => 'required|integer',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

        $nilais = $mahasiswa->nilais()
            ->where('semester', $request->semester)
            ->with('mataKuliah')
            ->get();

        $totalBobot = $nilais->sum(function ($n) {
            return ($n->indeks ?? 0) * ($n->mataKuliah->sks ?? 0);
        });
        $totalSks = $nilais->sum(fn($n) => $n->mataKuliah->sks ?? 0);
        $ip = $totalSks ? round($totalBobot / $totalSks, 2) : 0.00;

        $pdf = Pdf::loadView(
            'nilai.pdf',
            compact('mahasiswa', 'nilais', 'ip', 'totalSks')
        );

        return $pdf->download(
            'Rekap_Nilai_' . $mahasiswa->nim . '.pdf'
        );
    }
}