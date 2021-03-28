<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assisten extends Model
{
    protected $fillable = [
        'status', 'role', 'foto', 'id_mahasiswa', 'praktikum_id'
    ];

    public function praktikum()
    {
        return $this->belongsTo('App\praktikum', 'praktikum_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\User', 'id_mahasiswa');
    }

}
