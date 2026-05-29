<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function currentMahasiswa(): ?Mahasiswa
    {
        return Mahasiswa::where('email', auth()->user()->email)->first();
    }

    private function currentUserCanViewMataKuliah(MataKuliah $mataKuliah): bool
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isDosen()) {
            return $mataKuliah->user_id === auth()->id();
        }

        if (auth()->user()->isMahasiswa()) {
            $mahasiswa = $this->currentMahasiswa();
            return $mahasiswa && $mataKuliah->nilais()->where('mahasiswa_id', $mahasiswa->id)->exists();
        }

        return false;
    }

    public function index(Request $request)
    {
        $query = MataKuliah::with('dosen');

        if (auth()->user()->isDosen()) {
            $query->where('user_id', auth()->id());
        } elseif (auth()->user()->isMahasiswa()) {
            $mahasiswa = $this->currentMahasiswa();
            if (! $mahasiswa) {
                abort(403, 'Mahasiswa tidak ditemukan.');
            }

            $query->whereHas('nilais', fn($subQuery) =>
                $subQuery->where('mahasiswa_id', $mahasiswa->id)
            );
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('kode_mk', 'like', "%{$search}%")
                    ->orWhere('nama_mk', 'like', "%{$search}%")
                    ->orWhere('semester', 'like', "%{$search}%")
                    ->orWhereHas('dosen', fn($builder) =>
                        $builder->where('name', 'like', "%{$search}%")
                    );
            });
        }

        $mataKuliahs = $query->orderBy('nama_mk')->paginate(10)->withQueryString();

        return view('mata-kuliah.index', compact('mataKuliahs'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $dosens = User::where('role', 'dosen')->get();
        return view('mata-kuliah.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'kode_mk' => 'required|string|unique:mata_kuliahs',
            'nama_mk' => 'required|string',
            'sks' => 'required|integer|min:1|max:4',
            'semester' => 'required|integer|min:1|max:8',
            'user_id' => 'required|exists:users,id',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    public function show(MataKuliah $mataKuliah)
    {
        if (! $this->currentUserCanViewMataKuliah($mataKuliah)) {
            abort(403, 'Unauthorized');
        }

        if (auth()->user()->isMahasiswa()) {
            $currentMahasiswa = $this->currentMahasiswa();
            $mataKuliah->load([
                'dosen',
                'jadwals',
                'nilais' => fn ($query) => $query->where('mahasiswa_id', $currentMahasiswa?->id)->with('mahasiswa'),
            ]);
        } else {
            $mataKuliah->load('dosen', 'jadwals', 'nilais');
        }

        return view('mata-kuliah.show', compact('mataKuliah'));
    }

    public function edit(MataKuliah $mataKuliah)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $dosens = User::where('role', 'dosen')->get();
        return view('mata-kuliah.edit', compact('mataKuliah', 'dosens'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'kode_mk' => 'required|string|unique:mata_kuliahs,kode_mk,' . $mataKuliah->id,
            'nama_mk' => 'required|string',
            'sks' => 'required|integer|min:1|max:4',
            'semester' => 'required|integer|min:1|max:8',
            'user_id' => 'required|exists:users,id',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $mataKuliah->forceDelete();

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil dihapus');
    }
}
