@extends('layouts.app')

@section('content')
    <div class="container margin-top">
        <div class="text-center">
            <br><h1>Laboratorium</h1>
            <h2>"{{$jurusan->nama}}"</h2><br><hr>
            <div class="group-jurusan">
                <div class="row">
                    @foreach ($lab as $l)
                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                            <div class="card" style="width: 18rem;">
                                <img src="{{asset($l->thumbnail)}}" class="card-img-top" alt="{{$l->nama}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$l->nama}}</h5>
                                    {{-- <p class="card-text text-left">{{$l->deskripsi}}</p> --}}
                                </div>
                                <div class="card-footer">
                                    <a href="{{route('praktikum-list',$l->slug)}}" class="btn btn-primary">Akses Materi  <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection