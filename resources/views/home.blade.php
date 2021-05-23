@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Modal Anggaran -->
<div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pengajuan Anggaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form role="form" method="POST" action="{{route('post-laporan')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                  <div class="form-group">
                      <label>Penerima</label>
                      <select name="penerima" class="custom-select form-control" required>
                          <option>Pilih Salah satu</option>
                          @foreach ($dosen as $d)
                          <option value="{{$d->nomer_id}}">{{$d->nama}}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fileInput">Masukan File</label>
                        <input type="file" class="form-control-file" id="fileInput" name="file" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                        <label>Tipe Pengajuan</label>
                        <select name="tipe" class="custom-select form-control" required>
                            <option value="1">Anggaran</option>
                            <option value="2">Laporan</option>
                        </select>
                  </div>
                <div class="col">
                    <div class="form-group">
                        <label>Keterangan/Pesan</label>
                        <textarea class="form-control" rows="3" name="deskripsi" placeholder="Masukan Keterangan atau Pesan Singkat" autofocus></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        </div>
    </div>
</div>
</div>

<div class="container-fluid margin-top">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('errors'))
        <div class="alert alert-danger">
            {{ session('errors') }}
        </div>
    @endif
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

    @if (Auth::user()->roles_id == 3 )
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Laporan dan Anggaran</h3>
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#laporanModal">Form Pengajuan</button>
            </div><br>
            <div class="col-md-3">
                <form action="#" method="get">
                    <div class="input-group">
                        <!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
                        <input class="form-control" id="system-search" name="q" placeholder="Pencarian" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-9">
             <table class="table table-list-search">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Tipe</th>
                                <th>Penerima</th>
                                <th>Pengirim</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $l)
                            <tr>
                                @if ($l->pengirim == Auth::user()->nomer_id)
                                    <td><span class="badge badge-info">Form Dikirim</span></td>
                                @else
                                    <td><span class="badge badge-warning">Form Masuk</span></td>
                                @endif
                                @if ($l->tipe == 1)
                                    <td>Anggaran</td>
                                @else
                                    <td>Laporan</td>
                                @endif
                                <td>{{$l->dosenPenerima->nama}}</td>
                                <td>{{$l->dosenPengirim->nama}}</td>
                                <td>{{$l->created_at}}</td>
                                <td>{{$l->deskripsi}}</td>
                                @if ($l->status == 0)
                                    <td><span class="badge badge-secondary">Terkirim</span></td>
                                @else
                                    <td><span class="badge badge-success">Terbaca</span></td>
                                @endif
                                <td><a href="{{route('download-laporan', $l->file)}}" class="btn btn-primary btn-sm"><i class="fas fa-download"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td>Tidak ada data</td>
                            </tr>    
                            
                            @endforelse
                        </tbody>
                    </table>   
            </div>
        </div><br><hr>
    @endif

    <div class="row mt-1">
        <div class="col-md-12">
            @if (Count($kelas) != 0)
                <h3>Praktikum Saya</h3>
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
                <h3>Belum Ada Praktikum</h3>
            @endif
        </div>
    </div><br>

    
        
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
        var activeSystemClass = $('.list-group-item.active');

        //something is entered in search form
        $('#system-search').keyup( function() {
        var that = this;
            // affect all table rows on in systems table
            var tableBody = $('.table-list-search tbody');
            var tableRowsClass = $('.table-list-search tbody tr');
            $('.search-sf').remove();
            tableRowsClass.each( function(i, val) {
            
                //Lower text for case insensitive
                var rowText = $(val).text().toLowerCase();
                var inputText = $(that).val().toLowerCase();
                if(inputText != '')
                {
                    $('.search-query-sf').remove();
                    tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "'
                        + $(that).val()
                        + '"</strong></td></tr>');
                }
                else
                {
                    $('.search-query-sf').remove();
                }

                if( rowText.indexOf( inputText ) == -1 )
                {
                    //hide rows
                    tableRowsClass.eq(i).hide();
                    
                }
                else
                {
                    $('.search-sf').remove();
                    tableRowsClass.eq(i).show();
                }
            });
            //all tr elements are hidden
            if(tableRowsClass.children(':visible').length == 0)
            {
                tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
            }
        });
    });
    </script>
@endsection
