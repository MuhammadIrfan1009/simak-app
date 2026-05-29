<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nim', 'nama', 'email', 'jurusan', 'angkatan', 'alamat', 'no_telepon'
    ];

    // Relationship: satu mahasiswa bisa punya banyak nilai
    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    // Helper untuk menghitung rata-rata nilai
    public function rataRataNilai()
    {
        return $this->nilais()->avg('nilai_akhir');
    }
}
