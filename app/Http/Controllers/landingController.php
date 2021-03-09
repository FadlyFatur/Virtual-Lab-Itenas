<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\jurusan;
use App\lab;
use App\praktikum;

class landingController extends Controller
{
    public function landing()
    {
        $jurusan = jurusan::all()->take(6);
        return view('welcome', compact('jurusan'));
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

    public function detailLab($id)
    {
        $lab = lab::where('id',$id)->first();
        $data = praktikum::where('laboratorium',$id)->get();

        return view('landing.praktikum', compact('lab', 'data'));
    }

    public function indexRekrutmen()
    {
        return view('landing.rekrut');
    }
}
