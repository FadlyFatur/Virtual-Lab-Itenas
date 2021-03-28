<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tugas extends Model
{
    protected $fillable = [
        'user_id', 'status', 'file_materi', 'file_tugas', 'nilai'
    ];

    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getDetailMateri()
    {
        return $this->belongsTo('App\file_materi', 'file_materi');
    }
}
