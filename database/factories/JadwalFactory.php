<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MataKuliah;

class JadwalFactory extends Factory
{
    public function definition(): array
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return [
            'mata_kuliah_id' => MataKuliah::inRandomOrder()->first()->id ?? MataKuliah::factory()->create()->id,
            'hari' => $this->faker->randomElement($hari),
            'jam_mulai' => $this->faker->time('H:i', '08:00'),
            'jam_selesai' => $this->faker->time('H:i', '10:00'),
            'ruangan' => 'Ruang ' . $this->faker->randomElement(['A101', 'A102', 'A103', 'B201', 'B202']),
        ];
    }
}
