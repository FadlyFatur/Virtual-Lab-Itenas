<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lab extends Model
{
    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'thumbnail','jurusan', 'Kepala_lab'
    ];

    public function jurusan()
    {
        return $this->belongsTo('App\jurusan', 'jurusan');
    }

    public function praktikum()
    {
        return $this->hasMany('App\praktikum', 'laboratorium', 'id');
    }
}
