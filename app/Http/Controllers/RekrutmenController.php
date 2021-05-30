<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rekrutmen;
use App\user_rekrutmen as rekrut;
use App\lab;
use App\User;
use App\praktikum;
use DataTables;
Use Alert;
use Auth;
use Session;
use App\assisten;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class RekrutmenController extends Controller
{
        // Rekrutmen 
        public function indexRek(){
            $data = lab::orderBy('nama', 'asc')->get();
            return view('admin.rekrutmen', compact('data'));
        }
    
        public function postRekrut(Request $request){
            // dd($request->all());
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
    
        public function getTableRek(){
            $data = rekrutmen::orderBy('created_at','desc')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('praktikum_id', function ($data){
                        return $data->getPrak->nama;
                    })
                    ->addColumn('aksi', function ($data){
                        return '<a href="'.route('downloadFileSyarat',$data->file).'" class="btn btn-warning btn-sm"><i class="fas fa-download"></i></a> <a class="btn btn-primary btn-sm" href=""><i class="fas fa-edit"></i></a> <button title="list" onclick="getList('.$data->id.')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>';
                        
                    })
                    ->addColumn('total', function ($data){
                        return rekrut::where('rekrut_id', $data->id)->count();
                    })
                    ->rawColumns(['aksi','file'])
                    ->make(true);
        }
    
        public function downloadFileRekrut($file){
            $file= public_path('rekrut_file').'/'.$file;
            return response()->download($file);
        }
    
        public function getDetailrekrut($id){
            $rekrut = rekrutmen::where('id', $id)->orderBy('created_at')->first();
            $userRekrut = rekrut::where('user_id', Auth::id())->where('rekrut_id',$id)->exists();
            $user = Auth::user();
    
            if (!empty($rekrut)) {
                $data = [
                    'nama' => $rekrut->nama,
                    'deskripsi' => $rekrut->deskripsi,
                    'kuota' => $rekrut->kuota,
                    'deadline' => date_format( date_create($rekrut->deadline), 'd M Y'),
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
                        return $data->getUser->nrp;
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
    
        public function getUserRekrut($id){
            $rekrut = rekrut::where('id',$id)->first();
    
            $data = [
                'id' => $rekrut->rekrut_id,
                'user_id' => $rekrut->user_id,
                'nama' => $rekrut->getUser->name,
                'nrp' => $rekrut->getUser->nrp,
                'email' => $rekrut->getUser->email,
                'bio' => $rekrut->biodata,
                'transkip' => $rekrut->transkip,
                'file' => $rekrut->file,
                'status' => $rekrut->status,
                'tanggal' => $rekrut->created_at->format('d/m/Y')
            ];
            return response()->json($data);
        }
    
        public function acceptRekrut($id, $userId, $nrp){
            $rekrut = rekrutmen::where('id',$id)->first();
    
            assisten::create([
                    'role' => 1,
                    'mahasiswa_id' => $nrp,
                    'praktikum_id' => $rekrut->getPrak->id,
                    ]);

            rekrut::where('user_id', $userId)
                    ->where('rekrut_id',$id)
                    ->first()
                    ->update(['status' => 1]);
            
            // User::where('id', $userId)
            //         ->first()
            //         ->update(['roles_id' => 6]);
    
    
            $data = ['message' => 'Sukses di accept!'];
            return response()->json($data, 200);
        }
    
        public function deniedRekrut($id, $userId){
            $resp = rekrut::where('user_id', $userId)
                    ->where('rekrut_id',$id)
                    ->first()
                    ->update(['status' => 2]);
    
            return response()->json($resp);
        }
    
        public function getRekrut($id){
            $data = rekrutmen::where('praktikum_id',$id)
            ->where('status', 1)
            ->get();
    
            return response()->json($data);
        }

        public function statusRekrutmen($id){
            $check = rekrutmen::find($id);
            $field['status'] = !$check->status;
            if($check){
                $check->update($field);
                $data['status']=true;
                if($field['status'] == 1){
                    $data['message']="Rekrutmen telah diaktifkan.";
                }else {
                    $data['message']="Rekrutmen dinonaktifkan.";
                }
            }else{
                $data['status']=false;
                $data['message']="Ops telah terjadi kesalahan pada saat mengupdate data";
            }
            return response()->json($data, 200);
        }

        public function getPrak($id){
            $data = praktikum::where('laboratorium',$id)
                ->where('status', 1)
                ->get();
        
            return response()->json($data);
        }
}
