<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = [
        'nama', 'tanggal_absen', 'praktikum_id', 'status'
    ];
}
