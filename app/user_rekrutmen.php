<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_rekrutmen extends Model
{
    protected $fillable = [
        'status', 'rekrut_id', 'user_id', 'biodata', 'transkip', 'file'
    ];

    public function getRekrut()
    {
        return $this->belongsTo('App\rekrutmen', 'rekrut_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
