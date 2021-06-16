<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    protected $fillable = [
        'nrp', 'nama', 'status'
    ];

    protected $primaryKey = 'nrp';
}
