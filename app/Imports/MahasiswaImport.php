<?php

namespace App\Imports;

use App\mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        // dd($row);
        $exists = mahasiswa::where('nrp',$row[0])->first();
        if ($exists || $row[0] == NULL) {
            return null;    
        }else{
            return new mahasiswa([
                'nrp' => $row[0],
                'nama' => $row[1], 
            ]);
        }
    }
}
