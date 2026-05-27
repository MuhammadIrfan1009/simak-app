<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Load user sebagai dosen
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
    return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {
        //
    }
}
