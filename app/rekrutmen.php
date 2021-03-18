<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rekrutmen extends Model
{
    protected $fillable = [
        'status', 'kuota', 'deadline', 'deskripsi', 'nama', 'file', 'praktikum_id'
    ];

    public function getPrak()
    {
        return $this->belongsTo('App\praktikum', 'praktikum_id');
    }
}
