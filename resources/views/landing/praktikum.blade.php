@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-lab.css') }}" rel="stylesheet">
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
                    <label>Nama Materi</label>
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
                    <select name="semester" class="custom-select form-control">
                      <option selected>Open this select menu</option>
                      <option value="genap">Genap</option>
                      <option value="ganjil">Ganjil</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tahun Ajaran (*2019-2020)</label>
                    <input type="text" class="form-control" name="tahun_ajaran" placeholder="Tahun Ajaran" required autofocus>
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
            <form role="form" method="POST" action="{{route('post-praktikum', $lab->id)}}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_praktikum" placeholder="Nama Praktikum" required autofocus> 
                  </div>
                  <div class="form-group">
                    <label>Deskripsi Kelas</label>
                    <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" required autofocus></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                   
                  </div>
                  <div class="form-group">
                   
                  </div>
                  <div class="form-group">
                   
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
    <div class="container margin-top nama-lab">
        <div class="text-center mx-auto">
            <h1>Laboratorium {{$lab->nama}}</h1>
        </div>
        
        <div class="container d-flex justify-content-center">
          <div class="row">
            <div class="col pr-0">
              <select class="form-select mr-2" aria-label="Default select example" style="width: 500px">
                <option selected>Pilih Semester</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
            <div class="col pl-0">
              <button class="btn btn-primary">Cek</button>
            </div>
          </div>
          <button class="btn btn-info" data-toggle="modal" data-target="#tambah" style="margin-left: 32px">Tambah Praktikum</button>
          <button class="btn btn-info" data-toggle="modal" data-target="#tambah-kelas" style="margin-left: 32px">Tambah Kelas</button>
        </div>
        <br><hr>
    
        <div class="row">
          @foreach ($data as $d)
            <div class="col-md-6 mb-4">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <div class="jadwal-materi text-center">
                            <h2 style="color:#230b50;">Jadwal</h2>
                            <hr>
                            <h3>kelas</h3>
                            <h5>Jam</h5><br>
                            <p>Koor Lab</p><hr>
                            <p>Semester {{$d->Semester}} <br> {{$d->tahun_ajaran}}</p>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h4 class="card-title" style="color:#230b50;">{{$d->nama}}</h4>
                          <p class="card-text">{{substr($d->deskripsi, 0, 300)}}</p>
                          <p class="card-text"><small class="text-muted">Tanggal Dibuat : {{$d->created_at->format('d F Y')}}</small></p>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                          @if ($enroll->where('praktikum_id', $d->id)->count() > 0)
                            <a href="{{route('detail-materi',$d->id)}}"><button class="btn btn-info" style="color: #fff;">Masuk</button></a>
                          @else
                            <a href="{{route('daftar-prak',$d->id)}}"><button class="btn btn-success">Daftar</button></a>
                          @endif
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          @endforeach
        </div>

    </div>
@endsection

@section('js')
    @parent
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
      });
    </script> 
@endsection