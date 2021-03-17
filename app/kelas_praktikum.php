<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kelas_praktikum extends Model
{
    protected $fillable = [
        'nama', 'hari', 'jadwal_mulai', 'jadwal_akhir', 'status'
    ];

    public function praktikum()
    {
        return $this->hasMany('App\praktikum', 'kelas', 'id');
    }
}
