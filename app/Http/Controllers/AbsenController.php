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
        try {
            $qr = $request->input('qr_code');

            // 1. Validasi QR code
            if (!str_starts_with($qr, 'SISWA:')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR tidak valid'
                ], 400);
            }

            // 2. Ambil kode siswa
            $code = str_replace('SISWA:', '', $qr);

            // 3. Cari siswa
            $siswa = Siswa::where('code_qr_siswa', $code)->first();
            if (!$siswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            // 4. Cek double absen
            $sudahAbsen = Absen::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', Carbon::today())
                ->exists();

            if ($sudahAbsen) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sudah absen hari ini'
                ], 409);
            }

            // 5. Simpan foto (base64)
            $photoPath = null;
            if ($request->has('photo')) {
                $photoData = $request->input('photo');
                $photoName = 'absen_' . $siswa->id . '_' . time() . '.png';
                $photoPath = 'bukti_absen/' . $photoName;

                $data = explode(',', $photoData)[1] ?? null;
                if ($data) {
                    Storage::disk('public')->put($photoPath, base64_decode($data));
                }
            }

            // 6. Tentukan status
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

            // 8. Response JSON
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nama' => $siswa->nama,
                    'nisn' => $siswa->nisn,
                    'kelas' => $siswa->kelas,
                    'status' => $status,
                    'waktu' => $waktuSekarang->format('H:i:s'),
                    'foto' => $photoPath ? asset('storage/' . $photoPath) : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        
    }
}