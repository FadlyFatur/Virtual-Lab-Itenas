<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jurusan extends Model
{
    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'thumbnail','thumbnail_path'
    ];

    public function lab()
    {
        return $this->hasMany('App\lab', 'jurusan', 'id');
    }
}
