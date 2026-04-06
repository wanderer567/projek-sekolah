<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        $absensis = Absen::with('siswa')->whereDate('tanggal', Carbon::today())->latest()->get();
        return view('guru.absen-qr', compact('absensis'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'qr_code' => 'required|string',
            'photo' => 'required|string', // base64
        ]);

        $qr = $request->qr_code;
        $photo = $request->photo;

        // 2. Validasi format QR
        if (!str_starts_with($qr, 'SISWA:')) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR tidak valid',
            ]);
        }

        $code = str_replace('SISWA:', '', $qr);

        // 3. Cari siswa
        $siswa = Siswa::where('code_qr_siswa', $code)->first();
        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan',
            ]);
        }

        // 4. Cek double absen
        $sudahAbsen = Absen::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah absen hari ini',
            ]);
        }

        // 5. Simpan foto
        $photo = str_replace('data:image/png;base64,', '', $photo);
        $photo = str_replace(' ', '+', $photo);
        $photoName = 'bukti_absen/' . $siswa->id . '_' . time() . '.png';

        Storage::disk('public')->put($photoName, base64_decode($photo));

        // 6. Simpan absen
        $absen = Absen::create([
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::today(),
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'status' => 'HADIR', // bisa modif sesuai logika
            'bukti_foto' => $photoName,
        ]);

        // 7. Response JSON untuk update live log
        return response()->json([
            'status' => 'success',
            'data' => [
                'nama' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'nisn' => $siswa->nisn,
                'waktu' => $absen->jam_masuk,
                'status' => $absen->status,
                'foto' => asset('storage/' . $photoName),
            ],
        ]);
    }
}