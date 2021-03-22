<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assisten extends Model
{
    protected $fillable = [
        'status', 'jabatan', 'foto', 'user_id', 'praktikum_id'
    ];
}
