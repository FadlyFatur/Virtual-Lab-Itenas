<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rekrutmen;
use App\enroll;
use Auth;
use App\user_rekrutmen as rekrut;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        $kelas = enroll::where('user_id',Auth::id())->get();
        $rekrut = rekrut::where('user_id',Auth::id())->orderBy('created_at', 'DESC')->get();
        $kelas_baru = enroll::where('user_id',Auth::id())->latest('created_at')->first();
        return view('home', compact('kelas', 'rekrut', 'kelas_baru'));
    }
}
