<?php

namespace App\Imports;

use App\dosen;
use Maatwebsite\Excel\Concerns\ToModel;

class DosenImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $exists = dosen::where('nomer_id',$row[0])->first();
        if ($exists  || $row[0] == NULL) {
            return null;    
        }
        return new dosen([
            'nomer_id' => $row[0],
            'nama' => $row[1], 
        ]);
    }
}
