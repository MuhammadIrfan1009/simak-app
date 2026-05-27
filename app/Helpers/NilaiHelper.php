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
     * A: 80-100
     * B: 70-79
     * C: 60-69
     * D: 50-59
     * E: 0-49
     */
    public static function nilaiKeGrade($nilai)
    {
        return match (true) {
            $nilai >= 80 => 'A',
            $nilai >= 70 => 'B',
            $nilai >= 60 => 'C',
            $nilai >= 50 => 'D',
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
