<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materi;
use App\enroll;
use App\lab;
use App\praktikum;
use App\file_materi;
use App\assisten;
Use Alert;
use Auth;
use Carbon\Carbon;

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
        $data = Materi::where('praktikum_id',$id)->get();
        $assisten = assisten::where('user_id', Auth::user()->id)->get();
        return view('landing.detail-materi',compact('data','prak', 'role','assisten', 'id'));
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
            return view('landing.detail-materi',compact('data','prak', 'role','assisten', 'id'));
        }
        return redirect()->back();
    }

    public function getMateri($id){
        $fdata = file_materi::where('materi_id',$id)->orderBy('urutan','ASC')->get();
        
        $fmateri = Materi::where('id',$id)->first();
        if (!$fdata->isEmpty()) {
            foreach ($fdata as $d) {
                if ($d->img != null) {
                    $img = asset($d->img);
                }else {
                    $img = NULL;
                }
    
                if ($d->file != NULL) {
                    $file = asset($d->file);
                }else {
                    $file = NULL;
                }
            
                $data[] = [
                    'nama' => $d->nama,
                    'materi' => $d->materi,
                    'file' => asset($d->file),
                    'img' => $img,
                    'file' => $file,
                    'link' => $d->link,
                    'tipe' => $d->type,
                    'tanggal' => Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('Y/m/d')
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
    
}
