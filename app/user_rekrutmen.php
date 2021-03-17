<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_rekrutmen extends Model
{
    protected $fillable = [
        'status', 'rekrut_id', 'user_id'
    ];
}
