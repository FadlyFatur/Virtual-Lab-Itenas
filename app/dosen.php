<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\dosen_role;

class dosen extends Model
{
    protected $fillable = [
        'nama', 'nomer_id', 'status',
    ];

    protected $primaryKey = 'nomer_id';

    public function role()
    {
        return $this->hasMany('App\dosen_role', 'nomer_id', 'dosen_id');
    }

    public function getDosenKosong($role)
    {
        $data = dosen_role::where('role',$role)->get();
        return $data;
    }
}
