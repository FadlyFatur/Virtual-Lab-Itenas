<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dosen_role extends Model
{
    protected $fillable = [
        'status', 'dosen_id', 'role', 'foto', 'praktikum_id','jurusan_id', 'lab_id'
    ];

    public function dosen()
    {
        return $this->belongsTo('App\dosen', 'dosen_id');
    }

    public function lab()
    {
        return $this->belongsTo('App\lab', 'lab_id');
    }

    public function praktikum()
    {
        return $this->belongsTo('App\praktikum', 'praktikum_id');
    }
}
