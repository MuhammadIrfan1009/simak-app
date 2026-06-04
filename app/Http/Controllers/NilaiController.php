<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function currentMahasiswa(): ?Mahasiswa
    {
        return Mahasiswa::where('email', auth()->user()->email)->first();
    }

    private function currentUserCanManageNilai(Nilai $nilai): bool
    {
        return auth()->user()->isDosen() && $nilai->mataKuliah && $nilai->mataKuliah->user_id === auth()->id();
    }

    public function index(Request $request)
    {
        $query = Nilai::with(['mahasiswa', 'mataKuliah.dosen']);
        $perPage = in_array((int) $request->get('per_page', 15), [10, 50, 100], true) ? (int) $request->get('per_page', 15) : 15;

        if (auth()->user()->isDosen()) {
            $query->whereHas('mataKuliah', fn($subQuery) =>
                $subQuery->where('user_id', auth()->id())
            );
        } elseif (auth()->user()->isMahasiswa()) {
            $mahasiswa = $this->currentMahasiswa();
            if (! $mahasiswa) {
                abort(403, 'Mahasiswa tidak ditemukan.');
            }

            $query->where('mahasiswa_id', $mahasiswa->id);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->whereHas('mahasiswa', fn($q) =>
                    $q->where('nim', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                )->orWhereHas('mataKuliah', fn($q) =>
                    $q->where('kode_mk', 'like', "%{$search}%")
                        ->orWhere('nama_mk', 'like', "%{$search}%")
                        ->orWhereHas('dosen', fn($dosen) =>
                            $dosen->where('name', 'like', "%{$search}%")
                        )
                );
            });
        }

        $nilais = $query->latest()->paginate($perPage)->withQueryString();

        return view('nilai.index', compact('nilais', 'perPage'));
    }

    /**
     * Form tambah nilai
     */
    public function create()
    {
        abort_unless(auth()->user()->isDosen(), 403);

        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $mataKuliahs = MataKuliah::where('user_id', auth()->id())->with('dosen')->get();

        return view('nilai.create', compact('mahasiswas', 'mataKuliahs'));
    }

    /**
     * Simpan nilai baru
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->isDosen(), 403);

        $validated = $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswas,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'semester'       => 'required|integer|min:1|max:14',
            'tahun_akademik' => 'required|string|max:20',
            'nilai_tugas'    => 'required|numeric|min:0|max:100',
            'nilai_uts'      => 'required|numeric|min:0|max:100',
            'nilai_uas'      => 'required|numeric|min:0|max:100',
        ]);

        $mataKuliah = MataKuliah::where('id', $validated['mata_kuliah_id'])
            ->where('user_id', auth()->id())
            ->first();

        abort_unless($mataKuliah, 403);

        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $validated['nilai_tugas'],
            $validated['nilai_uts'],
            $validated['nilai_uas']
        );

        $grade = Nilai::nilaiKeGrade($nilaiAkhir);
        $indeks = Nilai::gradeToIndeks($grade);

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

        if (auth()->user()->isAdmin()) {
            return view('nilai.show', compact('nilai'));
        }

        if (auth()->user()->isDosen() && $this->currentUserCanManageNilai($nilai)) {
            return view('nilai.show', compact('nilai'));
        }

        if (auth()->user()->isMahasiswa()) {
            $mahasiswa = $this->currentMahasiswa();
            if ($mahasiswa && $nilai->mahasiswa_id === $mahasiswa->id) {
                return view('nilai.show', compact('nilai'));
            }
        }

        abort(403, 'Unauthorized');
    }

    /**
     * Form edit nilai
     */
    public function edit(Nilai $nilai)
    {
        abort_unless($this->currentUserCanManageNilai($nilai), 403);

        $mataKuliahs = MataKuliah::where('user_id', auth()->id())->with('dosen')->get();

        return view('nilai.edit', compact('nilai', 'mataKuliahs'));
    }

    /**
     * Update data nilai
     */
    public function update(Request $request, Nilai $nilai)
    {
        abort_unless($this->currentUserCanManageNilai($nilai), 403);

        $validated = $request->validate([
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts'   => 'required|numeric|min:0|max:100',
            'nilai_uas'   => 'required|numeric|min:0|max:100',
        ]);

        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $validated['nilai_tugas'],
            $validated['nilai_uts'],
            $validated['nilai_uas']
        );

        $grade = Nilai::nilaiKeGrade($nilaiAkhir);
        $indeks = Nilai::gradeToIndeks($grade);

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
        abort_unless($this->currentUserCanManageNilai($nilai), 403);

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
        $mahasiswas = Mahasiswa::orderBy('nama');

        if (auth()->user()->isDosen()) {
            $mahasiswas->whereHas('nilais.mataKuliah', fn($query) =>
                $query->where('user_id', auth()->id())
            );
        } elseif (auth()->user()->isMahasiswa()) {
            $current = $this->currentMahasiswa();
            if (! $current) {
                abort(403, 'Mahasiswa tidak ditemukan.');
            }

            $mahasiswas->where('id', $current->id);
        }

        $mahasiswas = $mahasiswas->get();

        if (! $request->filled('mahasiswa_id') || ! $request->filled('semester')) {
            return view('nilai.rekap_form', compact('mahasiswas'));
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'semester'     => 'required|integer|min:1|max:14',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

        if (auth()->user()->isDosen()) {
            $hasAccess = $mahasiswa->nilais()
                ->whereHas('mataKuliah', fn($query) => $query->where('user_id', auth()->id()))
                ->exists();

            abort_unless($hasAccess, 403);
        }

        if (auth()->user()->isMahasiswa()) {
            $current = $this->currentMahasiswa();
            if (! $current || $current->id !== $mahasiswa->id) {
                abort(403, 'Unauthorized');
            }
        }

        $nilais = $mahasiswa->nilais()
            ->where('semester', $request->semester)
            ->when(auth()->user()->isDosen(), fn($query) =>
                $query->whereHas('mataKuliah', fn($subQuery) => $subQuery->where('user_id', auth()->id()))
            )
            ->with('mataKuliah')
            ->get();

        $totalBobot = $nilais->sum(function ($n) {
            return ($n->indeks ?? 0) * ($n->mataKuliah->sks ?? 0);
        });
        $totalSks = $nilais->sum(fn($n) => $n->mataKuliah->sks ?? 0);
        $ip = $totalSks ? round($totalBobot / $totalSks, 2) : 0.00;

        $allNilais = $mahasiswa->nilais()
            ->when(auth()->user()->isDosen(), fn($query) =>
                $query->whereHas('mataKuliah', fn($subQuery) => $subQuery->where('user_id', auth()->id()))
            )
            ->with('mataKuliah')
            ->get();

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

        if (auth()->user()->isDosen()) {
            $hasAccess = $mahasiswa->nilais()
                ->whereHas('mataKuliah', fn($query) => $query->where('user_id', auth()->id()))
                ->exists();

            abort_unless($hasAccess, 403);
        }

        if (auth()->user()->isMahasiswa()) {
            $current = $this->currentMahasiswa();
            if (! $current || $current->id !== $mahasiswa->id) {
                abort(403, 'Unauthorized');
            }
        }

        $nilais = $mahasiswa->nilais()
            ->where('semester', $request->semester)
            ->when(auth()->user()->isDosen(), fn($query) =>
                $query->whereHas('mataKuliah', fn($subQuery) => $subQuery->where('user_id', auth()->id()))
            )
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