@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/berita.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <section id="Berita" class="berita">

            <div class="container" data-aos="fade-up">
    
                <div class="text-center mx-auto">
                    <h1>Info/Pengumuman/Berita</h1>
                </div><br><hr>
    
            <div class="row">
                @foreach ($data as $d)
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" style="border: solid 0.5px black">
                            <div class="post-img">
                            <img src="{{asset($d->img)}}" class="img-fluid" alt="{{$d->judul}}" style='height: 100%; width: 100%; object-fit: cover'>
                            </div>
                            <div class="member-info mt-2">
                                <span class="post-date">{{$d->created_at->format('M d,Y - H:i')}}</span>
                                <h3 class="post-title">{{$d->judul}}</h3>
                                <a href="{{route('detailBerita',$d->slug)}}" class="btn btn-primary readmore stretched-link mt-auto"><span>Baca >></span><i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    
            </div>
    
        </section><!-- End Recent Blog Posts Section -->
    </div>
@endsection