<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jurusan extends Model
{
    protected $fillable = [
        'status', 'nama', 'slug', 'deskripsi', 'thumbnail','thumbnail_path', 'ketua_jurusan'
    ];

    public function lab()
    {
        return $this->hasMany('App\lab', 'jurusan', 'id');
    }
}
