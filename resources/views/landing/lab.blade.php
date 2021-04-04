@extends('layouts.app')

@section('content')
<style>
    .card-img, .card-img-top {
        height: 200px;
    }
</style>
    <div class="container margin-top">
        <div class="text-center">
            <br><h1>Laboratorium</h1>
            <h2>"{{$jurusan->nama}}"</h2><br><hr>
            <div class="group-jurusan">
                @if (count($lab) > 0)
                    <div class="row">
                        @foreach ($lab as $l)
                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                <div class="card" style="width: 18rem;">
                                    <img src="" class="card-img-top" alt="{{$l->nama}}" style="background-image: url('{{asset('Logo-Itenas.jpg')}}'); object-fit: cover; background-size: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$l->nama}}</h5>
                                        <p class="card-text text-justify">{{$l->deskripsi}}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{route('praktikum-list',$l->slug)}}" class="btn btn-primary">Akses Materi  <i class="fa fa-angle-double-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <img src="{{asset('page-kosong.svg')}}" class="img-fluid mb-3" alt="halaman kosong" style="width:500px; height:500px " >
                    <h3>Belum ada Laboratorium</h3>
                @endif
            </div>
        </div>
    </div>
@endsection