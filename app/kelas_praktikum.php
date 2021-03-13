<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kelas_praktikum extends Model
{
    protected $fillable = [
        'nama', 'deskripsi', 'hari', 'jadwal_mulai', 'jadwal_akhir'
    ];
}
