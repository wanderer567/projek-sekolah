<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Jadwal;

class AkademikSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Mapel
        $mtk = Mapel::create(['nama_mapel' => 'Matematika']);

        // 2. Cari ID Guru Irsyad Maulana yang tadi dibuat di UserSeeder
        $guru = User::where('email', 'guru@sekolah.com')->first();

        // 3. Buat Jadwal untuk Guru tersebut
        if ($guru) {
            Jadwal::create([
                'user_id'     => $guru->id,
                'mapel_id'    => $mtk->id,
                'hari'        => 'Senin',
                'jam_mulai'   => '07:00',
                'jam_selesai' => '09:00',
                'kelas'       => '10-IPA-1',
            ]);
        }
    }
}