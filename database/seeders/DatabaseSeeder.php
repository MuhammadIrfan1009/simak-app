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

        // Seed some specific Dosen accounts
        $dosenList = [
            ['name' => 'Dr. Budi Santoso', 'email' => 'budi@simak.com'],
            ['name' => 'Prof. Ani Wijaya', 'email' => 'ani@simak.com'],
            ['name' => 'Hendra Wijaya, M.T.', 'email' => 'hendra@simak.com'],
            ['name' => 'Rina Lestari, M.Kom.', 'email' => 'rina@simak.com'],
        ];

        foreach ($dosenList as $dosen) {
            User::updateOrCreate(
                ['email' => $dosen['email']],
                [
                    'name' => $dosen['name'],
                    'password' => bcrypt('password'),
                    'role' => 'dosen',
                ]
            );
        }

        // Create Mahasiswa profiles
        $mahasiswas = Mahasiswa::factory(30)->create();

        // Seed Mahasiswa accounts that match the Mahasiswa profiles exactly
        foreach ($mahasiswas as $mhs) {
            User::updateOrCreate(
                ['email' => $mhs->email],
                [
                    'name' => $mhs->nama,
                    'password' => bcrypt('password'),
                    'role' => 'mahasiswa',
                ]
            );
        }

        // Create mata kuliah list
        $matkuls = [
            ['nama_mk' => 'Algoritma dan Pemrograman', 'kode_mk' => 'IF101', 'sks' => 3, 'semester' => 1],
            ['nama_mk' => 'Basis Data', 'kode_mk' => 'IF102', 'sks' => 3, 'semester' => 2],
            ['nama_mk' => 'Web Development', 'kode_mk' => 'IF103', 'sks' => 3, 'semester' => 3],
            ['nama_mk' => 'Jaringan Komputer', 'kode_mk' => 'IF104', 'sks' => 3, 'semester' => 3],
            ['nama_mk' => 'Sistem Operasi', 'kode_mk' => 'IF105', 'sks' => 3, 'semester' => 4],
            ['nama_mk' => 'Pemrograman Lanjut', 'kode_mk' => 'IF106', 'sks' => 3, 'semester' => 2],
            ['nama_mk' => 'Struktur Data', 'kode_mk' => 'IF201', 'sks' => 3, 'semester' => 2],
            ['nama_mk' => 'Rekayasa Perangkat Lunak', 'kode_mk' => 'IF202', 'sks' => 3, 'semester' => 4],
            ['nama_mk' => 'Kecerdasan Buatan', 'kode_mk' => 'IF203', 'sks' => 3, 'semester' => 5],
            ['nama_mk' => 'Pemrograman Mobile', 'kode_mk' => 'IF204', 'sks' => 3, 'semester' => 5],
            ['nama_mk' => 'Keamanan Informasi', 'kode_mk' => 'IF205', 'sks' => 3, 'semester' => 6],
            ['nama_mk' => 'Analisis dan Desain Sistem', 'kode_mk' => 'SI101', 'sks' => 3, 'semester' => 3],
            ['nama_mk' => 'Manajemen Proyek TI', 'kode_mk' => 'SI102', 'sks' => 3, 'semester' => 5],
            ['nama_mk' => 'E-Business', 'kode_mk' => 'SI103', 'sks' => 3, 'semester' => 4],
            ['nama_mk' => 'Arsitektur Enterprise', 'kode_mk' => 'SI104', 'sks' => 3, 'semester' => 6],
            ['nama_mk' => 'Interaksi Manusia dan Komputer', 'kode_mk' => 'TK101', 'sks' => 3, 'semester' => 3],
            ['nama_mk' => 'Sistem Tertanam', 'kode_mk' => 'TK102', 'sks' => 4, 'semester' => 5],
            ['nama_mk' => 'Pengantar Teknologi Informasi', 'kode_mk' => 'KU101', 'sks' => 2, 'semester' => 1],
            ['nama_mk' => 'Etika Profesi', 'kode_mk' => 'KU102', 'sks' => 2, 'semester' => 4],
            ['nama_mk' => 'Kalkulus', 'kode_mk' => 'KU103', 'sks' => 3, 'semester' => 1],
        ];

        $dosenIds = User::where('role', 'dosen')->pluck('id')->toArray();

        foreach ($matkuls as $mk) {
            MataKuliah::updateOrCreate(
                ['kode_mk' => $mk['kode_mk']],
                array_merge($mk, [
                    'user_id' => $dosenIds[array_rand($dosenIds)]
                ])
            );
        }

        $allMataKuliahs = MataKuliah::all();

        // Reset nilai data first to prevent stale duplicates from previous seed runs.
        Nilai::query()->delete();

        // Create jadwal
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $ruangans = ['Ruang A101', 'Ruang A102', 'Ruang A103', 'Ruang B201', 'Ruang B202'];
        $waktuOptions = [
            ['08:00:00', '10:30:00'],
            ['10:30:00', '13:00:00'],
            ['13:30:00', '16:00:00'],
        ];

        foreach ($allMataKuliahs as $mk) {
            $waktu = $waktuOptions[array_rand($waktuOptions)];
            Jadwal::create([
                'mata_kuliah_id' => $mk->id,
                'hari' => $hari[array_rand($hari)],
                'jam_mulai' => $waktu[0],
                'jam_selesai' => $waktu[1],
                'ruangan' => $ruangans[array_rand($ruangans)],
            ]);
        }

        // Create nilai records for each student
        $tahunAkademiks = ['2024/2025 Ganjil', '2024/2025 Genap'];

        foreach ($mahasiswas as $mhs) {
            // Assign 4 to 6 random courses
            $mhsMatkul = $allMataKuliahs->random(rand(4, 7));
            foreach ($mhsMatkul as $mk) {
                $nilaiTugas = rand(65, 100);
                $nilaiUts = rand(60, 95);
                $nilaiUas = rand(55, 100);
                $nilaiAkhir = Nilai::hitungNilaiAkhir($nilaiTugas, $nilaiUts, $nilaiUas);
                $grade = Nilai::nilaiKeGrade($nilaiAkhir);
                $indeks = Nilai::gradeToIndeks($grade);

                Nilai::updateOrCreate(
                    [
                        'mahasiswa_id' => $mhs->id,
                        'mata_kuliah_id' => $mk->id,
                        'semester' => $mk->semester,
                    ],
                    [
                        'tahun_akademik' => $tahunAkademiks[rand(0, 1)],
                        'nilai_tugas' => $nilaiTugas,
                        'nilai_uts' => $nilaiUts,
                        'nilai_uas' => $nilaiUas,
                        'nilai_akhir' => $nilaiAkhir,
                        'grade' => $grade,
                        'indeks' => $indeks,
                    ]
                );
            }
        }
    }
}
