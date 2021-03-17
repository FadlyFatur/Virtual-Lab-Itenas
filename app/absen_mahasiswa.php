<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absen_mahasiswa extends Model
{
    protected $fillable = [
        'status', 'tipe', 'absen_id', 'user_id'
    ];
}
