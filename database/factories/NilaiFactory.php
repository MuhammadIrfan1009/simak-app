<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;

class NilaiFactory extends Factory
{
    public function definition(): array
    {
        $nilaiTugas = $this->faker->numberBetween(60, 100);
        $nilaiUts = $this->faker->numberBetween(60, 100);
        $nilaiUas = $this->faker->numberBetween(60, 100);

        $nilaiAkhir = Nilai::hitungNilaiAkhir($nilaiTugas, $nilaiUts, $nilaiUas);
        $grade = Nilai::nilaiKeGrade($nilaiAkhir);
        $indeks = Nilai::gradeToIndeks($grade);

        return [
            'mahasiswa_id' => Mahasiswa::inRandomOrder()->first()->id ?? Mahasiswa::factory()->create()->id,
            'mata_kuliah_id' => MataKuliah::inRandomOrder()->first()->id ?? MataKuliah::factory()->create()->id,
            'semester' => $this->faker->numberBetween(1, 8),
            'tahun_akademik' => $this->faker->randomElement(['2023/2024', '2024/2025']),
            'nilai_tugas' => $nilaiTugas,
            'nilai_uts' => $nilaiUts,
            'nilai_uas' => $nilaiUas,
            'nilai_akhir' => $nilaiAkhir,
            'grade' => $grade,
            'indeks' => $indeks,
        ];
    }
}
