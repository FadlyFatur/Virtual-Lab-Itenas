<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enroll extends Model
{
    protected $fillable = [
        'status', 'user_id', 'praktikum_id'
    ];

    public function praktikum()
    {
        return $this->belongsTo('App\praktikum', 'praktikum_id');
    }
}
