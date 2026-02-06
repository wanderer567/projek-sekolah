<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'code_qr' => 'required',
        ]);

        // 2. Cari siswa berdasarkan Code QR
        $siswa = Siswa::where('code_qr_siswa', $request->code_qr)->first();

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan!'], 404);
        }

        // 3. Simpan data absen
        Absen::create([
            'siswa_id' => $siswa->id,
            'code_qr'  => $request->code_qr,
            'tanggal'  => Carbon::now()->format('Y-m-d'),
        ]);

        return response()->json(['message' => 'Absen berhasil untuk: ' . $siswa->nama]);
    }
}