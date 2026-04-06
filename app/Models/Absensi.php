<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis'; // Menunjuk ke tabel hasil migrate tadi

    protected $fillable = [
        'siswa_id', 'waktu_absen', 'tanggal_absen', 'status', 'bukti_foto'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
}