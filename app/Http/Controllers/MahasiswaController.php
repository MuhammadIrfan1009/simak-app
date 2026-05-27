<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Middleware authorization
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List semua mahasiswa
    public function index()
    {
        $mahasiswas = Mahasiswa::paginate(10);
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    // Form create
    public function create()
    {
        return view('mahasiswa.create');
    }

    // Store data ke database
    public function store(Request $request)
    {
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

    // Show detail mahasiswa
    public function show(Mahasiswa $mahasiswa)
    {
        // Load nilai untuk dilihat di detail
        $mahasiswa->load('nilais.mataKuliah');
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    // Form edit
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    // Update data
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
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

    // Delete mahasiswa permanently
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->forceDelete();

        return redirect()->route('mahasiswa.index')
                       ->with('success', 'Mahasiswa berhasil dihapus');
    }
}
