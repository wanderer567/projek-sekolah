<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Secara default Laravel akan mencari tabel 'siswas', 
     * karena kamu menamainya 'siswa', maka harus didefinisikan di sini.
     */
    protected $table = 'siswa';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     * Sesuaikan dengan kolom yang ada di migration kamu.
     */
    protected $fillable = [
        'nama', 
        'nisn', 
        'kelas', // Tadi kamu bilang kelas masuk di kolom ini
    ];

    /**
     * Relasi ke Model Absen.
     * Satu siswa memiliki banyak data absensi.
     */
    public function absens()
    {
        return $this->hasMany(Absen::class, 'siswa_id', 'id');
    }
}