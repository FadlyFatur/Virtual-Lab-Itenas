<?php

namespace App\Exports;

use App\absen_mahasiswa;
use App\Absen;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsenExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    public function collection()
    {
        // dd(absen_mahasiswa::where('absen_id',$this->id)->orderBy('created_at','asc')->get());
        return absen_mahasiswa::where('absen_id',$this->id)->orderBy('created_at','asc')->get();
    }

    public function map($absen): array
    {
        if ($absen->status == 1) {
            $status = 'Masuk';
        }elseif($absen->status == 2){
            $status = 'Telat';
        }else{
            $status = 'Absen';
        }

        return [
            $absen->getAbsen->nama,
            $absen->getUser->name,
            $absen->getUser->nomer_id,
            $status,
            $absen->created_at,
        ];
    }
    public function headings(): array
    {
        return [
            'Absen',
            'Nama',
            'NRP',
            'status',
            'tanggal absen',
        ];
    }
}
