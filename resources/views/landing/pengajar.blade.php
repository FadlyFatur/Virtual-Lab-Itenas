@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/pengajar.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <!-- ======= Team Section ======= -->
        <section id="pengajar" class="pengajar">

            <div class="container">
    
                <div class="text-center mx-auto">
                    <h1>Pengajar dan Asisten Laboratorium</h1>
                </div><br><hr>
    
                @if (count($data)>0)
                    <div class="row gy-4 text-center">
                        @foreach ($data as $d)
                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                <div class="member">
                                    <div class="member-img">
                                        <img src="" class="img-fluid" alt="">
                                    </div>
                                    <div class="member-info mt-2">
                                    <h4>{{$d->getUser->name}}</h4>
                                    @if ($d->getUser->roles == 3 || $d->getUser->roles == 0)
                                        <span>Assisten Laboratorium</span>
                                        <p><b>{{$d->praktikum->nama}}</b></p>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center">
                        <img src="{{asset('page-kosong.svg')}}" class="img-fluid mb-3" alt="halaman kosong" style="width:500px; height:500px " >
                        <h3>Belum ada Data Pengajar</h3>
                    </div>
                @endif

    
    
            </div>
  
        </section><!-- End Team Section -->
    </div>
@endsection