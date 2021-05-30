<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lab extends Model
{
    protected $fillable = [
        'status', 'nama', 'slug', 'deskripsi', 'thumbnail','jurusan', 'kepala_lab'
    ];

    public function jurusan()
    {
        return $this->belongsTo('App\jurusan', 'jurusan');
    }

    public function praktikum()
    {
        return $this->hasMany('App\praktikum', 'laboratorium', 'id');
    }

    public function klab()
    {
        return $this->belongsTo('App\dosen', 'kepala_lab');
    }
}
