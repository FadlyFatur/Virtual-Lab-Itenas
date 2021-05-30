<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\jurusan;
use App\lab;
use App\User;
use App\Materi;
use App\praktikum;
use App\enroll;
use App\berita;
use App\assisten;
use Auth;

class landingController extends Controller
{
    public function landing(){
        $jurusan = jurusan::all()->take(6);
        $totalLab = lab::all()->count();
        $totalUser = User::all()->count();
        $totalMateri = Materi::all()->count();
        $berita = berita::all()->sortByDesc('created_at')->take(3);
        return view('welcome', compact('jurusan','totalLab','totalUser','totalMateri', 'berita'));
    }

    public function indexJurusan(){
        $jurusan = jurusan::where('status',1)->latest()->get();
        return view('landing.jurusan', compact('jurusan'));
    }

    public function indexlaboratorium($slug){
        $jurusan = jurusan::where('slug',$slug)->first();
        $lab = lab::where('jurusan',$jurusan->id)->where('status',1)->latest()->get();
        return view('landing.lab', compact('jurusan', 'lab'));
    }

    public function indexPengajar(){
        $data = assisten::groupBy('mahasiswa_id')->get();
        return view('landing.pengajar', compact('data'));
    }

    public function indexBerita(){
        $data = berita::all()->where('status',1);
        return view('landing.berita', compact('data'));
    }

    public function indexRekrutmen(){
        $lab = lab::all();
        
        return view('landing.rekrut', compact('lab'));
    }

    public function detailBerita($slug){
        $data = berita::where('slug', $slug)->first();
        return view( 'landing.detail-berita', compact('data') );
    }

    public function downloadFileSyarat($file){
        $file= public_path('rekrut_file').'/'.$file;
        return response()->download($file);
    }
}
