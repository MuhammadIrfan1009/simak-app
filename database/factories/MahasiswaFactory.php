<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $jurusan = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];

        $faker = fake('id_ID');

        return [
            'nim' => $faker->unique()->numerify('04112021###'),
            'nama' => $faker->name('male'),
            'email' => $faker->unique()->safeEmail(),
            'jurusan' => $faker->randomElement($jurusan),
            'angkatan' => $faker->randomElement(['2021', '2022', '2023', '2024']),
            'alamat' => $faker->address(),
            'no_telepon' => $faker->phoneNumber(),
        ];
    }
}
