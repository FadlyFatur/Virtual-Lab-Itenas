<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materi;
use App\enroll;
use App\lab;
use App\praktikum;
use App\file_materi;
use App\assisten;
use App\Absen;
use App\absen_mahasiswa;
use App\tugas;
Use Alert;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Exports\AbsenExport;
use Maatwebsite\Excel\Facades\Excel;

class MateriController extends Controller
{
    public function listPraktikum(Request $request, $slug)
    {
        // dd($request->all());
        $lab = lab::where('slug',$slug)->first();
        $role = Auth::user()->roles_id;
        $filter = praktikum::select('tahun_ajaran')
                            ->where('laboratorium',$lab->id)
                            ->groupBy('tahun_ajaran')
                            ->get();
        if($request->has('filter') && $request->get('filter') != '0'){
            $data = praktikum::where('laboratorium',$lab->id)
                            ->where('tahun_ajaran',$request->get('filter'))        
                            ->get();
        }else {
            $data = praktikum::where('laboratorium',$lab->id)->get();
        }
        // dd($filter);
        $enroll = enroll::where('user_id', Auth::user()->id)->get();
        $assisten = assisten::where('user_id', Auth::user()->id)->get();
        return view('landing.praktikum', compact('lab', 'data', 'enroll', 'role', 'filter', 'assisten'));
    }

    public function indexMateri($id)
    {
        
        $role = Auth::user()->roles_id;
        $prak = praktikum::where('id',$id)->first();
        // dd($prak->id);
        $data = Materi::where('praktikum_id',$id)->get();
        $assisten = assisten::where('user_id', Auth::user()->id)->get();
        $Cekabsen = Absen::where('praktikum_id',$id)->get();
        $absen = absen_mahasiswa::where('user_id',Auth::id())->orderBy('absen_id','asc')->get();
        if (count($absen) > 0) {
            foreach ($absen as $a ) {
                $dataAbsen_mhs []= $a->absen_id;
            }
        }else{
            $dataAbsen_mhs = [];
        }
        return view('landing.detail-materi',compact('data','prak', 'role','assisten', 'id','Cekabsen','absen','dataAbsen_mhs'));
    }

    public function daftarPrak($id)
    {
        if (enroll::where('user_id',Auth::user()->id)->where('praktikum_id',$id)->count() == 0){
            enroll::create([
                'user_id' => Auth::user()->id,
                'praktikum_id' => $id,
            ]);
            Alert::success('Berhasil', 'Selamat anda berhasil mendaftar kelas Praktikum');
            $data = Materi::where('praktikum_id',$id)->get();
            $prak = praktikum::where('id',$id)->first();
            $role = Auth::user()->roles_id;
            $assisten = assisten::where('user_id', Auth::user()->id)->get();
            $Cekabsen = Absen::where('praktikum_id',$id)->get();
            $absen = absen_mahasiswa::where('user_id',Auth::id())->orderBy('absen_id','asc')->get();
            if (count($absen) > 0) {
                foreach ($absen as $a ) {
                    $dataAbsen_mhs []= $a->absen_id;
                }
            }else{
                $dataAbsen_mhs = [];
            }
            return view('landing.detail-materi',compact('data','prak', 'role','assisten', 'id','Cekabsen','absen','dataAbsen_mhs'));
        }
        return redirect()->back();
    }

    public function getMateri($id){
        $fdata = file_materi::where('materi_id',$id)->orderBy('type','ASC')->get();
        
        $fmateri = Materi::where('id',$id)->first();
        if (!$fdata->isEmpty()) {
            foreach ($fdata as $d) {
                if ($d->img != null) {
                    $img = asset($d->img);
                }else {
                    $img = NULL;
                }
    
                // if ($d->file != NULL) {
                //     $file = Storage::disk('local')->get($d->file);
                //     // $file = $d->file;
                // }else {
                //     $file = NULL;
                // }
            
                $data[] = [
                    'nama' => $d->nama,
                    'materi' => $d->materi,
                    'img' => $img,
                    'file' => $d->file,
                    'link' => $d->link,
                    'tugas' => $d->tugas,
                    'tipe' => $d->type,
                    'tanggal' => Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('Y/m/d'),
                    'role' => Auth::user()->roles_id,
                    'user_id' => Auth::id(),
                    'materi_id' => $id
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

    public function deleteMateri($id)
    {
        $delete = Materi::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Materi berhasil dihapus";
        } else {
            $success = true;
            $message = "Materi tidak ditemukan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function addAbsen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_absen' => ' string | max:100 | required | unique:absens,nama',
            'tgl_absen' => 'required',
            'prak_id' => 'required',
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };
        // dd($request->get('tgl_absen'));
        $createdAt = Carbon::parse($request->get('tgl_absen'));
        $createdAt->format('Y-m-d H:i:s');
        // dd($createdAt);
        Absen::create([
            'nama' => $request->get('nama_absen'),
            'tanggal_absen' => $createdAt,
            'praktikum_id' => $request->get('prak_id'),
            'status' => 1
        ]);
        return redirect()
                ->back()
                ->withSuccess("Data Absen berhasil di simpan");

    }

    public function absen(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'absen' => 'required',
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };

        absen_mahasiswa::create([
            'status' => $request->get('absen'),
            'absen_id' => $request->get('absen_id'),
            'user_id' => Auth::id()
        ]);
        return redirect()
                ->back()
                ->withSuccess("Data Absen berhasil di simpan");
    }

    public function downloadFile($file)
    {
        if(Storage::disk('materi')->exists($file)){
            return Storage::disk('materi')->download($file);;
        }else{
            abort(404);
        }
    }

    public function ExportAbsen(Request $request)
    {
        // dd($request->get('absen_id'));
        return Excel::download(new AbsenExport($request->get('absen_id')), 'Absen.xlsx');
    }

    public function inputTugas(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'materi_id' => 'required',
            'tugas' => 'required|max:10000|mimes:doc,docx,xlsx,zip,rar,ppt,pptx,pdf,xls',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        $path = public_path('files');
        $nameFile = "t_".Carbon::now()->format('YmdHs').$request->file('tugas')->getClientOriginalName();
        $request->file('tugas')->move($path,$nameFile);
        tugas::create([
            'file_tugas' => $nameFile,
            'user_id' => $request->get('user_id'),
            'materi_id' => $request->get('materi_id'),
        ]);
        Alert::success('Sukses', 'Materi Berhasil ditambah');
        return redirect()
            ->back()
            ->withSuccess("Data berhasil di simpan");
    }
    
}
