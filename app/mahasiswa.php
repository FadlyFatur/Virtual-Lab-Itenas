<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    protected $fillable = [
        'nama', 'nomer_unik'
    ];
}
