<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = ['nama_mapel'];

    /**
     * Relasi: Satu Mata Pelajaran bisa muncul di banyak Jadwal
     */
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}