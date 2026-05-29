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

        $mahasiswas = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('mahasiswa.index', compact('mahasiswas'));
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

    public function show(Mahasiswa $mahasiswa)
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

        return view('mahasiswa.show', compact('mahasiswa'));
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
