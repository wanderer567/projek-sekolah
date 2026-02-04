<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    // Kelas punya banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

