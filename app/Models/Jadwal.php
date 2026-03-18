<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kelas'
    ];

    /**
     * Relasi: Jadwal ini dimiliki oleh seorang Guru (User)
     */
    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Jadwal ini memiliki satu Mata Pelajaran
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}