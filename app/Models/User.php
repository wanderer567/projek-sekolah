<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara massal.
     * nip dan role ditambahkan agar sesuai dengan kebutuhan data Guru.
     */
    protected $fillable = [
    'name',
    'nip', // Tambahkan ini
    'email',
    'password',
    'role',
    'last_seen',
];

    /**
     * Kolom yang disembunyikan saat pemanggilan data (misal: JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data kolom secara otomatis.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * RELASI: Satu User (Guru) memiliki banyak Jadwal.
     * Ini menghubungkan User ke tabel jadwals melalui user_id.
     */
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'user_id');
    }
}