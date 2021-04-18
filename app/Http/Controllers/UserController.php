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
                            return '<a class="btn btn-primary" href=""><i class="fas fa-edit"></i></a>';
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
                            return '<a class="btn btn-primary" href=""><i class="fas fa-edit"></i></a> <a onclick="hapusDosen('.$data->nomer_id.')" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>';
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

    // Mahasiswa 
    public function indexMahasiswa(){
        return view('admin.mahasiswa');
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
                                return '<a class="btn btn-primary" href=""><i class="fas fa-edit"></i></a> <a onclick="hapusMaha('.$data->nrp.')" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>';
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

    public function hapusMahasiswa($id)
    {
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
