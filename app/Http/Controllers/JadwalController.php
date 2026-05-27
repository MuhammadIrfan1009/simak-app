<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
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
    $mataKuliahs = MataKuliah::all();
    return view('jadwal.create', compact('mataKuliahs'));
}

// Validasi jam tidak bentrok
public function store(Request $request)
{
    $validated = $request->validate([
        'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'ruangan' => 'required|string',
    ]);

    Jadwal::create($validated);
    return redirect()->route('jadwal.index')->with('success', 'Jadwal ditambahkan');
}


    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
