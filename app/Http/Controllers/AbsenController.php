<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function scan(Request $request)
    {
        // Ambil QR code dari request (sesuai JS)
        $qr = $request->input('qr_code');

        // 1. Validasi format QR
        if (!str_starts_with($qr, 'SISWA:')) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR tidak valid'
            ]);
        }

        // 2. Ambil UUID dari QR
        $code = str_replace('SISWA:', '', $qr);

        // 3. Cari siswa
        $siswa = Siswa::where('code_qr_siswa', $code)->first();
        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan'
            ]);
        }

        // 4. Cegah double absen
        $sudahAbsen = Absen::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah absen hari ini'
            ]);
        }

        // 5. Simpan foto jika ada
        $photoPath = null;
        if ($request->has('photo')) {
            $photoData = $request->input('photo'); // data:image/png;base64,...
            $photoName = 'absen_' . $siswa->id . '_' . time() . '.png';
            $photoPath = 'bukti_absen/' . $photoName;

            // Pisahkan header base64
            $data = explode(',', $photoData)[1] ?? null;
            if ($data) {
                Storage::disk('public')->put($photoPath, base64_decode($data));
            }
        }

        // 6. Tentukan status (misal masuk sebelum jam 07:30 = HADIR, else TERLAMBAT)
        $waktuSekarang = Carbon::now();
        $status = $waktuSekarang->lt(Carbon::createFromTime(7, 30, 0)) ? 'HADIR' : 'TERLAMBAT';

        // 7. Simpan absen
        $absen = Absen::create([
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::today(),
            'jam_masuk' => $waktuSekarang->format('H:i:s'),
            'status' => $status,
            'bukti_foto' => $photoPath
        ]);

        // 8. Response JSON untuk JS
        return response()->json([
            'status' => 'success',
            'data' => [
                'nama' => $siswa->nama,
                'nisn' => $siswa->nisn,
                'kelas' => $siswa->kelas,
                'status' => $status,
                'waktu' => $waktuSekarang->format('H:i:s'),
                'foto' => $photoPath ? asset('storage/'.$photoPath) : null
            ]
        ]);
    }
}