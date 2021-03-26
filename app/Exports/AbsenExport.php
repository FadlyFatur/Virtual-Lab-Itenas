<?php

namespace App\Exports;

use App\absen_mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class AbsenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return absen_mahasiswa::all();
    }
}
