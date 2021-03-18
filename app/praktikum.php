<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class praktikum extends Model
{
    protected $fillable = [
        'status', 'nama', 'slug', 'deskripsi', 'semester', 'tahun_ajaran', 'laboratorium', 'kelas', 'koor_lab', 'koor_asisten'
    ];

    public function lab()
    {
        return $this->belongsTo('App\lab', 'laboratorium');
    }

    public function materi()
    {
        return $this->hasMany('App\Materi', 'praktikum_id', 'id');
    }

    public function enroll()
    {
        return $this->hasMany('App\enroll', 'praktikum_id', 'id');
    }

    public function getKelas()
    {
        return $this->belongsTo('App\kelas_praktikum', 'kelas');
    }

    public function getRekrutmen()
    {
        return $this->hasMany('App\rekrutmen', 'praktikum_id', 'id');
    }

}
