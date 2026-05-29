<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode_mk', 'nama_mk', 'sks', 'semester', 'user_id'
    ];

    // Relationship: satu MK diajar oleh satu dosen
    public function dosen()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: satu MK punya banyak jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    // Relationship: satu MK punya banyak nilai
    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
