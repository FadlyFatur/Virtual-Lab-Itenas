<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dosen extends Model
{
    protected $fillable = [
        'nama', 'nomer_id', 'status', 'user_id'
    ];
}
