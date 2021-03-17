<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rekrutmen extends Model
{
    protected $fillable = [
        'status', 'kuota', 'deadline', 'deskripsi', 'nama', 'file', 'praktikum_id'
    ];
}
