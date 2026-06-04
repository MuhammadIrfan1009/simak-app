<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function currentMahasiswa(): ?Mahasiswa
    {
        return Mahasiswa::where('email', auth()->user()->email)->first();
    }

    private function mahasiswaIsTaughtByCurrentDosen(Mahasiswa $mahasiswa): bool
    {
        return $mahasiswa->nilais()
            ->whereHas('mataKuliah', fn($query) => $query->where('user_id', auth()->id()))
            ->exists();
    }

    public function index(Request $request)
    {
        $query = Mahasiswa::query();
<<<<<<< HEAD
        $perPage = in_array((int) $request->get('per_page', 10), [10, 50, 100], true) ? (int) $request->get('per_page', 10) : 10;
        $sortBy = in_array($request->get('sort'), ['nim', 'nama', 'email', 'jurusan', 'angkatan'], true) ? $request->get('sort') : 'nama';
        $sortDirection = $request->get('direction') === 'desc' ? 'desc' : 'asc';
=======
>>>>>>> ed81cea0eb6429abd0f8c7818b62d8df5a896fec

        if (auth()->user()->isDosen()) {
            $query->whereHas('nilais.mataKuliah', fn($subQuery) =>
                $subQuery->where('user_id', auth()->id())
            );
        } elseif (auth()->user()->isMahasiswa()) {
            $current = $this->currentMahasiswa();
            if (! $current) {
                abort(403, 'Mahasiswa tidak ditemukan.');
            }

            $query->where('id', $current->id);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nim', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

<<<<<<< HEAD
        $mahasiswas = $query->orderBy($sortBy, $sortDirection)->paginate($perPage)->withQueryString();

        return view('mahasiswa.index', compact('mahasiswas', 'perPage', 'sortBy', 'sortDirection'));
=======
        $mahasiswas = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('mahasiswa.index', compact('mahasiswas'));
>>>>>>> ed81cea0eb6429abd0f8c7818b62d8df5a896fec
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'nim' => 'required|string|unique:mahasiswas',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas',
            'jurusan' => 'required|in:Informatika,Sistem Informasi,Teknik Komputer',
            'angkatan' => 'required|string',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string',
        ]);

        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')
                       ->with('success', 'Mahasiswa berhasil ditambahkan');
    }

<<<<<<< HEAD
    public function show(Request $request, Mahasiswa $mahasiswa)
=======
    public function show(Mahasiswa $mahasiswa)
>>>>>>> ed81cea0eb6429abd0f8c7818b62d8df5a896fec
    {
        if (auth()->user()->isDosen()) {
            if (! $this->mahasiswaIsTaughtByCurrentDosen($mahasiswa)) {
                abort(403, 'Unauthorized');
            }

            $mahasiswa->load(['nilais' => fn($query) => $query->whereHas('mataKuliah', fn($q) => $q->where('user_id', auth()->id()))->with('mataKuliah')]);
        } elseif (auth()->user()->isMahasiswa()) {
            $current = $this->currentMahasiswa();
            if (! $current || $current->id !== $mahasiswa->id) {
                abort(403, 'Unauthorized');
            }

            $mahasiswa->load('nilais.mataKuliah');
        } else {
            $mahasiswa->load('nilais.mataKuliah');
        }

<<<<<<< HEAD
        $selectedSemester = $request->input('semester');
        $filteredNilais = $mahasiswa->nilais
            ->when($selectedSemester !== null && $selectedSemester !== '', fn ($collection) => $collection->where('semester', (int) $selectedSemester));

        $semesterSummaries = $filteredNilais
            ->groupBy('semester')
            ->map(function ($items, $semester) {
                $totalSks = $items->sum(fn ($item) => (int) ($item->mataKuliah->sks ?? 0));
                $totalBobot = $items->sum(fn ($item) => ($item->indeks ?? 0) * ($item->mataKuliah->sks ?? 0));
                $ip = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0.00;

                return [
                    'semester' => (int) $semester,
                    'items' => $items->sortBy('mataKuliah.nama_mk'),
                    'totalSks' => $totalSks,
                    'totalBobot' => $totalBobot,
                    'ip' => $ip,
                    'progress' => $totalSks > 0 ? min(100, (float) ($ip / 4) * 100) : 0,
                ];
            })
            ->sortBy('semester')
            ->values();

        $totalSksAll = $mahasiswa->nilais->sum(fn ($item) => (int) ($item->mataKuliah->sks ?? 0));
        $totalBobotAll = $mahasiswa->nilais->sum(fn ($item) => ($item->indeks ?? 0) * ($item->mataKuliah->sks ?? 0));
        $ipk = $totalSksAll > 0 ? round($totalBobotAll / $totalSksAll, 2) : 0.00;

        $availableSemesters = $mahasiswa->nilais
            ->pluck('semester')
            ->filter(fn ($semester) => is_numeric($semester))
            ->unique()
            ->sort()
            ->values();

        return view('mahasiswa.show', compact('mahasiswa', 'semesterSummaries', 'ipk', 'totalSksAll', 'availableSemesters', 'selectedSemester'));
=======
        return view('mahasiswa.show', compact('mahasiswa'));
>>>>>>> ed81cea0eb6429abd0f8c7818b62d8df5a896fec
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
            'jurusan' => 'required|in:Informatika,Sistem Informasi,Teknik Komputer',
            'angkatan' => 'required|string',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.show', $mahasiswa)
                       ->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $mahasiswa->forceDelete();

        return redirect()->route('mahasiswa.index')
                       ->with('success', 'Mahasiswa berhasil dihapus');
    }
}
