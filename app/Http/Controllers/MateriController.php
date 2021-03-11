<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materi;
use App\enroll;
use App\lab;
use App\praktikum;
Use Alert;
use Auth;

class MateriController extends Controller
{
    public function listPraktikum($slug)
    {
        $lab = lab::where('slug',$slug)->first();
        // dd($slug);

        $data = praktikum::where('laboratorium',$lab->id)->get();
        $enroll = enroll::where('user_id', Auth::user()->id)->get();
        return view('landing.praktikum', compact('lab', 'data', 'enroll'));
    }

    public function indexMateri($id)
    {
        $data = Materi::where('praktikum_id',$id)->get();
        return view('landing.detail-materi',compact('data'));
    }

    public function daftarPrak($id)
    {
        enroll::create([
            'user_id' => Auth::user()->id,
            'praktikum_id' => $id,
        ]);
        Alert::success('Berhasil', 'Selamat anda berhasil mendaftar kelas Praktikum');
        $data = Materi::where('praktikum_id',$id)->get();
        return view('landing.detail-materi',compact('data'));
    }

    public function getMateri($id){
        $data = materi::where('id',$id)->first();
        $materi = [];
        $materi =[
            'nama' => $data->nama,
            'deskripsi' => $data->deskripsi,
            'materi' => $data->materi,
            'thumb' => asset($data->img_path),
            'file' => asset($data->file),
            'link' => $data->link_materi,
            'judul_file' => $data->judul_file
        ];
        return response()->json($materi);
    }
}
