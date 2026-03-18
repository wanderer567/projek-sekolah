<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SiswaSeeder;
use Database\Seeders\AkademikSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // URUTAN SANGAT PENTING:
        $this->call([
            UserSeeder::class,     // 1. Buat akun Guru/Admin dulu
            SiswaSeeder::class,    // 2. Buat data Siswa
            AkademikSeeder::class, // 3. Buat Jadwal (yang menghubungkan Guru & Mapel)
        ]);

        // Jika ingin menggunakan factory bawaan Laravel, pastikan di dalam sini
        // User::factory(10)->create();
    }
}

