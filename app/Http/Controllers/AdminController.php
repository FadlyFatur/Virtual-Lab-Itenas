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
use App\rekrutmen;
use App\user_rekrutmen as rekrut;
use App\kelas_praktikum as kelas;
use App\file_materi as fmateri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
Use Alert;
use Auth;

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
        $data = lab::orderBy('nama', 'asc')->get();
        return view('admin.rekrutmen', compact('data'));
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
        return Datatables::collection(user::where('roles_id',2)->get())->make(true);
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
        if ($request->has('thumb')){
            Validator::make($request->all(), [
                'nama_jurusan' => 'string | max:100',
                'deskripsi_jurusan' => 'string | max:1000',
                'thumb_photo' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
            ]);
            $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
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
                return '<a target="_blank" href="'.asset($data->thumbnail_path).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a title="Hapus" href="#" onclick="deleted('.$data->id.')" class="hapus btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['opsi'])
            ->make(true);
    }

    public function postLab(Request $request){
        // dd($request->all());
        if ($request->has('thumb')){
            Validator::make($request->all(), [
                'nama_lab' => 'required | string | max:100',
                'deskripsi_lab' => 'required | string | max:1000',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
                'kode' => 'required'
            ]);

            $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
            $path = Storage::putFileAs('images/thumbnail', $request->file('thumb'), $name);

            if ($request->get('klab') != null) {
                lab::create([
                    'nama' => $request->get('nama_lab'),
                    'slug' => Str::slug($request->get('nama_lab'),'-'),
                    'deskripsi' => $request->get('deskripsi_lab'),
                    'thumbnail' => $path,
                    'jurusan'=>$request->get('kode'),
                    'kepala_lab'=>$request->get('klab')
                ]);
            }else {
                lab::create([
                    'nama' => $request->get('nama_lab'),
                    'slug' => Str::slug($request->get('nama_lab'),'-'),
                    'deskripsi' => $request->get('deskripsi_lab'),
                    'thumbnail' => $path,
                    'jurusan'=>$request->get('kode'),
                ]);
            }
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }
        return redirect()
                ->back()
                ->withError("Data gagal di submit");
    }

    public function getTableLab(){
        $data = lab::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data){
                return '<a target="_blank" href="'.asset($data->thumbnail).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a target="_blank" href="'.route('praktikumAdmin', $data->slug).'" class="edit btn btn-info btn-sm"><i class="fas fa-book-open"></i>';
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
        $data = praktikum::where('laboratorium',$lab->id)->get();
        $role = Auth::user()->roles_id;
        return view('admin.praktikum', compact('lab','data','role'));
    }

    public function postPrak(Request $request, $id){
        Validator::make($request->all(), [
            'nama_praktikum' => 'required | string | max:100',
            'deskripsi' => 'string | max:1000',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        if ($request->get('kelas') != null) {
            praktikum::create([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'laboratorium' => $id,
                'kelas' => $request->get('kelas')
            ]);
        }else {
            praktikum::create([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'laboratorium' => $id,
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function getTablePrak($id){
        $data = praktikum::where('laboratorium',$id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data){
                return '<a target="_blank" href="'.route('materi', $data->id).'" class="edit btn btn-info btn-sm"><i class="fas fa-book-open"></i>';
            })
            ->addColumn('th', function ($data){
                return $data->semester.'/'.$data->tahun_ajaran;
            })
            ->rawColumns(['opsi','th'])
            ->make(true);
    }

    public function postDetailMateri(Request $request){
        if ($request->get('tipe') == '1' && $request->get('materi') != null) {
            $validator = Validator::make($request->all(), [
                'materi' => 'required | string | max:2000',
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string',
                'urutan' => 'required | integer'
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
                'urutan' =>  $request->get('urutan')
            ]);
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '2' && $request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_materi' => 'required | string',
                'pilih_materi' => 'required',
                'thumb' => 'required | image', // max 7MB
                'urutan' => 'required | integer'
            ]);
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
                'urutan' =>  $request->get('urutan')
            ]);
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '3' && $request->has('file')){
            $validator = Validator::make($request->all(), [
                'nama_materi' => 'required | string',
                'pilih_materi' => 'required',
                'file' => 'required|max:10000|mimes:doc,docx,xlsx,zip,rar,ppt,pptx,pdf',
                'urutan' => 'required | integer'
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
                'urutan' =>  $request->get('urutan')
            ]);
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '4' && $request->get('link_materi') != null){
            $validator = Validator::make($request->all(), [
                'link_materi' => 'required' ,
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string',
                'urutan' => 'required | integer'
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
                'urutan' =>  $request->get('urutan')
            ]);
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        }else{
            return redirect()
                ->back()
                ->withErrors("Data gagal di submit, lengkapi form input data");
        }
    }

    public function deleteJurusan($id){
        $delete = jurusan::where('id',$id)->delete();

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

    public function statusJurusan($id){
        $check = jurusan::find($id);
        $field['status'] = !$check->status;
        if($check){
            $check->update($field);
            $data['status']=true;
            if($field['status'] == 1){
                $data['message']="Jurusan telah diaktifkan.";
            }else {
                $data['message']="Jurusan dinonaktifkan.";
            }
        }else{
            $data['status']=false;
            $data['message']="Ops telah terjadi kesalahan pada saat mengupdate data";
        }
        return response()->json($data, 200);
    }

    public function updateJurusan(Request $request){
        
    }

    public function postRekrut(Request $request){
        // dd(date("Y-m-d", strtotime($request->get('deadline'))) );
        $validator = Validator::make($request->all(), [
            'nama_rekrutmen' => ' string | max:100',
            'deskripsi' => 'string | max:1000',
            'kuota' => 'required',
            'deadline' => 'required',
            'kode_praktikum' => 'required',
            'fileSyarat' => 'required | mimes:pdf,zip,rar | max:10000'
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };

        $name = Carbon::now()->format('YmdHs')."_".$request->file('fileSyarat')->getClientOriginalName();
        $path_file = Storage::putFileAs('public/file', $request->file('fileSyarat'), $name);

        rekrutmen::create([
            'nama' => $request->get('nama_rekrutmen'),
            'deskripsi' => $request->get('deskripsi'),
            'kuota' => $request->get('kuota'),
            'deadline' => date("Y-m-d", strtotime($request->get('deadline'))), 
            'praktikum_id'=>$request->get('kode_praktikum'),
            'file'=> $path_file
        ]);

        return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");
    }

    public function getPrak($id)
    {
        $data = praktikum::where('laboratorium',$id)
                ->where('status', 1)
                ->get();
        
            return response()->json($data);
    }

    public function getTableRek()
    {
        $data = rekrutmen::orderBy('created_at','desc')->get();
        return Datatables::of($data)
                ->editColumn('praktikum_id', function ($data){
                    return $data->getPrak->nama;
                })
                ->addIndexColumn()
                ->addColumn('opsi', function ($data){
                    return '<button title="Hapus" onclick="deleted('.$data->id.')" class="hapus btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> <button title="list" onclick="getList('.$data->id.')" class="hapus btn btn-danger btn-sm"><i class="fa fa-eye"></i></button>';
                    
                })
                ->addColumn('file', function ($data){
                    return '<a download title="download" href="#" class="btn btn-info btn-sm">Download File</a>';
                })
                ->addColumn('total', function ($data){
                    return rekrut::where('rekrut_id', $data->id)->count();
                    
                })
                ->rawColumns(['opsi','file'])
                ->make(true);
    }

    public function getDetailrekrut($id)
    {
        $rekrut = rekrutmen::where('id', $id)->orderBy('created_at')->first();
        $userRekrut = rekrut::where('user_id', Auth::id())->where('rekrut_id',$id)->exists();
        $user = Auth::user();

        $data = [
            'nama' => $rekrut->nama,
            'deskripsi' => $rekrut->deskripsi,
            'kuota' => $rekrut->kuota,
            'deadline' => $rekrut->deadline,
            'file' => $rekrut->file,
            'praktikum' => $rekrut->getPrak->nama,
            'user' => $user,
            'rekrut' => $id,
            'cek' => $userRekrut
        ];

        return response()->json($data);
    }

    public function postDetailrekrut(Request $request){
        $validator = Validator::make($request->all(), [
            'userId' => ' required',
            'biodata' => 'required|mimes:pdf|max:5000',
            'transkip' => 'required|mimes:pdf|max:5000',
            'file' => 'required | mimes:pdf,zip,rar | max:10000'
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };
        $bio = Carbon::now()->format('YmdHs')."_".$request->file('biodata')->getClientOriginalName();
        $nilai = Carbon::now()->format('YmdHs')."_".$request->file('transkip')->getClientOriginalName();
        $file = Carbon::now()->format('YmdHs')."_".$request->file('file')->getClientOriginalName();

        $path_bio = Storage::putFileAs('public/rekrut', $request->file('biodata'), $bio);
        $path_nilai = Storage::putFileAs('public/rekrut', $request->file('transkip'), $nilai);
        $path_file = Storage::putFileAs('public/rekrut', $request->file('file'), $file);
        
        rekrut::create([
            'biodata' => $path_bio,
            'transkip' => $path_nilai,
            'file' => $path_file,
            'rekrut_id'=>$request->get('rekrutId'),
            'user_id'=>$request->get('userId')
        ]);

        return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");
    }

    public function getListRekrut($id){
        $data = rekrut::where('rekrut_id',$id)->get();
        return Datatables::of($data)
                ->editColumn('nama', function ($data){
                    return $data->getUser->name;
                })
                ->editColumn('nrp', function ($data){
                    return $data->getUser->nomer_id;
                })
                ->editColumn('email', function ($data){
                    return $data->getUser->email;
                })
                ->addIndexColumn()
                ->addColumn('opsi', function ($data){
                    return '<button title="Lihat" onclick="showRekrut('.$data->id.')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>'; 
                })
                ->addColumn('status', function ($data){
                    if ($data->status == 0) {
                        return '<span class="badge badge-secondary">Pending</span>';
                    }elseif ($data->status == 1) {
                        return '<span class="badge badge-success">Diterima</span>';
                    }else{
                        return '<span class="badge badge-danger">Ditolak</span>';
                    }
                })
                ->rawColumns(['opsi','status'])
                ->make(true);
    }

    public function getUserRekrut($id)
    {
        $rekrut = rekrut::where('id',$id)->first();

        $data = [
            'id' => $rekrut->rekrut_id,
            'user_id' => $rekrut->user_id,
            'nama' => $rekrut->getUser->name,
            'nrp' => $rekrut->getUser->nomer_id,
            'email' => $rekrut->getUser->email,
            'bio' => $rekrut->biodata,
            'transkip' => $rekrut->transkip,
            'file' => $rekrut->file,
            'tanggal' => $rekrut->created_at->format('d/m/Y')
        ];
        return response()->json($data);
    }

    public function acceptRekrut($id, $userId)
    {
        $resp = rekrut::where('user_id', $userId)
                ->where('rekrut_id',$id)
                ->first()
                ->update(['status' => 1]);

        return response()->json($resp);
    }

    public function deniedRekrut($id, $userId)
    {
        $resp = rekrut::where('user_id', $userId)
                ->where('rekrut_id',$id)
                ->first()
                ->update(['status' => 2]);

        return response()->json($resp);
    }
}
