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
use Session;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    // Berita 
    public function indexBerita(){
        return view('admin.berita');
    }

    public function postBerita(Request $request){
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

    public function getBerita(){
        $data = berita::orderBy('created_at','desc')->get();
        return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('aksi', function ($data){
                                return '<a class="btn btn-primary" href=""><i class="fas fa-edit"></i></a> <button onclick="deleted('.$data->id.')" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>';
                            })
                            ->rawColumns(['aksi'])
                            ->make(true);
    }

    public function statusBerita($id){
        $check = berita::find($id);
        $field['status'] = !$check->status;
        if($check){
            $check->update($field);
            $data['status']=true;
            if($field['status'] == 1){
                $data['message']="Berita telah diaktifkan.";
            }else {
                $data['message']="Berita dinonaktifkan.";
            }
        }else{
            $data['status']=false;
            $data['message']="Ops telah terjadi kesalahan pada saat mengupdate data";
        }
        return response()->json($data, 200);
    }

    public function hapusBerita($id)
    {
        $asis = berita::where('id', $id)->first();
        Storage::delete($asis['img']);
        $delete = $asis->delete();
        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Berita berhasil dihapus";
        } else {
            $success = false;
            $message = "Berita tidak ditemukan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    // Assisten 
    public function indexAsisten(){
        $data = assisten::all();
        $jur = jurusan::all();
        $maha = user::where('nrp','!=',NULL)->where('roles_id','!=', 6)->where('roles_id','!=', 7)->get();
        return view('admin.asisten', compact('data','jur', 'maha'));
    }

    public function getListLab($id){
        $data = lab::where('jurusan',$id)
                ->where('status', 1)
                ->get();
        
        return response()->json($data);
    }

    public function postAssisten(Request $request){
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'maha' => 'required',
            'Jabatan' => 'required',
            'Prak' => 'required',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }
        
        assisten::create([
            'role' => $request->get('Jabatan'),
            'mahasiswa_id' => $request->get('maha'),
            'praktikum_id' => $request->get('Prak'),
        ]);

        User::where('id', $request->get('maha'))
                ->first()
                ->update(['roles_id' => 6]);

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");

        return redirect()
                ->back()
                ->withError("Data gagal di submit");
    }

    public function hapusAsisten($id)
    {
        $asis = assisten::where('id', $id)->first();
        
        $delete = $asis->delete();
        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Asisten berhasil dihapus";
        } else {
            $success = false;
            $message = "Asisten tidak ditemukan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    // JURUSAN 
    public function postJurusan(Request $request){   
        if ($request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_jurusan' => 'string | max:100',
                'deskripsi_jurusan' => 'string | max:1000',
                'thumb_photo' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
            ]);

            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withError("Data gagal di submit, lengkapi form input data");
            }

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

    public function getJurusan(){
        $data = jurusan::all()->sortByDesc('created_at');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data){
                return '<a target="_blank" href="'.asset($data->thumbnail_path).'" class="edit btn btn-secondary btn-sm"><i class="far fa-image"></i></a> <a target="_blank" href="'.route('lab', $data->slug).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a class="btn btn-primary btn-sm" href=""><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function indexJurusan(){
        return view('admin.jurusan');
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

    // LAB 
    public function indexLab(){
        $data = jurusan::all();
        return view('admin.laboratorium', compact('data'));
    }

    public function postLab(Request $request){
        // dd($request->all());
        if ($request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_lab' => 'required | string | max:100',
                'deskripsi_lab' => 'required | string | max:1000',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
                'kode' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withError("Data gagal di submit, lengkapi form input data");
            }

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
            ->addColumn('aksi', function ($data){
                return '<a target="_blank" href="'.asset($data->thumbnail).'" class="edit btn btn-secondary btn-sm"><i class="far fa-image"></i></a> <a target="_blank" href="'.route('praktikum-list', $data->slug).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a class="btn btn-primary btn-sm" href=""><i class="fas fa-edit"></i></a> <a onclick="hapusLab('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a> <a target="_blank" href="'.route('praktikumAdmin', $data->slug).'" class="edit btn btn-primary btn-sm"><i class="fas fa-book-open"></i></a>';
            })
            ->addColumn('jurusan', function ($data){
                $jur = $data->jurusan()->first()->nama;
                return $jur;
            })
            ->rawColumns(['aksi', 'jurusan'])
            ->make(true);
    }

    public function deleteLab($id){
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

    public function statusLab($id){
        $check = lab::find($id);
        $field['status'] = !$check->status;
        if($check){
            $check->update($field);
            $data['status']=true;
            if($field['status'] == 1){
                $data['message']="Laboratorium telah diaktifkan.";
            }else {
                $data['message']="Laboratorium dinonaktifkan.";
            }
        }else{
            $data['status']=false;
            $data['message']="Ops telah terjadi kesalahan pada saat mengupdate status";
        }
        return response()->json($data, 200);
    }

    // Praktikum 
    public function indexPrak($slug){
        $lab = lab::where('slug',$slug)->first();
        $data = praktikum::where('laboratorium',$lab->id)->get();
        $role = Auth::user()->roles_id;
        return view('admin.praktikum', compact('lab','data','role'));
    }

    public function postPrak(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_praktikum' => 'required | string | max:100',
            'deskripsi' => 'string | max:1000',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

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
            ->addColumn('aksi', function ($data){
                return '<a target="_blank" href="'.route('detail-materi',$data->id).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a class="btn btn-primary btn-sm" href=""><i class="fas fa-edit"></i></a> <a onclick="hapusPrak('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt" aria-hidden="true"></i></a> <a target="_blank" href="'.route('materi', $data->id).'" class="edit btn btn-info btn-sm"><i class="fas fa-book-open"></i></a>';
            })
            ->addColumn('materi', function ($data){
                return '';
            })
            ->addColumn('th', function ($data){
                return $data->semester.'/'.$data->tahun_ajaran;
            })
            ->editColumn('kelas', function ($data){
                return $data->getKelas->nama;
            })
            ->rawColumns(['aksi','th','materi'])
            ->make(true);
    }

    public function getPrak($id){
        $data = praktikum::where('laboratorium',$id)
                ->where('status', 1)
                ->get();
        
        return response()->json($data);
    }

    public function deletePrak($id){
        $lab = praktikum::where('id', $id)->first();

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

    public function statusPrak($id){
        $check = praktikum::find($id);
        $field['status'] = !$check->status;
        if($check){
            $check->update($field);
            $data['status']=true;
            if($field['status'] == 1){
                $data['message']="Praktikum telah diaktifkan.";
            }else {
                $data['message']="Praktikum dinonaktifkan.";
            }
        }else{
            $data['status']=false;
            $data['message']="Ops telah terjadi kesalahan pada saat mengupdate status";
        }
        return response()->json($data, 200);
    }

    // Materi 
    public function indexMateri($id){
        $lab = praktikum::where('id',$id)->first();
        return view('admin.materi', compact('id', 'lab'));
    }

    public function getMateri($id){
        $data = Materi::where('praktikum_id',$id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data){
                return '<a target="_blank" href="'.route('detail-materi',$data->praktikum_id).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i></a> <a class="btn btn-primary btn-sm" href=""><i class="fas fa-edit"></i></a> <a onclick="hapusMateri('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>';
            })
            ->rawColumns(['aksi'])
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

    public function materiPrak($id){
        $check = Materi::find($id);
        $field['status'] = !$check->status;
        if($check){
            $check->update($field);
            $data['status']=true;
            if($field['status'] == 1){
                $data['message']="Praktikum telah diaktifkan.";
            }else {
                $data['message']="Praktikum dinonaktifkan.";
            }
        }else{
            $data['status']=false;
            $data['message']="Ops telah terjadi kesalahan pada saat mengupdate status";
        }
        return response()->json($data, 200);
    }

    public function deleteMateri($id){
        $materi = Materi::where('id', $id)->first();

        $delete = $materi->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Materi berhasil dihapus";
        } else {
            $success = false;
            $message = "Materi tidak ditemukan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function materiStatus($id){
        $check = Materi::find($id);
        $field['status'] = !$check->status;
        if($check){
            $check->update($field);
            $data['status']=true;
            if($field['status'] == 1){
                $data['message']="Praktikum telah diaktifkan.";
            }else {
                $data['message']="Praktikum dinonaktifkan.";
            }
        }else{
            $data['status']=false;
            $data['message']="Ops telah terjadi kesalahan pada saat mengupdate status";
        }
        return response()->json($data, 200);
    }

    // Kelas 
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

    // Detail Materi 
    public function postDetailMateri(Request $request){
        // dd($request->all());
        if ($request->get('tipe') == '1' && $request->get('materi') != null) {
            $validator = Validator::make($request->all(), [
                'materi' => 'required | string | max:20000',
                'pilih_materi' => 'required',
                'nama_materi' => 'string',
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
            // $nameFile = Carbon::now()->format('YmdHs')."_".$request->file('file')->getClientOriginalName();
            // $request->file('file')->move($path,$nameFile);

            $nameFile = 'm_'.Carbon::now()->format('YmdHs').$request->file('file')->getClientOriginalName();
            $path_img = Storage::putFileAs('file/file_materi', $request->file('file'), $nameFile);

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
                'tugas' => 'required | max:20000',
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

}
