<?php

namespace App\Helpers;

class NilaiHelper
{
    /**
     * Hitung nilai akhir dari komponen
     * @param float $tugas Bobot 20%
     * @param float $uts Bobot 30%
     * @param float $uas Bobot 50%
     * @return float Nilai akhir
     */
    public static function hitungNilaiAkhir($tugas, $uts, $uas)
    {
        return (0.20 * $tugas) + (0.30 * $uts) + (0.50 * $uas);
    }

    /**
     * Konversi nilai numerik ke grade
     * A  = 86.00 - 100.00
     * A- = 80.00 - 85.99
     * B+ = 75.00 - 79.99
     * B  = 70.00 - 74.99
     * B- = 65.00 - 69.99
     * C+ = 60.00 - 64.99
     * C  = 56.00 - 59.99
     * D  = 41.00 - 55.99
     * E  = 0.00 - 40.99
     */
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
            default => 'E'
        };
    }

    /**
     * Get warna badge berdasarkan grade
     */
    public static function getGradeBadgeColor($grade)
    {
        return match ($grade) {
            'A' => 'bg-green-100 text-green-800',
            'B' => 'bg-blue-100 text-blue-800',
            'C' => 'bg-yellow-100 text-yellow-800',
            'D' => 'bg-orange-100 text-orange-800',
            'E' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get emoji untuk grade
     */
    public static function getGradeEmoji($grade)
    {
        return match ($grade) {
            'A' => '🌟',
            'B' => '✨',
            'C' => '👍',
            'D' => '⚠️',
            'E' => '❌',
            default => '❓'
        };
    }
}
