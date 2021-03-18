<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\jurusan;
use App\lab;
use App\User;
use App\Materi;
use App\praktikum;
use App\enroll;
use Auth;

class landingController extends Controller
{
    public function landing()
    {
        $jurusan = jurusan::all()->take(6);
        $totalLab = lab::all()->count();
        $totalUser = User::all()->count();
        $totalMateri = Materi::all()->count();
        return view('welcome', compact('jurusan','totalLab','totalUser','totalMateri'));
    }

    public function indexJurusan()
    {
        $jurusan = jurusan::latest()->get();
        return view('landing.jurusan', compact('jurusan'));
    }

    public function indexlaboratorium($slug)
    {
        $jurusan = jurusan::where('slug',$slug)->first();
        $lab = lab::where('jurusan',$jurusan->id)->get();
        return view('landing.lab', compact('jurusan', 'lab'));
    }

    public function indexPengajar()
    {
        return view('landing.pengajar');
    }

    public function indexBerita()
    {
        return view('landing.berita');
    }

    public function indexRekrutmen()
    {
        $lab = lab::all();
        
        return view('landing.rekrut', compact('lab'));
    }

    public function detailBerita()
    {
        return view('landing.detail-berita');
    }

    public function profil()
    {
        return view('landing.profile');
    }
}
