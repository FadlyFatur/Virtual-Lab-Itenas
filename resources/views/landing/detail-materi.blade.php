@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-materi.css') }}" rel="stylesheet">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
      
@endsection

@section('content')
  <!-- Modal materi -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
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
          <h5>Absen Tanggal : {{Carbon\Carbon::now()->toFormattedDateString()}}</h5><br>
          
          @foreach ($Cekabsen as $d)
            <hr>
            @php
              $tgl_absen = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d->tanggal_absen)->format('M d,Y - H:i');
              $now = Carbon\Carbon::now();
              $then = new Carbon\Carbon($d->tanggal_absen);
              $diff = $now->diffInMinutes($then);
            @endphp
            <h5>{{$d->nama}} - Tanggal : {{$tgl_absen}}</h5>
            <div class="form-group clearfix">
              @if (in_array($d->id, $dataAbsen_mhs))
                <p>Absen sudah disimpan</p>
              @else
                @if ($now->gte($then))
                  <form action="{{route('absen')}}" method="post">
                    @csrf
                    <input type="hidden" id="absen_id" name="absen_id" value="{{$d->id}}">
                    <div class="form-check form-check-inline">
                      @if ($diff >= 15)
                        <input class="form-check-input" type="radio" name="absen" id="inlineRadio1" value="1" disabled>
                      @else
                        <input class="form-check-input" type="radio" name="absen" id="inlineRadio1" value="1">
                      @endif
                      <label class="form-check-label" for="inlineRadio1">Masuk</label>
                    </div>
                    @if ($diff >= 1440)
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="absen" id="inlineRadio2" value="2" disabled>
                        <label class="form-check-label" for="inlineRadio2">Telat</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="absen" id="inlineRadio2" value="2" checked>
                        <label class="form-check-label" for="inlineRadio2">Absen</label>
                      </div>
                    @else
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="absen" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">Telat</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="absen" id="inlineRadio2" value="3">
                        <label class="form-check-label" for="inlineRadio2">Absen</label>
                      </div>
                    @endif
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                  </form>
                @else
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="masuk" id="inlineRadio1" value="1" disabled>
                    <label class="form-check-label" for="inlineRadio1">Masuk</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="telat" id="inlineRadio2" value="2" disabled>
                    <label class="form-check-label" for="inlineRadio2">Telat</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="absen" id="inlineRadio2" value="3" disabled>
                    <label class="form-check-label" for="inlineRadio2">Absen</label>
                  </div>
                @endif
              @endif
            </div>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal input absen-->
  <div class="modal fade" id="TambahAbsen" tabindex="-1" role="dialog" aria-labelledby="TambahAbsenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TambahAbsenLabel">Tambah Absen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{route('addAbsen')}}" method="post">
          @csrf
          <input type="hidden" class="form-control" name="prak_id" value="{{$prak->id}}"> 
          <div class="form-group">
            <label>Nama Absen</label>
            <input type="text" class="form-control" name="nama_absen" placeholder="Absensi Daskom 1" required> 
          </div>
          <div class="form-group">
            <label>Waktu Mulai</label>
            <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="tgl_absen" required/>
              <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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

  {{-- modal rekap absen  --}}
  <div class="modal fade" id="rekapAbsen" tabindex="-1" role="dialog" aria-labelledby="rekapAbsen" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rekapAbsen">Rekap Absen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('rekapAbsen')}}" method="GET">
            <label for="tipe-absen">Pilih Absen</label>
            <select name="absen_id" id="tipe-absen" class="form-select" aria-label="type materi">
              <option selected>Pilih Absen</option>
              @foreach ($Cekabsen as $d)
                <option value="{{$d->id}}">{{$d->nama}}</option>
              @endforeach
            </select><br>
            <button type="submit" class="btn btn-primary">Download</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- modal input tugas  --}}
  <div class="modal fade" id="inputTugas" tabindex="-1" role="dialog" aria-labelledby="inputTugas" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="inputTugas">Input tugas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('inputTugas')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="tugas-input"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- modal materi cek --}}
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
                  <option value="5">Tugas</option>
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
                {{-- <div class="form-group">
                  <label for="urutan">Urutan Materi</label>
                  <input type="number" class="form-control" name="urutan" placeholder="Urutan Materi (*1, 2, 3)" autofocus> 
                </div> --}}
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
                  <div class="tugas-input">
                    <div class="form-group">
                      <label>Deskripsi Tugas</label>
                      <textarea class="form-control" id="tugas-praktikum" rows="7" name="tugas" placeholder="Masukan deskripsi tugas"></textarea>
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

    <div class="container-fluid margin-top">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
      @endif

      @if(session('errors'))
          <div class="alert alert-danger">
            {{ implode('', $errors->all(':message ')) }}
          </div>
      @endif
        <div class="row">
            <div class="col-md-3">
                <ul class="list-group">
                    @if ($role == 0 || $assisten->where('praktikum_id', $id)->count() > 0 )
                      <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Materi</button>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#TambahAbsen"><i class="fa fa-plus"></i> Tambah Absen</button>
                    @endif
                    <br>
                    @if ($role != 1)
                      @if (count($Cekabsen) > 0)
                        <li class="list-group-item">
                            <a href="#" id="absen" data-toggle="modal" data-target="#absen"><i class="fa fa-list" aria-hidden="true"></i> Absen</a>
                        </li>
                      @endif
                    @endif
                    @foreach ($data as $d)
                        <li class="list-group-item">
                          <div id="materi-list" class="pull-left">
                            <button onclick="materiClick( {{$d->id}} )" class="btn btn-light" id="{{$d->id}}"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{$d->nama}}</button>
                          </div>
                            @if ( $role == 0 || $assisten->where('praktikum_id', $id)->count() > 0 )
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
                @if ($role == 0 || $assisten->where('praktikum_id', $id)->count() > 0 )
                  <div class="pull-left" id="input_area">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_materi">Input Materi</button>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rekapAbsen">Rekap Absen</button>
                      <a href="{{route('Tugas',$prak->id)}}" class="btn btn-primary">Penilaian Tugas</a>
                  </div><br><hr>
                @endif
                <div id="materi-area">
                    <div class="text-center">
                        <h1 id="judul-materi">{{$prak->nama}}</h1>
                        <p>{{$prak->deskripsi}}</p><br>
                          <h3>Assisten Laboratorium</h3>
                          <ul class="list-group list-group-flush">
                            @forelse ($listAsisten as $la)
                              <li class="list-group-item">{{$la->getUser->name}} | {{$la->getUser->nrp}}</li>
                            @empty
                              Belum ada assisten
                            @endforelse
                          </ul><br>
                        <hr><div class="d-flex justify-content-center">
                          <button class="btn btn-secondary">Silahkan Pilih Materi</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <br>
    </div>
@endsection

@section('js')
    @parent
    <link href="{{ asset('js/detail-materi.js') }}">
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

    <script>
    $(document).ready(function () {

        $(".materi-input").hide();
        $(".gambar-input").hide();
        $(".file-input").hide();
        $(".link-input").hide();
        $(".tugas-input").hide();

        $("#tipe").on('change', function() {
          // console.log($(this).val());
            if ($(this).val() == '1'){
                $(".materi-input").show();
                $(".gambar-input").hide();
                $(".file-input").hide();
                $(".link-input").hide();
                $(".tugas-input").hide();
            } if ($(this).val() == '2'){
                console.log('foto');
                $(".gambar-input").show();
                $(".materi-input").hide();
                $(".file-input").hide();
                $(".link-input").hide();
                $(".tugas-input").hide();
            } if ($(this).val() == '3'){
                console.log('file');
                $(".file-input").show();
                $(".gambar-input").hide();
                $(".materi-input").hide();
                $(".link-input").hide();
                $(".tugas-input").hide();
            } if ($(this).val() == '4'){
                console.log('link');
                $(".link-input").show();
                $(".gambar-input").hide();
                $(".file-input").hide();
                $(".materi-input").hide();
                $(".tugas-input").hide();
            } if ($(this).val() == '5'){
                console.log('link');
                $(".link-input").hide();
                $(".gambar-input").hide();
                $(".file-input").hide();
                $(".materi-input").hide();
                $(".tugas-input").show();
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

        $('#tugas-praktikum').summernote({
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

        $('#datetimepicker3').datetimepicker({
          format: 'DD-MM-YYYY, HH:mm',
        });

        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });

    function materiClick(id) {
        $.ajax({
            url: '/get-materi/'+id,
            type: 'get',
            dataType: 'json',
            success: function (resp) {
                $('#materi-area').empty();
                $('#tugas-input').empty();
                if(resp.length == 0){
                    $('#materi-area').append(up_btn);
                    alert('materi Tidak ditemukan');
                    return;
                }else{
                    console.log(resp);
                    var header = ` <div class="text-center">
                    <h1 class="text-center" id="judul-materi">`+resp.materi['nama']+`</h1>
                    <p style="font-size:24px;">`+resp.materi['deskripsi']+`</p>
                    </div><br><hr>`;
                    $("#materi-area").append(header);
                    var body = "";
                    var modal = "";
                    if (resp.file_materi != 'null') {
                      $.each(resp.file_materi,function(index,value){
                        console.log(value);
                          if (value.img != null) {
                            body += `<div class=" container multimedia-area d-flex justify-content-center">
                              <img class="img-fluid" src="`+value.img+`" alt="">
                              </div><hr><br>`
                          }

                          if (value.materi != null) {
                            body += `<h2>`+value.nama+`</h3>
                                        <p>`+value.materi+`</p><hr><br>`
                          }

                          if (value.file != null) {
                            body += `<div class="file-area">
                                        <h2>`+value.nama+`</h2>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <a href="download/`+value.file+`" class="btn btn-primary"><i class="fa fa-download"></i>  Download File </a>
                                            </li>
                                        </ul>
                                    </div><br>`
                          }

                          if (value.link != null){
                            body += `<div class="link-area">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <a target="_blank" href="`+value.link+`">Link Materi 1 <i class="fa fa-globe"></i></a>
                                            </li>
                                        </ul>
                                    </div><br>`
                          }

                          if (value.role != 1 && value.tugas != null) {
                            body += `<div class="tugas-area">
                                        <p><b>Tugas : </b> `+value.tugas+`</p>

                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#inputTugas">Simpan</button>
    
                                    </div><hr><br>`
                            
                            modal +=` <input type="hidden" name="user_id" value="`+value.user_id+`">
                                      <input type="hidden" name="materi_id" value="`+value.filemateri_id+`">
                                      <div class="form-group">
                                        <label for="tugas">Tugas <b>`+resp.materi['nama']+`</b></label>
                                        <input type="file" class="form-control-file" name="tugas" id="tugas">
                                      </div>`
                          }
                      });
                      $("#materi-area").append(body);
                      $("#tugas-input").append(modal);
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

    function download(path) {
      $.ajax({
            url: '/get-materi/'+id,
            type: 'get',
            dataType: 'json',
            success: function (resp) {
              console.log('suskses download');
            },
            error: function (resp) {
                alert('error! file tidak bisa dibuka/ditemukan')
                console.log('error');
            }
        });
    }


    </script>
@endsection