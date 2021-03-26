<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    protected $fillable = [
        'nama', 'nomer_id', 'status', 'user_id', 'jurusan_id'
    ];

    protected $primaryKey = 'nrp';
}
