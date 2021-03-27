<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tugas extends Model
{
    protected $fillable = [
        'user_id', 'status', 'materi_id', 'file_tugas'
    ];
}
