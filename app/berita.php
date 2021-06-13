<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class berita extends Model
{
    protected $fillable = [
        'status', 'judul', 'slug', 'deskripsi','img', 'penulis'
    ];
}
