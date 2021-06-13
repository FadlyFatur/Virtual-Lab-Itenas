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
use App\enroll;
use App\rekrutmen;
use App\user_rekrutmen as rekrut;
use App\kelas_praktikum as kelas;
use App\file_materi as fmateri;
use App\assisten;
use App\berita;
use App\dosen_role;
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
        $jur = jurusan::count(); 
        $lab = lab::count(); 
        $prak = praktikum::count(); 
        $dosen = dosen::count(); 
        $mahasiswa = mahasiswa::count(); 
        $enroll = enroll::count(); 
        return view('admin.home', compact('jur', 'lab', 'prak', 'dosen', 'mahasiswa', 'enroll'));
    }

    // Berita 
    public function indexBerita(){
        return view('admin.berita');
    }

    public function postBerita(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'judul' => 'required | string | max:200',
            'isi_berita' => 'required | string | max:20000',
            'thumb' => 'image',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }
        // dd($request->all());
        if ($request->has('thumb')) {
            $name = "b_".Carbon::now()->format('YmdHs').$request->file('thumb')->getClientOriginalName();
            $path_img = Storage::putFileAs('images/img_berita', $request->file('thumb'), $name);
    
            berita::create([
                'judul' => $request->get('judul'),
                'slug' => Str::slug($request->get('judul'),'-'),
                'deskripsi' => $request->get('isi_berita'),
                'img' => $path_img,
                'penulis' => Auth::id(),
            ]);
        }else{
            berita::create([
                'judul' => $request->get('judul'),
                'slug' => Str::slug($request->get('judul'),'-'),
                'deskripsi' => $request->get('isi_berita'),
                'penulis' => Auth::id(),
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function getBerita(){
        $data = berita::orderBy('created_at','desc')->get();
        return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('aksi', function ($data){
                                return '<a class="btn btn-primary" href="'.route('edit-berita',$data->id).'"><i class="fas fa-edit"></i> Edit</a> <button onclick="deleted('.$data->id.')" class="btn btn-danger"><i class="far fa-trash-alt"></i> Hapus</button>';
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

    public function hapusBerita($id){
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

    public function indexEditberita($id){
        $berita = berita::where('id', $id)->first();
        return view('admin.edit-berita', compact('berita'));
    }

    public function postEditberita($id, Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'judul' => 'required | string | max:100',
            'isi_berita' => 'required | string | max:20000',
            'thumb' => 'image',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

        berita::where('id',$id)->update([
            'judul' => $request->get('judul'),
            'slug' => Str::slug($request->get('judul'),'-'),
            'deskripsi' => $request->get('isi_berita'),
        ]);

        if ($request->has('thumb')) {
            $file = berita::where('id', $id)->first();
            Storage::delete($file['img']);

            $name = "b_".Carbon::now()->format('YmdHs').$request->file('thumb')->getClientOriginalName();
            $path_img = Storage::putFileAs('images/img_berita', $request->file('thumb'), $name);

            berita::where('id',$id)->update([
                'img' => $path_img
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    // Assisten 
    public function indexAsisten(){
        $data = assisten::all();
        $jur = jurusan::all();
        $maha = mahasiswa::all();
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

        if ($request->get('Jabatan') == 2) {
            praktikum::where('id',$request->get('Prak'))->update([
                'koor_assisten' => $request->get('maha')
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    public function hapusAsisten($id){
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

    public function indexEditAssisten($id){
        $maha = assisten::where('id',$id)->get();

        $data = [];
        foreach ($maha as $m) {
            $data = [
                'id' => $m->id,
                'maha' => $m->getUser->nama,
                'maha_id' => $m->mahasiswa_id,
                'prak' => $m->praktikum->nama,
                'prak_id' => $m->praktikum_id,
                'lab' => $m->praktikum->lab->nama,
                'lab_id' => $m->praktikum->lab->id,
                // 'jurusan' => $m->praktikum->lab->jurusan()->nama,
                'role' => $m->role,
                'status' => $m->status,
                'foto' => $m->foto,
            ];
        }

        $prak = praktikum::where('laboratorium', $data['lab_id'])->get();

        return view('admin.edit-assisten', compact('data','prak') );
    }

    public function postEditAssisten($id, Request $request){
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'Jabatan' => 'required',
            'Prak' => 'required',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }
        
        assisten::where('id', $id)->update([
            'role' => $request->get('Jabatan'),
            'praktikum_id' => $request->get('Prak'),
        ]);

        if ($request->get('Jabatan') == 2) {
            praktikum::where('id',$request->get('Prak'))->update([
                'koor_assisten' => $request->get('maha_id')
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
    }

    // JURUSAN 
    public function postJurusan(Request $request){   
        if ($request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_jurusan' => 'string | max:100',
                'deskripsi_jurusan' => 'string | max:2000',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
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
                return '<a target="_blank" href="'.route('lab', $data->slug).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a> <a href="'.route('edit-jurusan', $data->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> <button onclick="hapusJurusan('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Hapus</button>';
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
        try {
            jurusan::destroy($id);
            $success = true;
            $message = "Jurusan berhasil dihapus";
            

        } catch (\Exception $e) {
            $success = false;
            $message = "Jurusan Gagal dihapus, masih memiliki data yang berhubungan";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function indexEditJurusan($id){
        $jur = jurusan::where('id', $id)->first();
        return view('admin.edit-jurusan', compact('jur'));
    }

    public function postEditJurusan($id, Request $request){
        // dd($id, $request->all());
        if ($request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_jurusan' => 'string | max:100',
                'deskripsi_jurusan' => 'string | max:2000',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
            ]);

            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
            $path = Storage::putFileAs('images/thumbnail', $request->file('thumb'), $name);
            jurusan::where('id',$id)->update([
                'nama' => $request->get('nama_jurusan'),
                'slug' => Str::slug($request->get('nama_jurusan'),'-'),
                'deskripsi' => $request->get('deskripsi_jurusan'),
                'thumbnail' => $name,
                'thumbnail_path' => $path,
            ]);

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }else{
            $validator = Validator::make($request->all(), [
                'nama_jurusan' => 'string | max:100',
                'deskripsi_jurusan' => 'string | max:2000',
            ]);

            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            jurusan::where('id',$id)->update([
                'nama' => $request->get('nama_jurusan'),
                'slug' => Str::slug($request->get('nama_jurusan'),'-'),
                'deskripsi' => $request->get('deskripsi_jurusan'),
            ]);
            dd("cek");
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }

        return redirect()
                ->back()
                ->withErrors("Data gagal di submit");
    }

    // LAB 
    public function indexLab(){
        $data = jurusan::all();
        $dosen = dosen::all();
        return view('admin.laboratorium', compact('data', 'dosen'));
    }

    public function postLab(Request $request){
        // dd($request->all(), $request->get('klab') == null);

        $validator = Validator::make($request->all(), [
            'nama_lab' => 'required | string | max:100',
            'deskripsi_lab' => 'required | string | max:1000',
            'thumb' => 'required|mimes:jpg,png,jpeg|max:7000', // max 7MB
            'kode' => 'required',
            'klab' => 'required'
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
        $path = Storage::putFileAs('images/thumbnail', $request->file('thumb'), $name);
        $lab = lab::create([
            'nama' => $request->get('nama_lab'),
            'slug' => Str::slug($request->get('nama_lab'),'-'),
            'deskripsi' => $request->get('deskripsi_lab'),
            'thumbnail' => $path,
            'jurusan'=>$request->get('kode'),
            'kepala_lab'=>$request->get('klab')
        ]);
        
        dosen_role::create([
            'role' => 1,
            'dosen_id' => $request->get('klab'),
            'jurusan_id' => $request->get('kode'),
            'lab_id' => $lab->id
        ]);

        return redirect()
            ->back()
            ->withSuccess("Data berhasil di submit");
        
    }

    public function indexEditLab($id){
        $lab = lab::where('id',$id)->first();
        $data = jurusan::all();
        $dosen = dosen::all();
        return view('admin.edit-lab', compact('data','lab', 'dosen'));
    }

    public function postEditLab($id, Request $request){
        // dd($id, $request->all());
        if ($request->has('thumb')){
            $validator = Validator::make($request->all(), [
                'nama_lab' => 'required | string | max:100',
                'deskripsi_lab' => 'required | string | max:1000',
                'thumb' => 'required|mimes:jpg,png,jpeg| max:7000', // max 7MB
                'kode' => 'required'
            ]);

            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            $name = "".Carbon::now()->format('YmdHs')."_".$request->file('thumb')->getClientOriginalName();
            $path = Storage::putFileAs('images/thumbnail', $request->file('thumb'), $name);

            if ($request->get('klab') != null) {
                lab::where('id',$id)->update([
                    'nama' => $request->get('nama_lab'),
                    'slug' => Str::slug($request->get('nama_lab'),'-'),
                    'deskripsi' => $request->get('deskripsi_lab'),
                    'thumbnail' => $path,
                    'jurusan'=>$request->get('kode'),
                    'kepala_lab'=>$request->get('klab')
                ]);

                dosen_role::where('lab_id',$id)->update([
                    'dosen_id' => $request->get('klab'),
                ]);

            }else {
                lab::where('id',$id)->update([
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
        }else {
            $validator = Validator::make($request->all(), [
                'nama_lab' => 'required | string | max:100',
                'deskripsi_lab' => 'required | string | max:1000',
                'kode' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()
                ->back()
                ->withErrors($validator);
            }

            if ($request->get('klab') != null) {
                lab::where('id',$id)->update([
                    'nama' => $request->get('nama_lab'),
                    'slug' => Str::slug($request->get('nama_lab'),'-'),
                    'deskripsi' => $request->get('deskripsi_lab'),
                    'jurusan'=>$request->get('kode'),
                    'kepala_lab'=>$request->get('klab')
                ]);

                dosen_role::where('lab_id',$id)->update([
                    'dosen_id' => $request->get('klab'),
                ]);

            }else {
                lab::where('id',$id)->update([
                    'nama' => $request->get('nama_lab'),
                    'slug' => Str::slug($request->get('nama_lab'),'-'),
                    'deskripsi' => $request->get('deskripsi_lab'),
                    'jurusan'=>$request->get('kode'),
                ]);
            }
            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }
        return redirect()
                ->back()
                ->withErrors("Data gagal di submit");
    }

    public function getTableLab(){
        $data = lab::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data){
                return '<a target="_blank" href="'.route('praktikum-list', $data->slug).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a> <a class="btn btn-primary btn-sm" href="'.route('edit-lab', $data->id).'"><i class="fas fa-edit"></i> Edit</a> <button onclick="hapusLab('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Hapus</button> <a target="_blank" href="'.route('praktikumAdmin', $data->slug).'" class="edit btn btn-primary btn-sm"><i class="fas fa-book-open"></i> Prak</a>';
            })
            ->addColumn('jurusan', function ($data){
                $jur = $data->jurusan()->first()->nama;
                return $jur;
            })
            ->addColumn('klab', function ($data){
                $klab = $data->klab()->first()->nama;
                return $klab;
            })
            ->rawColumns(['aksi', 'jurusan', 'klab'])
            ->make(true);
    }

    public function deleteLab($id){
        try {
            $lab = lab::where('id', $id)->first();
            Storage::delete($lab['thumbnail']);

            lab::destroy($id);
            $success = true;
            $message = "Laboratorium berhasil dihapus";

        } catch (\Exception $e) {
            $success = false;
            $message = "Laboratorium Gagal dihapus, masih memiliki data yang berhubungan";
        }

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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_praktikum' => 'required | string | max:100',
            'deskripsi' => 'string | max:1000',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'koor_dosen' => 'required'
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

        if ($request->get('kelas') != null) {
            $data = praktikum::create([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'laboratorium' => $id,
                'kelas' => $request->get('kelas'),
                'koor_dosen_prak' => $request->get('koor_dosen'),
            ]);
            
            if ($request->get('koor_dosen') != NULL) {
                dosen_role::create([
                    'role' => 2,
                    'dosen_id' => $request->get('koor_dosen'),
                    'lab_id' => $id,
                    'praktikum_id' => $data->id
                ]);
            }

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");

        }else {
            $data = praktikum::create([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'laboratorium' => $id,
                'koor_dosen_prak' => $request->get('koor_dosen'),
            ]);

            if ($request->get('koor_dosen') != NULL) {
                dosen_role::create([
                    'role' => 2,
                    'dosen_id' => $request->get('koor_dosen'),
                    'lab_id' => $id,
                    'praktikum_id' => $data->id
                ]);
            }

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }

        return redirect()
                ->back()
                ->withErrors("Data gagal di submit");

    }

    public function getTablePrak($id){
        $data = praktikum::where('laboratorium',$id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data){
                return '<a class="btn btn-primary btn-sm" href="'.route('edit-prak', $data->id).'"><i class="fas fa-edit"></i> Edit</a> <button onclick="hapusPrak('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Hapus</button> <a target="_blank" href="'.route('materi', $data->id).'" class="edit btn btn-info btn-sm"><i class="fas fa-book-open"></i>Materi</a>';
            })
            ->addColumn('th', function ($data){
                return $data->semester.'/'.$data->tahun_ajaran;
            })
            ->editColumn('kelas', function ($data){
                return $data->getKelas->nama;
            })
            ->addColumn('koor_assisten', function ($data){
                if ($data->koor_assisten) {
                    $koor = $data->getKoorAssisten->nama;
                    return $koor;
                }else{
                    return $koor = '-';
                }
            })
            ->addColumn('koor_dosen', function ($data){
                if ($data->koor_dosen_prak) {
                    $koor = $data->getKoorDosen->nama;
                    return $koor;
                }else{
                    return $koor = '-';
                }
            })
            ->rawColumns(['aksi','th', 'koor_assisten', 'koor_dosen'])
            ->make(true);
    }

    public function getPrak($id){
        $data = praktikum::where('laboratorium',$id)
                ->where('status', 1)
                ->get();
        
        return response()->json($data);
    }

    public function deletePrak($id){
        try {
            praktikum::destroy($id);
            $success = true;
            $message = "Praktikum berhasil dihapus";

        } catch (\Exception $e) {
            $success = false;
            $message = "Praktikum Gagal dihapus, masih memiliki data yang berhubungan";
        }

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

    public function indexEditPrak($id){
        $prak = praktikum::where('id',$id)->first();
        $kelas = kelas::all();
        $dosen = dosen::all();
        $assisten = mahasiswa::all();    
        return view('admin.edit-praktikum', compact('prak','kelas','dosen','assisten'));
    }

    public function postEditPrak($id, Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_praktikum' => 'required | string | max:100',
            'deskripsi' => 'string | max:1000',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'kelas' => 'required'
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withError("Data gagal di submit, lengkapi form input data");
        }

        if ($request->get('kelas') != null) {
            $data = praktikum::where('id',$id)->update([
                'nama' => $request->get('nama_praktikum'),
                'slug' => Str::slug($request->get('nama_praktikum'),'-'),
                'deskripsi' => $request->get('deskripsi'),
                'semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
                'kelas' => $request->get('kelas')
            ]);

            
            if ($request->get('koor_dosen') != NULL) {

                dosen_role::updateOrCreate(
                    [
                        'dosen_id' => $request->get('koor_dosen'),
                        'praktikum_id' => $id
                    ],
                    [
                        'role' => 2,
                        'dosen_id' => $request->get('koor_dosen'),
                        'praktikum_id' => $id
                    ]
                );

                praktikum::where('id',$id)->update([
                    'koor_dosen_prak' => $request->get('koor_dosen'),
                ]);
            }

            if ($request->get('koor_asis') != NULL) {
                assisten::updateOrCreate(
                    [
                        'mahasiswa_id' => $request->get('koor_asis'),
                        'praktikum_id' => $id
                    ],
                    [
                        'role' => 2,
                        'mahasiswa_id' => $request->get('koor_asis'),
                        'praktikum_id' => $id
                    ]
                );

                praktikum::where('id',$id)->update([
                    'koor_assisten' => $request->get('koor_asis'),
                ]);
            }

            return redirect()
                ->back()
                ->withSuccess("Data berhasil di submit");
        }

        return redirect()
                ->back()
                ->withErrors("Data gagal di submit");
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
                return '<a target="_blank" href="'.route('detail-materi',$data->praktikum_id).'" class="edit btn btn-info btn-sm"><i class="fas fa-eye"></i>  Lihat</a> <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button> <button onclick="hapusMateri('.$data->id.')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Hapus</a>';
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
        try {
            Materi::destroy($id);
            $success = true;
            $message = "MAteri berhasil dihapus";

        } catch (\Exception $e) {
            $success = false;
            $message = "MAteri Gagal dihapus, masih memiliki data yang berhubungan";
        }

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
