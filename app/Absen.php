<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = [
        'nama', 'tanggal_absen', 'praktikum_id', 'status'
    ];

    public function getList()
    {
        return $this->hasMany('App\absen_mahasiswa', 'absen_id', 'id');
    }
}
