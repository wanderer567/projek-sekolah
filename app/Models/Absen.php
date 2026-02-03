<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absens';

    // Absen milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
