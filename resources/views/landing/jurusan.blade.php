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
                    @foreach ($jurusan as $j)
                        <div class="col-lg-4 col-sm-6 d-flex align-items-stretch mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <img src="{{asset($j->thumbnail_path)}}" class="card-img-top" alt="{{$j->nama}}" style="background-image: url('{{asset('Logo-Itenas.jpg')}}'); object-fit: cover; background-size: cover;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$j->nama}}</h5>
                                    {{-- <p class="card-text text-left">{!!substr($j->deskripsi, 0, 300)!!} ...</p> --}}
                                    <p class="card-text text-left">{!!$j->deskripsi!!}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('lab', $j->slug) }}" class="btn btn-primary">Lihat  <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

