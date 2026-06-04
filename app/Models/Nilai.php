<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory;
    protected $fillable = [
        'mahasiswa_id', 'mata_kuliah_id', 'semester', 'tahun_akademik',
        'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir', 'grade', 'indeks'
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

    // Konversi nilai akhir ke grade sesuai aturan baru
    public static function nilaiKeGrade($nilai)
    {
        return match (true) {
            $nilai >= 86.00 => 'A',
            $nilai >= 80.00 => 'A-',
            $nilai >= 75.00 => 'B+',
            $nilai >= 70.00 => 'B',
            $nilai >= 65.00 => 'B-',
            $nilai >= 60.00 => 'C+',
            $nilai >= 56.00 => 'C',
            $nilai >= 41.00 => 'D',
            default => 'E',
        };
    }

    // Konversi grade ke indeks numeric (bobot SKS)
    public static function gradeToIndeks($grade)
    {
        return match (strtoupper(trim($grade))) {
            'A' => 4.00,
            'A-' => 3.70,
            'B+' => 3.30,
            'B' => 3.00,
            'B-' => 2.70,
            'C+' => 2.30,
            'C' => 2.00,
            'D' => 1.00,
            default => 0.00,
        };
    }
}
