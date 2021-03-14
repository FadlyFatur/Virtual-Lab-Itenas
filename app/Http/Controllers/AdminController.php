<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\mahasiswa;
use App\dosen;
use App\jurusan;
use App\lab;
use App\Materi;
use App\praktikum;
use App\kelas_praktikum as kelas;
use App\file_materi as fmateri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function indexMateri($id)
    {
        $lab = praktikum::where('id',$id)->first();
        return view('admin.materi', compact('id', 'lab'));
    }

    public function indexJurusan()
    {
        return view('admin.jurusan');
    }

    public function indexLab()
    {
        $data = jurusan::all();
        return view('admin.laboratorium', compact('data'));
    }

    public function indexRek()
    {
        return view('admin.rekrutmen');
    }

    public function indexUser()
    {
        return view('admin.user');
    }

    public function indexMahasiswa()
    {
        return view('admin.mahasiswa');
    }

    public function indexBerita()
    {
        return view('admin.berita');
    }

    public function indexAsisten()
    {
        return view('admin.asisten');
    }

    public function getUserData()
    {
        return Datatables::collection(User::all())->make(true);
    }
    
    public function getMahasiswa()
    {
        return Datatables::collection(mahasiswa::all())->make(true);
    }

    public function indexDosen()
    {
        return view('admin.dosen');
    }

    public function getDosen()
    {
        return Datatables::collection(dosen::all())->make(true);
    }

    public function postJurusan(Request $request)
    {   
        // dd($request->all());
        if ($request->has('thumb')){
            Validator::make($request->all(), [
                'nama_jurusan' => 'string | max:100',
                'deskripsi_jurusan' => 'string | max:1000',
                'thumb_photo' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
            ]);
            $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
            // dd($name);
            $path = Storage::putFileAs('images/thumbnail', $request->file('thumb'), $name);
            jurusan::create([
                'nama' => $request->get('nama_jurusan'),
                'slug' => Str::slug($request->get('nama_jurusan'),'-'),
                'deskripsi' => $request->get('deskripsi_jurusan'),
                'thumbnail' => $name,
                'thumbnail_path' => $path,
            ]);

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }
        return redirect()
                ->back()
                ->withError("Data gagal di submit");
    }

    public function getJurusan()
    {
        $data = jurusan::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data){
                return '<a target="_blank" href="'.asset($data->thumbnail_path).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['opsi'])
            ->make(true);
    }

    public function postLab(Request $request)
    {
        if ($request->has('thumb')){
            Validator::make($request->all(), [
                'nama_lab' => 'required | string | max:100',
                'deskripsi_lab' => 'required | string | max:1000',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
                'kode' => 'required'
            ]);

            $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
            $path = Storage::putFileAs('images/thumbnail', $request->file('thumb'), $name);
            lab::create([
                'nama' => $request->get('nama_lab'),
                'slug' => Str::slug($request->get('nama_lab'),'-'),
                'deskripsi' => $request->get('deskripsi_lab'),
                'thumbnail' => $path,
                'jurusan'=>$request->get('kode'),
            ]);
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }
        return redirect()
                ->back()
                ->withError("Data gagal di submit");
    }

    public function getLab()
    {
        $data = lab::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data){
                return '<a target="_blank" href="'.asset($data->thumbnail).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a target="_blank" href="'.route('praktikum', $data->slug).'" class="edit btn btn-info btn-sm"><i class="fas fa-book-open"></i>';
            })
            ->addColumn('jurusan', function ($data){
                $jur = $data->jurusan()->first()->nama;
                return $jur;
            })
            ->rawColumns(['opsi', 'jurusan'])
            ->make(true);
    }

    public function getMateri($id){
        $data = Materi::where('praktikum_id',$id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data){
                return '<a target="_blank" href="#" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['opsi'])
            ->make(true);
    }

    public function postMateri(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_materi' => 'required | string | max:100',
            'deskripsi' => 'string | max:1000',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

        materi::create([
            'nama' => $request->get('nama_materi'),
            'slug' => Str::slug($request->get('nama_materi'),'-'),
            'deskripsi' => $request->get('deskripsi'),
            'praktikum_id' => $id
        ]);

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function postDataMateri(Request $request){
        dd($request->all());
    }

    public function postKelas(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required | string | max:100',
            'wm' => 'required',
            'ws' => 'required',
            'hari' => 'required | string', // max 7MB
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

        kelas::create([
            'nama' => $request->get('nama_kelas'),
            'hari' => $request->get('hari'),
            'deskripsi' => $request->get('deskripsi'),
            'jadwal_mulai' => $request->get('wm'),
            'jadwal_akhir' => $request->get('ws'),
        ]);

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function indexPrak($slug){
        $lab = lab::where('slug',$slug)->first();
        return view('admin.praktikum', compact('lab'));
    }

    public function postPrak(Request $request, $id){
        // dd($request->all(), $id);
        Validator::make($request->all(), [
            'nama_praktikum' => 'required | string | max:100',
            'deskripsi' => 'string | max:1000',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        if ($request->get('kelas') != null) {
            // dd('ada kelas');
            praktikum::create([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'Semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'laboratorium' => $id,
                'kelas' => $request->get('kelas')
            ]);
        }else {
            // dd('tidak ada kelas');
            praktikum::create([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'Semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'laboratorium' => $id,
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function getPrak($id){
        $data = praktikum::where('laboratorium',$id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data){
                return '<a target="_blank" href="#" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a>  <a target="_blank" href="'.route('materi', $data->id).'" class="edit btn btn-info btn-sm"><i class="fas fa-book-open"></i>';
            })
            ->rawColumns(['opsi'])
            ->make(true);
    }

    public function postDetailMateri(Request $request)
    {
        // dd($request->all());
        if ($request->get('tipe') == '1' && $request->get('materi') != null) {
            // dd('masuk tipe 1');
            $validator = Validator::make($request->all(), [
                'materi' => 'required | string | max:2000',
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string'
            ]);
    
            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            fmateri::create([
                'nama' => $request->get('nama_materi'),
                'materi' => $request->get('materi'),
                'type' => $request->get('tipe'),
                'materi_id' => $request->get('pilih_materi'),
            ]);
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '2' && $request->has('thumb')){
            // dd('masuk ke tipe 2');
            $validator = Validator::make($request->all(), [
                'nama_materi' => 'required | string',
                'pilih_materi' => 'required',
                'thumb' => 'required | image', // max 7MB
            ]);
            // dd($validator);
            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            $name = Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
            $path_img = Storage::putFileAs('images/img_materi', $request->file('thumb'), $name);

            fmateri::create([
                'nama' => $request->get('nama_materi'),
                'img' => $path_img,
                'type' => $request->get('tipe'),
                'materi_id' => $request->get('pilih_materi'),
            ]);

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '3' && $request->has('file')){
            // dd('masuk ke tipe 3');
            $validator = Validator::make($request->all(), [
                'nama_materi' => 'required | string',
                'pilih_materi' => 'required',
                'file' => 'required|max:10000|mimes:doc,docx,xlsx,zip,rar,ppt,pptx,pdf'
            ]);

            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            $name = Carbon::now()->format('YmdHs')."_".$request->file('file')->getClientOriginalName();
            $path_file = Storage::putFileAs('public/file_materi', $request->file('file'), $name);

            fmateri::create([
                'nama' => $request->get('nama_materi'),
                'file' => $path_file,
                'type' => $request->get('tipe'),
                'materi_id' => $request->get('pilih_materi'),
            ]);

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");


        } if ($request->get('tipe') == '4' && $request->get('link_materi') != null){
            // dd('masuk ke tipe 4');
            $validator = Validator::make($request->all(), [
                'link_materi' => 'required' ,
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string'
            ]);
    
            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            fmateri::create([
                'nama' => $request->get('nama_materi'),
                'link' => $request->get('link_materi'),
                'type' => $request->get('tipe'),
                'materi_id' => $request->get('pilih_materi'),
            ]);
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        }else{
            return redirect()
                ->back()
                ->withErrors("Data gagal di submit, lengkapi form input data");
        }
    }
}
