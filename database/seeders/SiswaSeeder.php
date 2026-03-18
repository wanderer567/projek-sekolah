<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa; // Pastikan import model Siswa

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Data Siswa 1
        Siswa::create([
            'nama'  => 'Budi Santoso',
            'nisn'  => '12345678',
            'kelas' => '10-IPA-1',
            'nomor_absen' => '01',
        ]);

        // Data Siswa 2
        Siswa::create([
            'nama'  => 'Siti Aminah',
            'nisn'  => '87654321',
            'kelas' => '10-IPA-2',
            'nomor_absen' => '02',
        ]);
    }
}