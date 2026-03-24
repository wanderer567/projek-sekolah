<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    public function model(array $row)
    {
        // if ($)
        if ($row[0] == 'nama') return null;

        return new Siswa([
            'nama' => $row[0],
            'nisn' => $row[1],
            'nomor_absen' => $row[2],
            'kelas' => $row[3],
        ]);
    }
}