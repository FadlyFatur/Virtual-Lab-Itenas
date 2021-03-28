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
use DataTables;

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
        $assisten = assisten::where('id_mahasiswa', Auth::user()->id)->get();
        return view('landing.praktikum', compact('lab', 'data', 'enroll', 'role', 'filter', 'assisten'));
    }

    public function indexMateri($id)
    {
        
        $role = Auth::user()->roles_id;
        $prak = praktikum::where('id',$id)->first();
        // dd($prak->id);
        $data = Materi::where('praktikum_id',$id)->get();
        $assisten = assisten::where('id_mahasiswa', Auth::user()->id)->get();
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
            $assisten = assisten::where('id_mahasiswa', Auth::user()->id)->get();
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
    
                $tugas = $fdata->where('type', 5)->first();
                // var_dump($tugas);
                if($tugas){
                    $tugas_data = $tugas->id;
                }else {
                    $tugas_data = null;
                }
            
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
                    'filemateri_id' => $tugas_data
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
        $file= public_path('materi').'/'.$file;
        return response()->download($file);
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

        $path = public_path('file_tugas');
        $nameFile = "t_".Carbon::now()->format('YmdHs').$request->file('tugas')->getClientOriginalName();
        $request->file('tugas')->move($path,$nameFile);
        tugas::create([
            'file_tugas' => $nameFile,
            'user_id' => $request->get('user_id'),
            'file_materi' => $request->get('materi_id'),
        ]);
        Alert::success('Sukses', 'Materi Berhasil ditambah');
        return redirect()
            ->back()
            ->withSuccess("Data berhasil di simpan");
    }

    public function indexTugas($id)
    {
        if(Materi::where('praktikum_id',$id)->exists()){
            $materi = Materi::where('praktikum_id',$id)->get();
            foreach ($materi as $m) {
                $tugas = file_materi::where('materi_id',$m->id)->where('type', 5)->first();
                $data [] = [
                    'id' => $tugas->id,
                    'nama' => $tugas->nama
                ];
            }
        }else{
            $data = [];
        }

        // dd($data);
        return view('landing.tugas', compact('data'));
    }

    public function getTugas($id)
    {
        $tugas = tugas::where('file_materi',$id);
        return Datatables::of($tugas)
                        ->editColumn('user_id', function ($tugas) {
                            return $tugas->getUser->name;
                        })
                        ->editColumn('status', function ($tugas) {
                            if ($tugas->status == 1) {
                                return '<p><span class="badge badge-warning">Pending</span></p>';
                            }else{
                                return '<p><span class="badge badge-success">Dinilai</span></p>';
                            }
                        })
                        ->editColumn('nilai', function ($tugas){
                            if ($tugas->nilai == null) {
                                return '<input type="number" name="nilai" id="nilai'.$tugas->id.'" onfocusout="updateNilai('.$tugas->id.')">';
                            }else {
                                return $tugas->nilai;
                            }
                        })
                        ->editColumn('file_tugas', function ($tugas){
                            return '<a href="'.route('downloadTugas',$tugas->file_tugas).'" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Download Tugas</a>';
                        })
                        ->rawColumns(['status', 'nilai', 'file_tugas'])
                        ->make(true);
    }

    public function downloadTugas($file)
    {
        $file= public_path('file_tugas').'/'.$file;
        return response()->download($file);
    }
    
    public function updateNilai($id, Request $request)
    {
        tugas::where('id',$id)->update([
            "nilai" => $request->get('nilai'),
            "status" => 2
        ]);
        $msg = "Berhasil diupdate";
        return response()->json(array('msg'=> $msg), 200);
    }
}
