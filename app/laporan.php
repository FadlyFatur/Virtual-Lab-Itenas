<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class laporan extends Model
{
    protected $fillable = [
        'file', 'deskripsi', 'pengirim','penerima','status', 'tipe'
    ];

    public function dosenPenerima()
    {
        return $this->belongsTo('App\dosen', 'penerima');
    }

    public function dosenPengirim()
    {
        return $this->belongsTo('App\dosen', 'pengirim');
    }
}
