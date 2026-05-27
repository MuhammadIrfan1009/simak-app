<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $jurusan = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];

        return [
            'nim' => $this->faker->unique()->numerify('04112021###'),
            'nama' => $this->faker->name('male'),
            'email' => $this->faker->unique()->safeEmail(),
            'jurusan' => $this->faker->randomElement($jurusan),
            'angkatan' => $this->faker->randomElement(['2021', '2022', '2023', '2024']),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->faker->phoneNumber(),
        ];
    }
}
