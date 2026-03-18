<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'nip' => '000000'
        ]);

        // Akun Guru (Ini yang akan kita pakai buat ngetes Jadwal)
        User::create([
            'name' => 'Irsyad Maulana, S.Pd',
            'email' => 'guru@sekolah.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
            'nip' => '198701012024', // Contoh NIP
        ]);
    }
}