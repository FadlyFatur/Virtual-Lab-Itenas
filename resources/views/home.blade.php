@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid margin-top">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="wrapper">
                <div class="left">
                    <img src="{{asset('avatar-icon-6.jpg')}}" alt="user" width="100">
                    <h4>{{Auth::user()->name}}</h4>
                    @switch(Auth::user()->roles_id)
                        @case(2)
                            <p>Mahasiswa</p>
                            @break

                        @case(3)
                            <p>Dosen</p>
                            @break
                        
                        @case(4)
                            <p>Dosen | Kepala Laboratorium</p>
                            @break
                        
                        @case(5)
                            <p>Dosen | Koordinator Praktikum</p>
                            @break

                        @case(6)
                            <p>Mahasiswa | Assisten Laboratorium</p>
                            @break

                        @case(7)
                            <p>Kaprodi</p>
                            @break

                        @default
                            <p>User</p>
                    @endswitch
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
                                    @if (Auth::user()->roles_id == 2)
                                        <h4>NRP</h4>
                                        <p>{{ !empty(Auth::user()->nrp)  ? Auth::user()->nrp : '-' }}</p>
                                    @elseif(Auth::user()->roles_id == 3)   
                                        <h4>Nomer Pegawai</h4>
                                        <p>{{ !empty(Auth::user()->nomer_id)  ? Auth::user()->nomer_id : '-' }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="project">
                        <h3>Laboratorium</h3>
                        <div class="project_data">
                            <div class="data">
                                <h5>Total</h5>
                                <p>{{Count($kelas)}}</p>
                            </div>
                            <div class="data">
                                <h5>Terbaru</h5>
                                <p>{{count($kelas) > 0 ? $kelas->first()->praktikum->nama : '-' }}</p>
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
        <div class="col-md-6">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Laboratorium</a>
                    @if (Auth::user()->roles_id != 1 )
                        <a class="nav-item nav-link" id="nav-tugas-tab" data-toggle="tab" href="#nav-tugas" role="tab" aria-controls="nav-tugas" aria-selected="false">Tugas</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Rekrutmen</a>
                    @endif
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
                @if (Auth::user()->roles_id != 1 )
                    <div class="tab-pane fade" id="nav-tugas" role="tabpanel" aria-labelledby="nav-tugas-tab">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Praktikum</th>
                                    <th>Tugas</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tugas)>0)
                                    @foreach ($tugas as $t)
                                        <tr>
                                            @if ($t->status == 1)
                                                <td><span class="badge badge-secondary">Pending</span></td>
                                            @else
                                                <td><span class="badge badge-success">Dinilai</span></td>
                                            @endif
                                            <td>{{$t->getDetailMateri->getMateri->prak->nama}}</td>
                                            <td>{{$t->getDetailMateri->nama}}</td>
                                            <td>{{$t->nilai}}</td>
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
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (Count($kelas) != 0)
                <h3 class="mt-5">Praktikum Saya</h3>
                <div class="row">
                    @foreach ($kelas as $k)
                    <div class="col-md-3 tours">
                        <div class="tourcard">
                            <figure>
                                <div class="tourpic">
                                    <img width="320" height="180" src="{{asset($k->praktikum->lab->thumbnail)}}">
                                    <span class="tourcat">Praktikum</span>                             
                                    <span class="tourday hot">{{$k->praktikum->lab->nama}}</span>
                                </div>
                                <figcaption>
                                <h3 class="entry-title">
                                    <a href="{{route('detail-materi',$k->praktikum_id)}}">{{$k->praktikum->nama}}</a></h3>
                                <span class="description">{{substr($k->praktikum->deskripsi,0,150)}}</span>
                                </figcaption>
                                <div class="tourbtn">
                                    <a href="{{route('detail-materi',$k->praktikum_id)}}" class="btn btn-sm">
                                        <i class="fa fa-arrow-right fa-fw"></i><span>Masuk</span>
                                    </a>
                                </div>
                            </figure>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <h3 class="mt-5">Belum Ada Praktikum</h3>
            @endif
        </div>
    </div>
        
</div>
@endsection
