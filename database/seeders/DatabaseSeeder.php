<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Jadwal;
use App\Models\Nilai;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update admin user to avoid duplicate entries
        User::updateOrCreate(
            ['email' => 'admin@simak.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        User::factory(3)->create(['role' => 'dosen']);
        User::factory(20)->create(['role' => 'mahasiswa']);

        // Create mahasiswa
        Mahasiswa::factory(50)->create();

        // Create mata kuliah
        MataKuliah::factory(15)->create();

        // Create jadwal
        Jadwal::factory(30)->create();

        // Create nilai
        Nilai::factory(200)->create();
    }
}
