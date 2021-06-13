@extends('layouts.app')

@section('style')
    @parent
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <link href="{{ asset('css/detail-materi.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container margin-top">
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
      
      <form role="form" method="POST" action="{{route('post-edit-detailMateri', $data['id'])}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tipe" value="{{$data['type']}}">
        <label>Pilih Tipe</label>
        <select  id="tipe" class="form-select" aria-label="type materi" disabled>
          <option value="1" {{$data['type'] == 1 ? 'selected' : '' }}>Teks/Deskriptif</option>
          <option value="2" {{$data['type'] == 2 ? 'selected' : '' }}>Gambar/Image</option>
          <option value="3" {{$data['type'] == 3 ? 'selected' : '' }}>File</option>
          <option value="4" {{$data['type'] == 4 ? 'selected' : '' }}>Link/URL</option>
          <option value="5" {{$data['type'] == 5 ? 'selected' : '' }}>Tugas</option>
        </select><br>
        <label for="pilih_materi">Pilih Materi</label>
        <select name="pilih_materi" id="pilih_materi" class="form-select" aria-label="type materi" disabled>
          <option value="{{$data['materi_id']}}" selected>{{$data['nama_materi']}}</option>
        </select><br>
        <div class="form-group">
          <label for="nama_materi">Nama Materi</label>
          <input type="text" class="form-control" name="nama_materi" placeholder="Nama Materi (*Tipe Data, Function)" value="{{$data['nama']}}" autofocus> 
        </div>
        <hr>

        <div class="tipe-materi">
          <div class="materi-input">
            <div class="form-group">
              <label>Materi</label>
              <textarea class="form-control" id="materi-praktikum" rows="7" name="materi" placeholder="Masukan materi">{{$data['materi']}}</textarea>
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
                  <input {{asset($data['img'])}} type="text" class="form-control" readonly>
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
              <input type="text" class="form-control" name="link_materi" value="{{$data['link']}}" placeholder="Masukan link" > 
            </div>
          </div>
          <div class="tugas-input">
            <div class="form-group">
              <label>Deskripsi Tugas</label>
              <textarea class="form-control" id="tugas-praktikum" rows="7" name="tugas" placeholder="Masukan deskripsi tugas">{{$data['tugas']}}</textarea>
            </div>
          </div>
        </div>
        <a type="button" href="{{ url()->previous() }}" class="btn btn-info">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
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
    $(".tugas-input").hide();

    var option = $("#tipe option:selected").val();
    console.log(option);

    if (option == '1'){
        $(".materi-input").show();
        $(".gambar-input").hide();
        $(".file-input").hide();
        $(".link-input").hide();
        $(".tugas-input").hide();
    } if (option == '2'){
        $(".gambar-input").show();
        $(".materi-input").hide();
        $(".file-input").hide();
        $(".link-input").hide();
        $(".tugas-input").hide();
    } if (option == '3'){
        $(".file-input").show();
        $(".gambar-input").hide();
        $(".materi-input").hide();
        $(".link-input").hide();
        $(".tugas-input").hide();
    } if (option == '4'){
        $(".link-input").show();
        $(".gambar-input").hide();
        $(".file-input").hide();
        $(".materi-input").hide();
        $(".tugas-input").hide();
    } if (option == '5'){
        $(".link-input").hide();
        $(".gambar-input").hide();
        $(".file-input").hide();
        $(".materi-input").hide();
        $(".tugas-input").show();
    }

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

  });
</script>

@endsection