<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rekrutmen;
use App\enroll;
use App\tugas;
use App\dosen;
use App\laporan;
use App\assisten;
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
        $enroll = enroll::query();
        $kelas = $enroll->where('user_id',Auth::id())->get();
        $kelasTerbaru = $enroll->where('user_id',Auth::id())->latest('created_at')->get();

        $assistenKelas = assisten::where('mahasiswa_id',Auth::user()->nrp)->get();

        $rekrut = rekrut::where('user_id',Auth::id())->orderBy('created_at', 'DESC')->get();
        
        $tugas = tugas::where('user_id',Auth::id())->latest('updated_at')->get();
        
        $dosen = dosen::where('nomer_id','!=',Auth::user()->nomer_id)->get();

        $lap = laporan::query();
        $kirim = $lap->where('pengirim',Auth::user()->nomer_id)->get();
        $masuk = $lap->where('penerima',Auth::user()->nomer_id)->get();
        $laporan = $kirim->merge($masuk);

        $role = Auth::user()->roles_id;
        $roleUser = NULL;
        if ($role = 2 && assisten::where('mahasiswa_id',Auth::user()->nrp)->exists()) {
            $roleUser = true; 
            // dd($assisten);
        }

        // dd($laporan->merge($laporanMasuk));
        return view('home', compact('kelas', 'rekrut', 'kelasTerbaru', 'tugas', 'dosen', 'laporan','roleUser','assistenKelas'));
    }

    public function postAnggaran(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'penerima' => 'required',
            'deskripsi' => 'required | string | max:1000',
            'file' => 'mimes:doc,pdf,docx,zip,xlsx | max:10000'
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };
        
        $path = public_path('file');
        $file = "la".Carbon::now()->format('YmdHs').$request->file('file')->getClientOriginalName();
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
