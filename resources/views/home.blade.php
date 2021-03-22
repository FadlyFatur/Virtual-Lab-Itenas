@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container margin-top">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="wrapper">
                <div class="left">
                    <img src="https://www.searchpng.com/wp-content/uploads/2019/02/Deafult-Profile-Pitcher.png" alt="user" width="100">
                    <h4>{{Auth::user()->name}}</h4>
                    @if (Auth::user()->roles_id == 1)
                        <p>User</p>
                    @elseif( Auth::user()->roles_id == 2)
                        <p>Mahasiswa</p>
                    @else
                        <p>Admin</p>
                    @endif
                </div>
                <div class="right">
        
                    <div class="info">
                        <h3>Informasi</h3>
                        <div class="info_data">
                            <div class="data">
                                <h4>Email</h4>
                                <p>{{Auth::user()->email}}</p>
                            </div>
                            <div class="data">
                                @if (Auth::user()->roles_id != 1)
                                    <h4>NRP</h4>
                                    <p>{{ !empty(Auth::user()->nomer_id)  ? Auth::user()->nomer_id : '-' }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="project">
                        <h3>Laboratorium</h3>
                        <div class="project_data">
                            <div class="data">
                                <h4>Recent</h4>
                                <p>Loream ipsum blalalala</p>
                            </div>
                            <div class="data">
                                <h4>Most viewed</h4>
                                <p>Loream ipsum blalalala</p>
                            </div>
                        </div>
                    </div>
        
                    {{-- <div class="socialmedia">
                        <ul>
                            <li><a herf="#"><i class="fab fa-facebook-square"></i></a></li>
                            <li><a herf="#"></a><i class="fab fa-twitter"></i></li>
                            <li><a herf="#"><i class="fab fa-instagram-square"></i></a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{-- <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div> --}}
            @if ($kelas_baru)
                <div class="row tours">
                    <div class="tourcard">
                        <figure>
                            <div class="tourpic">
                                <img width="320" height="180" src="{{asset($kelas_baru->praktikum->lab->thumbnail)}}">
                                <span class="tourcat">Praktikum terbaru</span>                             
                                <span class="tourday hot">{{$kelas_baru->praktikum->lab->nama}}</span>
                            </div>
                            <figcaption>
                            <h3 class="entry-title">
                                <a href="{{route('detail-materi',$kelas_baru->praktikum_id)}}">{{$kelas_baru->praktikum->nama}}</a></h3>
                            <span class="description">{{$kelas_baru->praktikum->deskripsi}}</span>
                            {{-- <span class="tourprice">
                                <span class="currency">Rp. </span><span class="price">1.500.000</span>
                                <span> / pax</span>
                            </span> --}}
                            </figcaption>
                            <div class="tourbtn">
                                <a href="{{route('detail-materi',$kelas_baru->praktikum_id)}}" class="btn btn-sm">
                                    <i class="fa fa-arrow-right fa-fw"></i><span>Masuk</span>
                                </a>
                            </div>
                        </figure>
                    </div>
                </div>
            @endif
        </div>
    </div>
        <section id="tabs" class="project-tab mt-5">
            @if (Auth::user()->roles_id == 2 || Auth::user()->roles_id == 1 || Auth::user()->roles_id == 0)
            <div class="row">
                <div class="col-md-12">
                    {{-- <h2>Informasi Saya</h2> --}}
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Laboratorium</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Rekrutmen</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($kelas)>0)
                                        @foreach ($kelas as $k)
                                            <tr>
                                                <td>{{$k->praktikum->nama}}</td>
                                                <td><a href="{{route('detail-materi',$k->praktikum_id)}}" class="btn btn-rose">Masuk >></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>Belum ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <table class="table" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Rekrutmen</th>
                                        <th>Laboratorium</th>
                                        <th>Praktikum</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($rekrut)>0)
                                        @foreach ($rekrut as $r)
                                            <tr>
                                                <td>{{$r->getRekrut->nama}}</td>
                                                <td>{{$r->getRekrut->getPrak->lab->nama}}</td>
                                                <td>{{$r->getRekrut->getPrak->nama}}</td>
                                                <td>{{$r->created_at->format('d, M Y')}}</td>
                                                @if ($r->status == 0)
                                                    <td><span class="badge badge-secondary">Pending</span></td>
                                                @elseif($r->status == 1)
                                                    <td><span class="badge badge-success">Diterima</span></td>
                                                @else
                                                    <td><span class="badge badge-danger">Ditolak</span></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td>Belum ada data</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>
</div>
@endsection
