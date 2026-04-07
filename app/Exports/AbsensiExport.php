<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return Absensi::whereDate('waktu_absen', $this->date)
            ->with('siswa')
            ->get()
            ->map(function($item) {
                return [
                    'Nama' => $item->siswa->nama,
                    'NISN' => $item->siswa->nisn,
                    'Kelas' => $item->siswa->kelas,
                    'Status' => $item->status,
                    'Waktu' => $item->waktu_absen,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'NISN', 'Kelas', 'Status', 'Waktu'];
    }
}