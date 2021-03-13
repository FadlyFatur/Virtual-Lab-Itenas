<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'status', 'nama', 'slug', 'deskripsi', 'materi', 'img_path', 'judul_file', 'file', 'link_materi', 'praktikum_id'
    ];

    public function prak()
    {
        return $this->belongsTo('App\praktikum', 'praktikum_id');
    }

    public function getFile()
    {
        return $this->hasMany('App\file_materi', 'materi_id', 'id');
    }

}
