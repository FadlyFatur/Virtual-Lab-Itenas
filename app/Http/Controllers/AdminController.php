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
use App\assisten;
use App\berita;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Str;
Use Alert;
use Auth;
use App\Imports\MahasiswaImport;
use App\Imports\DosenImport;
use Session;

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

    public function postBerita(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'judul' => 'required | string | max:100',
            'isi_berita' => 'required | string | max:20000',
            'thumb' => 'required | image',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

        $name = "b_".Carbon::now()->format('YmdHs').$request->file('thumb')->getClientOriginalName();
        $path_img = Storage::putFileAs('images/img_berita', $request->file('thumb'), $name);

        berita::create([
            'judul' => $request->get('judul'),
            'slug' => Str::slug($request->get('judul'),'-'),
            'deskripsi' => $request->get('isi_berita'),
            'img' => $path_img,
        ]);

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function getBerita()
    {
        $data = berita::orderBy('created_at','desc')->get();
        return Datatables::of($data)
                            ->addIndexColumn()
                            ->make(true);
    }

    public function indexAsisten()
    {
        $data = assisten::all();
        return view('admin.asisten', compact('data'));
    }

    public function getUserData()
    {
        $data = User::orderBy('roles_id','desc')->get();
        return Datatables::of($data)->make(true);
    }
    
    public function getMahasiswa()
    {
        return Datatables::collection(mahasiswa::all())->addIndexColumn()->make(true);
    }

    public function impotMahasiswa(Request $request)
    {
        // dd($request->all());
        // validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_import',$nama_file);
 
		// import data
		Excel::import(new MahasiswaImport, public_path('/file_import/'.$nama_file));
 
		// notifikasi dengan session
		Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect()->back();
    }

    public function indexDosen()
    {
        return view('admin.dosen');
    }

    public function impotDosen(Request $request)
    {
        $this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_import',$nama_file);
 
		// import data
		Excel::import(new DosenImport, public_path('/file_import/'.$nama_file));
 
		// notifikasi dengan session
		Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect()->back();
    }

    public function getDosen()
    {
        return Datatables::collection(dosen::all())
                        ->addIndexColumn()
                        ->make(true);
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
                return '<a target="_blank" href="'.asset($data->thumbnail).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a onclick="hapusLab('.$data->id.')" class="btn btn-warning btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a> <a target="_blank" href="'.route('praktikumAdmin', $data->slug).'" class="edit btn btn-primary btn-sm"><i class="fas fa-book-open"></i></a>';
            })
            ->addColumn('jurusan', function ($data){
                $jur = $data->jurusan()->first()->nama;
                return $jur;
            })
            ->rawColumns(['opsi', 'jurusan'])
            ->make(true);
    }

    public function deleteLab($id)
    {
        $lab = lab::where('id', $id)->first();
        Storage::delete($lab['thumbnail']);

        // Storage::disk('public')->delete($lab['thumbnail']);
        $delete = $lab->delete();

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
            'deskripsi' => 'string | max:3000',
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
        // dd($request->all());
        if ($request->get('tipe') == '1' && $request->get('materi') != null) {
            $validator = Validator::make($request->all(), [
                'materi' => 'required | string | max:10000',
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string',
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
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '2' && $request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_materi' => 'required | string',
                'pilih_materi' => 'required',
                'thumb' => 'required | image', // max 7MB
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
            ]);
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        } if ($request->get('tipe') == '3' && $request->has('file')){
            $validator = Validator::make($request->all(), [
                'nama_materi' => 'required | string',
                'pilih_materi' => 'required',
                'file' => 'required|max:10000|mimes:doc,docx,xlsx,zip,rar,ppt,pptx,pdf,xls',
            ]);

            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }
            $path = public_path('materi');
            $nameFile = Carbon::now()->format('YmdHs')."_".$request->file('file')->getClientOriginalName();
            $request->file('file')->move($path,$nameFile);
            fmateri::create([
                'nama' => $request->get('nama_materi'),
                'file' => $nameFile,
                'type' => $request->get('tipe'),
                'materi_id' => $request->get('pilih_materi'),
            ]);
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        }if ($request->get('tipe') == '4' && $request->get('link_materi') != null){
            $validator = Validator::make($request->all(), [
                'link_materi' => 'required' ,
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string',
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
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");

        }if ($request->get('tipe') == '5' && $request->get('tugas') != null){
            // dd($request->get('tugas'));
            $validator = Validator::make($request->all(), [
                'tugas' => 'required | max:2000',
                'pilih_materi' => 'required',
                'nama_materi' => 'required | string | unique:materis,nama',
            ]);
    
            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            if ( fmateri::where('type', 5)->where('materi_id',$request->get('pilih_materi'))->exists() ) {
                return redirect()
                ->back()
                ->withErrors("Setiap materi hanya bisa memiliki satu tugas!");
            }

            $data = $request->get('tugas');
            fmateri::create([
                'nama' => $request->get('nama_materi'),
                'type' => $request->get('tipe'),
                'tugas' => $data,
                'materi_id' => $request->get('pilih_materi'),
            ]);
            
            Alert::success('Sukses', 'Materi Berhasil ditambah');
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di simpan");
        }else{
            return redirect()
                ->back()
                ->withErrors("Data materi gagal di simpan, ulangi pengisian data");
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

    public function postRekrut(Request $request){
        // dd(date("Y-m-d", strtotime($request->get('deadline'))) );
        $validator = Validator::make($request->all(), [
            'nama_rekrutmen' => ' string | max:100',
            'deskripsi' => 'string | max:1000',
            'kuota' => 'required',
            'deadline' => 'required',
            'kode_praktikum' => 'required',
            'fileSyarat' => 'required | mimes:pdf,zip,rar,doc,docx | max:10000'
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        };

        // $name = Carbon::now()->format('YmdHs')."_".$request->file('fileSyarat')->getClientOriginalName();
        // $path_file = Storage::putFileAs('public/file', $request->file('fileSyarat'), $name);
        $path = public_path('rekrut_file');
        $nameFile = "r_".Carbon::now()->format('YmdHs')."_".$request->file('fileSyarat')->getClientOriginalName();
        $request->file('fileSyarat')->move($path,$nameFile);

        rekrutmen::create([
            'nama' => $request->get('nama_rekrutmen'),
            'deskripsi' => $request->get('deskripsi'),
            'kuota' => $request->get('kuota'),
            'deadline' => date("Y-m-d", strtotime($request->get('deadline'))), 
            'praktikum_id'=>$request->get('kode_praktikum'),
            'file'=> $nameFile
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
                    return '<a download title="download" href="'.route('downloadFileSyarat',$data->file).'" class="btn btn-info btn-sm">Download File</a>';
                })
                ->addColumn('total', function ($data){
                    return rekrut::where('rekrut_id', $data->id)->count();
                    
                })
                ->rawColumns(['opsi','file'])
                ->make(true);
    }

    public function downloadFileRekrut($file)
    {
        $file= public_path('rekrut_file').'/'.$file;
        return response()->download($file);
    }

    public function getDetailrekrut($id)
    {
        $rekrut = rekrutmen::where('id', $id)->orderBy('created_at')->first();
        $userRekrut = rekrut::where('user_id', Auth::id())->where('rekrut_id',$id)->exists();
        $user = Auth::user();

        if (!empty($rekrut)) {
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
        }else{
            $data = "Belum ada rekrutmen";
            return response()->json($data); // Status code here
        }
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
        
        $path = public_path('rekrut_file');
        $bio = "b_".Carbon::now()->format('YmdHs').$request->file('biodata')->getClientOriginalName();
        $nilai = "n_".Carbon::now()->format('YmdHs').$request->file('transkip')->getClientOriginalName();
        $file = "f_".Carbon::now()->format('YmdHs').$request->file('file')->getClientOriginalName();

        $request->file('biodata')->move($path,$bio);
        $request->file('transkip')->move($path,$nilai);
        $request->file('file')->move($path,$file);
        
        rekrut::create([
            'biodata' => $bio,
            'transkip' => $nilai,
            'file' => $file,
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
        $rekrut = rekrutmen::where('id',$id)->first();

        rekrut::where('user_id', $userId)
                ->where('rekrut_id',$id)
                ->first()
                ->update(['status' => 1]);
        
        User::where('id', $userId)
                ->first()
                ->update(['roles_id' => 3]);

        assisten::create([
                'role' => 1,
                'id_mahasiswa' => $userId,
                'praktikum_id' => $rekrut->getPrak->id,
                ]);

        $data = ['message' => 'Sukses!'];
        return response()->json($data, 200);
    }

    public function deniedRekrut($id, $userId)
    {
        $resp = rekrut::where('user_id', $userId)
                ->where('rekrut_id',$id)
                ->first()
                ->update(['status' => 2]);

        return response()->json($resp);
    }

    public function getRekrut($id)
    {
        $data = rekrutmen::where('praktikum_id',$id)
        ->where('status', 1)
        ->get();

        return response()->json($data);
    }

    public function postDosen(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required | string',
            'noPegawai' => 'required | integer | unique:dosens,nomer_id',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        dosen::updateOrCreate([
            'nama' => $request->get('nama'), 
            'nomer_id' => $request->get('noPegawai')
        ],
        [
            'nama' => $request->get('nama'), 
            'nomer_id' => $request->get('noPegawai')
        ]);

        Alert::success('Sukses', 'Data Berhasil diinput');
        return redirect()
            ->back()
            ->withSuccess("Data berhasil di simpan");
    }

    public function postMahasiswa(Request $request)
    {
         // dd($request->all());
         $validator = Validator::make($request->all(), [
            'nama' => 'required | string',
            'noMaha' => 'required | integer | unique:mahasiswas,nrp',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        mahasiswa::updateOrCreate([
            'nama' => $request->get('nama'), 
            'nrp' => $request->get('noMaha')
        ],
        [
            'nama' => $request->get('nama'), 
            'nrp' => $request->get('noMaha')
        ]);

        Alert::success('Sukses', 'Data Berhasil diinput');
        return redirect()
            ->back()
            ->withSuccess("Data berhasil di simpan");
    }
}
