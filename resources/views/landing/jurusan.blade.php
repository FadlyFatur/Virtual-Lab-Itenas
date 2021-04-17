@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/list-jurusan.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container margin-top" data-aos="fade-up">
        <div class="text-center">
            <h1>List Jurusan</h1><br><hr>
            <div class="group-jurusan">
                <div class="row gy-4">
                    @forelse ($jurusan as $j)
                        <div class="col-lg-4 col-sm-6 d-flex align-items-stretch mb-3">
                            <div class="card" style="width: 18rem;">
                                <img src="{{asset($j->thumbnail_path)}}" class="card-img-top" alt="{{$j->nama}}" style="background-image: url('{{asset('Logo-Itenas.jpg')}}'); object-fit: cover; background-size: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$j->nama}}</h5>
                                    <p class="card-text text-justify">{!!$j->deskripsi!!}</p>
                                    <a href="{{ route('lab', $j->slug) }}" class="btn btn-primary">Lihat  <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty 
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('page-kosong.svg')}}" class="img-fluid mb-3" alt="halaman kosong" style="width:500px; height:500px " >
                        </div><br>
                        <h3>Belum ada Laboratorium</h3>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

