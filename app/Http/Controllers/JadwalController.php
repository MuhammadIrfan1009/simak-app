<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function currentMahasiswa(): ?Mahasiswa
    {
        return Mahasiswa::where('email', auth()->user()->email)->first();
    }

    private function currentUserCanViewJadwal(Jadwal $jadwal): bool
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isDosen()) {
            return $jadwal->mataKuliah && $jadwal->mataKuliah->user_id === auth()->id();
        }

        if (auth()->user()->isMahasiswa()) {
            $mahasiswa = $this->currentMahasiswa();
            return $mahasiswa && $jadwal->mataKuliah->nilais()->where('mahasiswa_id', $mahasiswa->id)->exists();
        }

        return false;
    }

    public function index(Request $request)
    {
        $query = Jadwal::with('mataKuliah.dosen');
        $perPage = in_array((int) $request->get('per_page', 10), [10, 50, 100], true) ? (int) $request->get('per_page', 10) : 10;
        $sortBy = in_array($request->get('sort'), ['hari', 'ruangan', 'jam_mulai', 'jam_selesai'], true) ? $request->get('sort') : 'hari';
        $sortDirection = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        if (auth()->user()->isDosen()) {
            $query->whereHas('mataKuliah', fn($subQuery) =>
                $subQuery->where('user_id', auth()->id())
            );
        } elseif (auth()->user()->isMahasiswa()) {
            $mahasiswa = $this->currentMahasiswa();
            if (! $mahasiswa) {
                abort(403, 'Mahasiswa tidak ditemukan.');
            }

            $query->whereHas('mataKuliah.nilais', fn($subQuery) =>
                $subQuery->where('mahasiswa_id', $mahasiswa->id)
            );
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('hari', 'like', "%{$search}%")
                    ->orWhere('ruangan', 'like', "%{$search}%")
                    ->orWhereHas('mataKuliah', fn($builder) =>
                        $builder->where('kode_mk', 'like', "%{$search}%")
                            ->orWhere('nama_mk', 'like', "%{$search}%")
                            ->orWhereHas('dosen', fn($dosen) =>
                                $dosen->where('name', 'like', "%{$search}%")
                            )
                    );
            });
        }

<<<<<<< HEAD
        $jadwals = $query->orderBy($sortBy, $sortDirection)->paginate($perPage)->withQueryString();

        return view('jadwal.index', compact('jadwals', 'perPage', 'sortBy', 'sortDirection'));
=======
        $jadwals = $query->orderBy('hari')->paginate(10)->withQueryString();

        return view('jadwal.index', compact('jadwals'));
>>>>>>> ed81cea0eb6429abd0f8c7818b62d8df5a896fec
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $mataKuliahs = MataKuliah::all();
        return view('jadwal.create', compact('mataKuliahs'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string',
        ]);

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load('mataKuliah.dosen');

        if (! $this->currentUserCanViewJadwal($jadwal)) {
            abort(403, 'Unauthorized');
        }

        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $mataKuliahs = MataKuliah::all();
        return view('jadwal.edit', compact('jadwal', 'mataKuliahs'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string',
        ]);

        $jadwal->update($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $jadwal->forceDelete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
