@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-materi.css') }}" rel="stylesheet">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
      
@endsection

@section('content')
<!-- Modal materi -->
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
                      <input type="text" class="form-control" name="nama_materi" placeholder="Nama Materi (*Pengenalan, Teori)" required> 
                    </div>
                    <div class="form-group">
                      <label>Deskripsi/Rangkuman Singkat Materi</label>
                      <textarea class="form-control" id="materi" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" required></textarea>
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

  <!-- Modal absen-->
  <div class="modal fade" id="absen" tabindex="-1" role="dialog" aria-labelledby="absenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="absenLabel">Absen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4>Praktikum : {{$prak->nama}}</h4>
          <h5>Absen Tanggal : {{Carbon\Carbon::now()->toFormattedDateString()}}</h5>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal absen-->
  <div class="modal fade" id="TambahAbsen" tabindex="-1" role="dialog" aria-labelledby="TambahAbsenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TambahAbsenLabel">Absen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
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
            {{ implode('', $errors->all(':message, ')) }}
          </div>
      @endif
        <div class="row">
            <div class="col-md-3">
                <ul class="list-group">
                    @if ($role != 1 &&  $role != 2)
                      <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Materi</button>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#TambahAbsen"><i class="fa fa-plus"></i> Tambah Absen</button>
                    @endif
                    <br>
                    @if ($role != 1)
                      <li class="list-group-item">
                          <a href="#" id="absen" data-toggle="modal" data-target="#absen"><i class="fa fa-list" aria-hidden="true"></i> Absen</a>
                      </li>
                    @endif
                    @foreach ($data as $d)
                        <li class="list-group-item">
                          <div id="materi-list" class="pull-left">
                            <button onclick="materiClick( {{$d->id}} )" class="btn btn-light" id="{{$d->id}}"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{$d->nama}}</button>
                          </div>
                            @if ( $role != 1 &&  $role != 2)
                              <div id="edit-materi" class="pull-right">
                                <a onclick="hapusMateri( {{$d->id}} )" class="btn btn-danger">
                                  <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                              </div>
                            @endif
                        </li>
                    @endforeach
                </ul><br><br>
            </div>

            <div class="col-md-8 side-line">
                @if ($role != 1 &&  $role != 2)
                  <div class="pull-left" id="input_area">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_materi">Input Materi</button>
                  </div><br><hr>
                @endif
                <div id="materi-area">
                    <div class="text-center">
                        <h1 class="text-center" id="judul-materi">{{$prak->nama}}</h1><br>
                        <p>{{$prak->deskripsi}}</p>
                        <button class="btn btn-secondary">Silahkan Pilih Materi</button>
                    </div>
                    
                </div>
            </div>
        </div>
        <br>

    </div>

    {{-- modal materi  --}}
    <div class="modal fade" id="input_materi" tabindex="-1" role="dialog" aria-labelledby="input_materiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <label for="pilih_materi">Pilih Materi</label>
                    <select name="pilih_materi" id="pilih_materi" class="form-select" aria-label="type materi">
                      <option value="" selected>Pilih Materi</option>
                      @foreach ($data as $d)
                        <option value="{{$d->id}}">{{$d->nama}}</option>
                      @endforeach
                    </select><br>
                    <div class="form-group">
                      <label for="nama_materi">Nama Materi</label>
                      <input type="text" class="form-control" name="nama_materi" placeholder="Nama Materi (*Tipe Data, Function)" autofocus> 
                    </div>
                    <div class="form-group">
                      <label for="urutan">Urutan Materi</label>
                      <input type="number" class="form-control" name="urutan" placeholder="Urutan Materi (*1, 2, 3)" autofocus> 
                    </div>
                    <hr>
                    <div class="tipe-materi">
                      <div class="materi-input">
                        <div class="form-group">
                          <label>Materi</label>
                          <textarea class="form-control" id="materi-praktikum" rows="7" name="materi" placeholder="Masukan materi"></textarea>
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
                            <input type="file" class="form-control-file" name="file" id="file">
                        </div>
                      </div>
                      <div class="link-input">
                        <div class="form-group">
                          <label>Link Materi (*bentuk URL/Link)</label>
                          <input type="text" class="form-control" name="link_materi" placeholder="Masukan link" > 
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
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

    <script>
    $(document).ready(function () {

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

        $('#materi').summernote({
          height: 250,
          toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
          ]
        });

        $('#materi-praktikum').summernote({
          height: 250,
          toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
          ]
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
                    console.log(resp);
                    var header = ` <div class="text-center">
                    <h1 class="text-center" id="judul-materi">`+resp.materi['nama']+`</h1><br>
                    <p style="font-size:24px;">`+resp.materi['deskripsi']+`</p>
                    </div><br><br>`;
                    $("#materi-area").append(header);
                    var body = "";
                    if (resp.file_materi != 'null') {
                      $.each(resp.file_materi,function(index,value){
                        console.log(value);
                          if (value.img != null) {
                            body += `<div class=" container multimedia-area d-flex justify-content-center">
                              <img class="img-fluid" src="`+value.img+`" alt="">
                              </div><br><hr>`
                          }

                          if (value.materi != null) {
                            body += `<h2>`+value.nama+`</h3>
                                        <p>`+value.materi+`</p><hr><br>`
                          }

                          if (value.file != null) {
                            body += `<div class="file-area">
                                        <h2>Materi Download</h2>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <a href="`+value.file+`" download>File Materi 1 <i class="fa fa-download"></i></a>
                                            </li>
                                        </ul>
                                    </div>`
                          }

                          if (value.link != null){
                            body += `<div class="link-area">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <a target="_blank" href="`+value.link+`">Link Materi 1 <i class="fa fa-globe"></i></a>
                                            </li>
                                        </ul>
                                    </div><hr><br>`
                          }
                      });
                      $("#materi-area").append(body);
                    }else{
                      body += `<h5>Materi tidak ditemukan</h5>`
                      $("#materi-area").append(body);
                    }
                }

            },
            error: function (resp) {
                alert('error! materi tidak bisa dibuka/ditemukan')
                console.log('error');
            }
        });
    }

    function hapusMateri(id) {
        swal({
            title: "Apakah yakin?",
            text: "Materi yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                  type: 'POST',
                  url: "{{url('/delete-materi')}}/" + id,
                  // data: {_token: CSRF_TOKEN},
                  dataType: 'JSON',
                  success: function (results) {
                      if (results.success === true) {
                        swal("Oke! Materi telah dihapus", {
                          icon: "success",
                        });
                        location.reload();
                      } else {
                          swal("Gagal!", results.message, "error");
                          location.reload();
                      }
                  }
              });
            swal("Materi telah terhapus!", {
              icon: "success",
            });
          } else {
            swal("Materi Aman!");
          }
        });
    }

    </script>
@endsection