<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\mahasiswa;
Use Alert;
use Auth;
use Session;
use App\dosen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use App\Imports\DosenImport;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // User 
    public function indexUser(){
        return view('admin.user');
    }

    public function getUserData(){
        $data = User::orderBy('roles_id','asc')->get();
        return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('aksi', function ($data){
                            return '<button onclick="editUser('.$data->id.')" class="btn btn-primary"><i class="fas fa-edit"></i></button>';
                        })
                        ->addColumn('nomer', function ($data){
                            if ($data->nrp != null) {
                                return $data->nrp;
                            } elseif ($data->nomer_id != null){
                                return $data->nomer_id;
                            }else {
                                return '-';
                            }
                        })
                        ->editColumn('tanggal', function ($data){
                            return $data->created_at->format('d M Y');
                        })
                        ->rawColumns(['aksi'])
                        ->make(true);
    }

    public function postEditUser($id, Request $request)
    {
        // dd($id, $request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required | string | max:255',
            'email' => 'required | string | email | max:255',
            'roles_id' => 'required'
        ]);
        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        $user = user::query();
        $cekEmail = $user->where('email',$request->get('email'))->get();
        // dd($cekEmail[0]->id);
        if($cekEmail->count() == 1 ){
            if ($cekEmail[0]->id == $id) {
                $user->where('id',$id)->update([
                    'name' => $request->get('nama'),
                    'email' => $request->get('email'),
                    'roles_id' => $request->get('roles_id'),
                ]);
                return redirect()
                        ->back()
                        ->withSuccess("Data berhasil di submit");
            }
        }
        return redirect()
                ->back()
                ->withErrors("Data gagal di submit");
    }
    
    public function getUserDetail($id)
    {
        $user = User::where('id',$id)->first();
        return response()->json($user);

    }

    // Dosen 
    public function postDosen(Request $request){
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

    public function getDosen(){
        return Datatables::collection(dosen::all())
                        ->addIndexColumn()
                        ->addColumn('aksi', function ($data){
                            return '<button class="btn btn-primary" onclick="editDosen('.$data->nomer_id.')"><i class="fas fa-edit"></i></button> <button onclick="hapusDosen('.$data->nomer_id.')" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>';
                        })
                        ->rawColumns(['aksi'])
                        ->make(true);
    }

    public function indexDosen(){
        return view('admin.dosen');
    }

    public function importDosen(Request $request){
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

    public function deleteDosen($id)
    {
        $dosen = dosen::where('nomer_id', $id)->first();
        if ($dosen['status'] == 1){
            User::where('nomer_id', $id)
                ->first()
                ->update([
                    'roles_id' => 1,
                    'nomer_id' => NULL
                ]);
        }
        
        $delete = $dosen->delete();
        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Dosen berhasil dihapus";
        } else {
            $success = false;
            $message = "Dosen tidak ditemukan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function postEditDosen($id, Request $request)
    {
        // dd($request->all(), $id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required | string',
            'noPegawai' => 'required | integer',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        $user = dosen::query();
        $cekDosen = $user->where('nomer_id',$id)->get();
        if($cekDosen->count() == 1 ){
            if ($cekDosen[0]->nomer_id == $id) {
                $user->where('nomer_id',$id)->update([
                    'nomer_id' => $request->get('noPegawai'),
                    'nama' => $request->get('nama'),
                ]);
                return redirect()
                        ->back()
                        ->withSuccess("Data berhasil di submit");
            }
        }

        dosen::where('nomer_id',$id)->update([
            'nomer_id' => $request->get('noPegawai'),
            'nama' => $request->get('nama'), 
        ]);

        Alert::success('Sukses', 'Data Berhasil diinput');
        return redirect()
            ->back()
            ->withSuccess("Data berhasil di simpan");
    }

    public function getDosenDetail($id)
    {
        $user = dosen::where('nomer_id',$id)->first();
        return response()->json($user);
    }

    // Mahasiswa 
    public function indexMahasiswa(){
        return view('admin.mahasiswa');
    }

    public function getMahaDetail($id)
    {
        $user = mahasiswa::where('nrp',$id)->first();
        return response()->json($user);
    }

    public function postEditMaha($id, Request $request)
    {
        // dd($request->all(), $id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required | string',
            'nrp' => 'required | integer',
        ]);

        if ($validator->fails()) { 
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        $user = mahasiswa::query();
        $cekMaha = $user->where('nrp',$id)->get();
        if($cekMaha->count() == 1 ){
            if ($cekMaha[0]->nrp == $id) {
                $user->where('nrp',$id)->update([
                    'nrp' => $request->get('nrp'),
                    'nama' => $request->get('nama'),
                ]);
                return redirect()
                        ->back()
                        ->withSuccess("Data berhasil di submit");
            }
        }

        mahasiswa::where('nrp',$id)->update([
            'nrp' => $request->get('nrp'),
            'nama' => $request->get('nama'), 
        ]);

        Alert::success('Sukses', 'Data Berhasil diinput');
        return redirect()
            ->back()
            ->withSuccess("Data berhasil di simpan");
    }

    public function postMahasiswa(Request $request){
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

    public function getMahasiswa(){
        return Datatables::collection(mahasiswa::all())
                            ->addIndexColumn()
                            ->addColumn('aksi', function ($data){
                                return '<button class="btn btn-primary" onclick="editMahasiswa('.$data->nrp.')"><i class="fas fa-edit"></i></button> <a onclick="hapusMaha('.$data->nrp.')" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>';
                            })
                            ->rawColumns(['aksi'])
                            ->make(true);
    }

    public function impotMahasiswa(Request $request){
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

    public function hapusMahasiswa($id){
        $maha = mahasiswa::where('nrp', $id)->first();
        if ($maha['status'] == 1){
            User::where('nrp', $id)
                ->first()
                ->update([
                    'roles_id' => 1,
                    'nrp' => NULL
                ]);
        }
        
        $delete = $maha->delete();
        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "mahasiswa berhasil dihapus";
        } else {
            $success = false;
            $message = "mahasiswa tidak ditemukan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
