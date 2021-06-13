@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-lab.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

@endsection

@section('content')
<style>
  .btn-file {
    position: relative;
    overflow: hidden;
  }
  .btn-file input[type=file] {
      position: absolute;
      top: 0;
      right: 0;
      min-width: 100%;
      min-height: 100%;
      font-size: 100px;
      text-align: right;
      filter: alpha(opacity=0);
      opacity: 0;
      outline: none;
      background: white;
      cursor: inherit;
      display: block;
  }

  #img-upload{
    height: 100px;
    width: 100px;
  }
</style>
  @if ($role == 0 || $dosenRole->where('role',1)->contains('lab_id', $lab->id))
    <!-- Modal -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahlLabel">Tambah Praktikum</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form" method="POST" action="{{route('post-praktikum', $lab->id)}}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nama Praktikum</label>
                    <input type="text" class="form-control" name="nama_praktikum" placeholder="Nama Praktikum" required autofocus> 
                  </div>
                  <div class="form-group">
                    <label>Deskripsi/Rangkuman Singkat</label>
                    <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" required autofocus></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Kelas</label>
                    @php
                      $kelas = App\kelas_praktikum::all();
                    @endphp
                    <select name="kelas" class="custom-select form-control">
                      <option value= "" selected>Pilih salah satu</option>
                      @foreach ($kelas as $d)
                        <option value= "{{$d->id}}">{{$d->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" class="custom-select form-control" required>
                      <option selected>Pilih salah satu</option>
                      <option value="Genap">Genap</option>
                      <option value="Ganjil">Ganjil</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="custom-select form-control" required>
                      <option selected>Pilih salah satu</option>
                      <option value="2020-2021">2020-2021</option>
                      <option value="2021-2022">2021-2022</option>
                      <option value="2022-2023">2022-2023</option>
                      <option value="2022-2023">2023-2024</option>
                      <option value="2022-2023">2024-2025</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    {{-- modal Tambah Kelas --}}
    <div class="modal fade" id="tambah-kelas" tabindex="-1" role="dialog" aria-labelledby="tambah-kelasLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambah-kelaslLabel">Tambah Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form" method="POST" action="{{route('post-kelas')}}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_kelas" placeholder="Nama/Kode Kelas" required autofocus> 
                  </div>
                  <div class="form-group">
                    <label>Deskripsi Kelas</label>
                    <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" autofocus></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Waktu Mulai</label>
                    <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="wm" required/>
                      <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Waktu Selesai</label>
                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="ws" required/>
                      <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Hari</label>
                    <select name="hari" class="custom-select form-control" required>
                      <option value= "" selected>Pilih salah satu</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  @endif

    <div class="container margin-top nama-lab">
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
        <div class="text-center mx-auto">
            <h1>Laboratorium {{$lab->nama}}</h1>
        </div>
        
        <div class="container d-flex justify-content-center">
          <div class="row">
            <div class="col pr-0">
              <form action="{{route('praktikum-list',$lab->slug)}}" method="get">
                <select class="form-select mr-2" name="filter" aria-label="Default select example" style="width: 500px">
                  <option value = '0' >Semua</option>
                  @foreach ($filter as $f => $item)
                    <option value="{{$item->tahun_ajaran}}">{{$item->tahun_ajaran}}</option>  
                  @endforeach
                </select>
              </div>
              <div class="col pl-0">
                <button class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
          @if (Auth::check())
              @if ($role == 0 || $dosenRole->where('role',1)->contains('lab_id', $lab->id))
                <button class="btn btn-info" data-toggle="modal" data-target="#tambah" style="margin-left: 32px">Tambah Praktikum</button>
                <button class="btn btn-info" data-toggle="modal" data-target="#tambah-kelas" style="margin-left: 32px">Tambah Kelas</button>
              @endif
          @endif
        </div>
        <br><hr>
        @if (count($data)>0)
          <div class="row">
            @foreach ($data as $d)
              <div class="col-md-6 mb-4">
                  <div class="card mb-3" style="max-width: 540px;">
                      <div class="row g-0">
                        <div class="col-md-4">
                          <div class="jadwal-materi text-center">
                              <h2 style="color:#230b50;">Jadwal</h2>
                              <hr>
                              <h5>{{ ($d->kelas)? $d->getKelas->nama : '-' }}</h5>
                              @if ($d->kelas)
                                <p>{{Carbon\Carbon::parse($d->getKelas->jadwal_mulai)->format('H:i')}} - {{Carbon\Carbon::parse($d->getKelas->jadwal_akhir)->format('H:i')}}</p><br>
                              @else
                                <p>-</p>
                              @endif
                              @if ($d->koor_dosen_prak)
                                <p>{{$d->getKoorDosen->nama}}</p><hr>
                              @endif
                              <p>Semester {{$d->semester}} <br> {{$d->tahun_ajaran}}</p>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="card-body">
                            <h4 class="card-title" style="color:#230b50;">{{$d->nama}}</h4>
                            <p class="card-text">{{substr($d->deskripsi, 0, 300)}}</p>
                            <p class="card-text"><small class="text-muted">Tanggal Dibuat : {{$d->created_at->format('d F Y')}}</small></p>
                          </div>
                          <div class="card-footer d-flex justify-content-center">
                            @if ($enroll->where('praktikum_id', $d->id)->count() > 0 || $assisten->where('praktikum_id', $d->id)->count() > 0 || $dosenRole->where('role',1)->contains('lab_id', $lab->id) || $dosenRole->where('role',2)->contains('praktikum_id', $d->id) || $role == 0)
                              <a href="{{route('detail-materi',$d->id)}}"><button class="btn btn-info" style="color: #fff;">Masuk</button></a>
                            @else
                              @if (Auth::user()->roles_id != 3)
                                <a href="{{route('daftar-prak',$d->id)}}"><button class="btn btn-success">Daftar</button></a>
                              @else
                                <p>Hubungi Admin untuk akses dosen</p>
                              @endif
                            @endif
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center">
            <img src="{{asset('page-kosong.svg')}}" class="img-fluid mb-3" alt="halaman kosong" style="width:500px; height:500px " >
            <h3>Belum ada Praktikum</h3>
          </div>
        @endif

    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
      $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
          var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
          
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        }); 
        
        $('#datetimepicker3').datetimepicker({
          format: 'H:mm',
        });
        $('#datetimepicker4').datetimepicker({
          format: 'H:mm'
        });
      });
    </script> 
@endsection