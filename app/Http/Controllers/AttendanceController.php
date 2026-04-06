<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel 'absensis' (sesuai screenshot phpMyAdmin)
        $absensis = Absensi::with('siswa')
            ->whereDate('tanggal_absen', Carbon::today())
            ->latest()
            ->get();

        // Path harus 'guru.absen-qr' karena file ada di resources/views/guru/absen-qr.blade.php
        return view('guru.absen-qr', compact('absensis'));
    }

    public function store(Request $request)
    {
        // Logika simpan absen (QR & Foto) di sini
    }
}