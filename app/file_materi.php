<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file_materi extends Model
{
    protected $fillable = [
        'nama','urutan','materi', 'img', 'file', 'link', 'tugas', 'type', 'materi_id'
    ];

    public function getMateri()
    {
        return $this->belongsTo('App\Materi', 'materi_id');
    }
}
