<?php

namespace Database\Seeders;

use Database\Seeders\SiswaSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Hapus atau beri tanda komentar (//) pada bagian User ini 
    // karena ini bawaan Laravel yang bikin error kalau model User-nya belum pas
    // User::factory()->create([ ... ]);

    // Panggil seeder Siswa yang sudah kita buat tadi
    $this->call([
        SiswaSeeder::class,
    ]);
}
}
