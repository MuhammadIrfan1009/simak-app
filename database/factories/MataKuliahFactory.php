<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class MataKuliahFactory extends Factory
{
    public function definition(): array
    {
        $matkul = [
            ['Algoritma dan Pemrograman', 'DDP001', 3],
            ['Basis Data', 'DDP002', 3],
            ['Web Development', 'DDP003', 3],
            ['Jaringan Komputer', 'DDP004', 3],
            ['Sistem Operasi', 'DDP005', 3],
            ['Pemrograman Lanjut', 'DDP006', 3],
        ];

        $mk = $this->faker->randomElement($matkul);

        return [
            'kode_mk' => $mk[1],
            'nama_mk' => $mk[0],
            'sks' => $mk[2],
            'semester' => $this->faker->numberBetween(1, 8),
            'user_id' => User::where('role', 'dosen')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'dosen'])->id,
        ];
    }
}