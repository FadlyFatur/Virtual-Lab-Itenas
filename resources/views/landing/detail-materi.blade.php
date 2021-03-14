@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-materi.css') }}" rel="stylesheet">
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
      height: 350px;
      width: 350px;
      display:block;
      margin:auto;
    }
</style>

<!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Materi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('post-materi',$prak->id)}}" method="POST">
              @csrf
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label>Nama Materi</label>
                      <input type="text" class="form-control" name="nama_materi" placeholder="Nama Materi" required autofocus> 
                    </div>
                    <div class="form-group">
                      <label>Deskripsi/Rangkuman Singkat Materi</label>
                      <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" required autofocus></textarea>
                    </div>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Tambah</button>
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
        <div class="row">
            <div class="col-md-3">
                <ul class="list-group">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Materi</button>
                    <br>
                    <li class="list-group-item">
                        <a href="#" id="absen"><i class="fa fa-check" aria-hidden="true"></i> Absen</a>
                    </li>
                    @foreach ($data as $d)
                        <li class="list-group-item">
                            <button onclick="materiClick( {{$d->id}} )" class="btn btn-light" id="{{$d->id}}"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{$d->nama}}</button>
                        </li>
                    @endforeach
                </ul><br><br>
            </div>

            <div class="col-md-8 side-line">
                <div class="d-flex justify-content-center mt-5 mb-2" id="input_area">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_materi">Input Materi</button><hr>
                </div>
                <div id="materi-area">
                    <div class="text-center">
                        <h1 class="text-center" id="judul-materi">{{$prak->nama}}</h1><br>
                        <p>{{$prak->deskripsi}}</p>
                    </div>
                    
                </div>
            </div>
        </div>
        <br>
        {{-- <div id="scrollhere"></div>
        <div class="row">
            <div>
                <h2>Absen Mahasiswa</h2><br>
                <div class="table-responsive-md">
                    <table class="table">
                        <caption>Absen 15-02-2021</caption>
                        <thead>
                            <tr>
                            <th scope="col">Materi</th>
                            <th scope="col">Absen</th>
                            <th scope="col">Tanggal Absen</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>Materi 1</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label" for="inlineRadio1">Masuk</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">Telat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">Absen</label>
                                    </div>
                                </div>
                            </td>
                            <td>-</td>
                            <td><span class="badge badge-danger">Belum Absen</span></td>
                            <td><a class="btn btn-primary" href="#">Simpan</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="modal fade" id="input_materi" tabindex="-1" role="dialog" aria-labelledby="input_materiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="input_materiTitle">Input Materi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('post-Detail-materi')}}" enctype="multipart/form-data">
                    @csrf
                    <label for="tipe">Pilih Tipe</label>
                    <select name="tipe" id="tipe" class="form-select" aria-label="type materi">
                      <option selected>Pilih jenis file</option>
                      <option value="1">Teks/Deskriptif</option>
                      <option value="2">Gambar/Image</option>
                      <option value="3">File</option>
                      <option value="4">Link/URL</option>
                    </select><br>
                    <label>Nama Materi</label>
                    <input type="text" class="form-control" name="nama_materi" placeholder="Materi" autofocus> 
                    <hr>
                    <div class="tipe-materi">
                      <div class="materi-input">
                        <div class="form-group">
                          <label>Materi</label>
                          <textarea class="form-control" rows="7" name="materi" placeholder="Masukan materi Jurusan" autofocus></textarea>
                        </div>
                      </div>
                      <div class="gambar-input">
                        <div class="form-group">
                          <label>Thumbnail</label>
                          <div class="input-group ">
                              <span class="input-group-btn">
                                  <span class="btn btn-default btn-file">
                                      Browse… <input type="file" name="thumb" id="imgInp">
                                  </span>
                              </span>
                              <input type="text" class="form-control" readonly>
                          </div>
                          <img id='img-upload'/>
                        </div>
                      </div>
                      <div class="file-input">
                        <div class="form-group">
                            <label for="file">File/berkas praktikum</label>
                            <input type="file" class="form-control-file" id="file">
                        </div>
                      </div>
                      <div class="link-input">
                        <div class="form-group">
                          <label>Link Materi (*jika ada)</label>
                          <input type="text" class="form-control" name="link_materi" placeholder="Masukan link" autofocus> 
                        </div>
                      </div>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
        </div>
      </div>
@endsection

@section('js')
    @parent
    <link href="{{ asset('js/detail-materi.js') }}">

    <script>
    $(document).ready(function () {
        $("#absen").on('click', function() {
            $('html,body').animate({
                scrollTop: $("#scrollhere").offset().top},
                'slow');
        });    
        $(".materi-input").hide();
        $(".gambar-input").hide();
        $(".file-input").hide();
        $(".link-input").hide();

        $("#tipe").on('change', function() {
            if ($(this).val() == '1'){
                $(".materi-input").show();
                $(".gambar-input").hide();
                $(".file-input").hide();
                $(".link-input").hide();
            } if ($(this).val() == '2'){
                console.log('foto');
                $(".gambar-input").show();
                $(".materi-input").hide();
                $(".file-input").hide();
                $(".link-input").hide();
            } if ($(this).val() == '3'){
                console.log('file');
                $(".file-input").show();
                $(".gambar-input").hide();
                $(".materi-input").hide();
                $(".link-input").hide();
            } if ($(this).val() == '4'){
                console.log('link');
                $(".link-input").show();
                $(".gambar-input").hide();
                $(".file-input").hide();
                $(".materi-input").hide();
            }
        });

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

    
    function materiClick(id) {
        $.ajax({
            url: '/get-materi/'+id,
            type: 'get',
            dataType: 'json',
            success: function (resp) {
                // console.log('get', resp);
                $('#materi-area').empty();
                if(resp.length == 0){
                    console.log('tidak');
                    $('#materi-area').append(up_btn);
                    alert('materi belum dimasukan');
                    return;
                }else{
                    console.log('ada');
                }

            },
            error: function (resp) {
                alert('error! materi tidak bisa dibuka')
                console.log('error');
            }
        });
    }
    </script>
@endsection