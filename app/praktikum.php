<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class praktikum extends Model
{
    protected $fillable = [
        'status', 'nama', 'slug', 'deskripsi', 'Semester', 'tahun_ajaran', 'laboratorium', 'kelas'
    ];

    public function lab()
    {
        return $this->belongsTo('App\lab', 'laboratorium');
    }

    public function materi()
    {
        return $this->hasMany('App\Materi', 'praktikum_id', 'id');
    }
}
