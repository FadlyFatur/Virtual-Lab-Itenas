<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materi;
use App\enroll;
use App\lab;
use App\praktikum;
use App\file_materi;
Use Alert;
use Auth;
use Carbon\Carbon;

class MateriController extends Controller
{
    public function listPraktikum($slug)
    {
        $lab = lab::where('slug',$slug)->first();

        $data = praktikum::where('laboratorium',$lab->id)->get();
        $enroll = enroll::where('user_id', Auth::user()->id)->get();
        return view('landing.praktikum', compact('lab', 'data', 'enroll'));
    }

    public function indexMateri($id)
    {
        $prak = praktikum::where('id',$id)->first();
        $data = Materi::where('praktikum_id',$id)->get();
        return view('landing.detail-materi',compact('data','prak'));
    }

    public function daftarPrak($id)
    {
        enroll::create([
            'user_id' => Auth::user()->id,
            'praktikum_id' => $id,
        ]);
        Alert::success('Berhasil', 'Selamat anda berhasil mendaftar kelas Praktikum');
        $data = Materi::where('praktikum_id',$id)->get();
        $prak = praktikum::where('id',$id)->first();
        return view('landing.detail-materi',compact('data','prak'));
    }

    public function getMateri($id){
        $fdata = file_materi::where('materi_id',$id)->get();
        
        $fmateri = Materi::where('id',$id)->first();
        if (!$fdata->isEmpty()) {
            foreach ($fdata as $d) {
                if ($d->img != null) {
                    $img = asset($d->img);
                }else {
                    $img = NULL;
                }
    
                if ($d->file != NULL) {
                    $file = asset($d->file);
                }else {
                    $file = NULL;
                }
            
                $data[] = [
                    'materi' => $d->materi,
                    'file' => asset($d->file),
                    'img' => $img,
                    'file' => $file,
                    'link' => $d->link,
                    'tipe' => $d->type,
                    'tanggal' => Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('Y/m/d')
                ];
            }
        }else {
            $data = NULL;
        }

        $materi = [
            'nama' => $fmateri->nama,
            'deskripsi' => $fmateri->deskripsi,
            'tanggal' => Carbon::createFromFormat('Y-m-d H:i:s', $fmateri->created_at)->format('Y/m/d')
        ];

        $resp = [
            'file_materi' => $data,
            'materi' => $materi
        ];
        return response()->json($resp);
    }

    
}
