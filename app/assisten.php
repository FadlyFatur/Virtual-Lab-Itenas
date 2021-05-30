<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assisten extends Model
{
    protected $fillable = [
        'status', 'role', 'foto', 'mahasiswa_id', 'praktikum_id', 'jurusan_id'
    ];

    public function praktikum()
    {
        return $this->belongsTo('App\praktikum', 'praktikum_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\mahasiswa', 'mahasiswa_id');
    }

}
