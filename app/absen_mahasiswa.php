<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absen_mahasiswa extends Model
{
    protected $fillable = [
        'status', 'tipe', 'absen_id', 'user_id'
    ];

    public function getAbsen()
    {
        return $this->belongsTo('App\Absen', 'absen_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
