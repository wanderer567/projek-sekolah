<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ⬇️ TAMBAHKAN use model ini
use App\Models\Kelas;
use App\Models\Absen;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'kelas_id', // optional tapi disarankan
        'role',     // optional
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =========================
       RELASI ELOQUENT
       ========================= */

    // User punya 1 kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // User punya banyak absen
    public function absens()
    {
        return $this->hasMany(Absen::class);
    }
}
