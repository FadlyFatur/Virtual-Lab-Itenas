<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rekrutmen;
use App\enroll;
use App\tugas;
use App\dosen;
use App\laporan;
use Auth;
use App\user_rekrutmen as rekrut;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        $kelas = enroll::where('user_id',Auth::id())->latest('created_at')->get();
        $tugas = tugas::where('user_id',Auth::id())->latest('updated_at')->get();
        $dosen = dosen::where('status',1)->get();
        $kirim = laporan::where('pengirim',Auth::user()->nomer_id)->get();
        $masuk = laporan::where('penerima',Auth::user()->nomer_id)->get();
        $laporan = $kirim->merge($masuk);
        // dd($laporan->merge($laporanMasuk));
        return view('home', compact('kelas', 'rekrut', 'kelas', 'tugas', 'dosen', 'laporan'));
    }

    public function postAnggaran(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required | string | max:1000',
            'file' => 'mimes:doc,docx,xlsx,pdf | max:10000'
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };
        
        $path = public_path('file');
        $file = "la_".Carbon::now()->format('YmdHs').$request->file('file')->getClientOriginalName();
        $request->file('file')->move($path,$file);
        
        laporan::create([
            'file' => $file,
            'pengirim' => Auth::user()->nomer_id,
            'penerima' => $request->get('penerima'),
            'tipe'=>$request->get('tipe'),
            'deskripsi'=>$request->get('deskripsi')
        ]);

        return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");
    }

    public function downloadLaporan($file){
        laporan::where('file', $file)
                ->first()
                ->update(['status' => 1]);

        $file= public_path('file').'/'.$file;
        return response()->download($file);
    }
}
