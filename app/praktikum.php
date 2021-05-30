<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class praktikum extends Model
{
    protected $fillable = [
        'status', 'nama', 'slug', 'deskripsi', 'semester', 'tahun_ajaran', 'laboratorium', 'kelas', 'koor_dosen_prak', 'koor_assisten'
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

    public function getKoorAssisten()
    {
        return $this->belongsTo('App\mahasiswa', 'koor_assisten');
    }

    public function getKoorDosen()
    {
        return $this->belongsTo('App\dosen', 'koor_dosen_prak');
    }

}
