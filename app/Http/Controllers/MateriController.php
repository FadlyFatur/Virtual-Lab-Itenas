<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materi;
use App\enroll;
Use Alert;
use Auth;

class MateriController extends Controller
{
    public function indexMateri($id, $slug)
    {
        $data = Materi::where('praktikum_id',$id)->get();
        return view('landing.detail-materi',compact('data'));
    }

    public function daftarPrak($id, $slug)
    {
        enroll::create([
            'user_id' => Auth::user()->id,
            'praktikum_id' => $id,
        ]);
        Alert::success('Berhasil', 'Selamat anda berhasil mendaftar kelas Praktikum');
        $data = Materi::where('praktikum_id',$id)->get();
        return view('landing.detail-materi',compact('data'));
    }
}
