<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materi;

class MateriController extends Controller
{
    public function indexMateri($id, $slug)
    {
        $data = Materi::where('praktikum_id',$id)->get();
        return view('landing.detail-materi',compact('data'));
    }
}
