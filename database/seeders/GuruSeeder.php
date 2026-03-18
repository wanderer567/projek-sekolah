<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <--- WAJIB ADA agar 'User' tidak undefined
use Illuminate\Support\Facades\Hash; // <--- WAJIB ADA agar 'Hash' tidak undefined

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Data Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Data Guru
        User::create([
            'name' => 'Meizi',
            'email' => 'guru@mail.com',
            'password' => Hash::make('meizi123'),
            'role' => 'guru',
        ]);
    }
}