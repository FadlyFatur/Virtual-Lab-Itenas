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
        return view('landing.detail-materi',compact('data'));
    }

    public function getMateri($id){
        $data = file_materi::where('id',$id)->get();
        return response()->json($data);
    }
}
