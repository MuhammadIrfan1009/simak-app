<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mataKuliahs = MataKuliah::with('dosen')->paginate(10);
        return view('mata-kuliah.index', compact('mataKuliahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('mata-kuliah.create', compact('dosens'));
    }

    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $mataKuliah)
    {
        $mataKuliah->load('dosen', 'jadwals', 'nilais');
        return view('mata-kuliah.show', compact('mataKuliah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $mataKuliah)
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('mata-kuliah.edit', compact('mataKuliah', 'dosens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $mataKuliah)
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->forceDelete();

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil dihapus');
    }
}
