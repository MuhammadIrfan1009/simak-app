<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'mahasiswa_id', 'mata_kuliah_id', 'semester', 'tahun_akademik',
        'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir', 'grade'
    ];

    protected $casts = [
        'nilai_tugas' => 'decimal:2',
        'nilai_uts' => 'decimal:2',
        'nilai_uas' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
    ];

    // Relationship
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    // Hitung nilai akhir otomatis
    public static function hitungNilaiAkhir($tugas, $uts, $uas)
    {
        return (0.20 * $tugas) + (0.30 * $uts) + (0.50 * $uas);
    }

    // Konversi nilai akhir ke grade
    public static function nilaiKeGrade($nilai)
    {
        if ($nilai >= 80) return 'A';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 60) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}
