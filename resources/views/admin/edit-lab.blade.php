@extends('layouts.admin.app')

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
      height: 300px;
      width: 300px;
    }
  </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Laboratorium {{$lab['nama']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
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

      <div class="card card-info">
        <div class="card-header">
          <h5 class="card-title">Edit Laboratorium {{$lab['nama']}}</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-edit-lab', $lab['id'] )}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Laboratorium</label>
                  <input type="text" class="form-control" name="nama_lab" placeholder="Nama Jurusan Lengkap" required autofocus value="{{$lab['nama']}}"> 
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" rows="3" name="deskripsi_lab" placeholder="Masukan Deskripsi Jurusan" required autofocus>{{$lab['deskripsi']}}</textarea>
                </div>
                <div class="form-group">
                  <label>Kepala Laboratorium</label>
                  <input list="klabs" name="klab" id="klab" value="{{$lab['kepala_lab']}}">
                    <datalist id="klabs">
                      {{-- <option selected>Wajib dipilih</option> --}}
                      @foreach ($dosen as $d)
                        <option value="{{$d->nomer_id}}">{{$d->nama}}</option>
                      @endforeach
                    </datalist>

                </div>
              </div>
              
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Pilih Jurusan</label>
                  <select name="kode" class="custom-select form-control">
                    @foreach ($data as $d)
                      <option value="{{$d->id}}" {{$lab['jurusan'] == $d->id ? 'selected' : '' }}>{{$d->nama}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Thumbnail</label>
                  <div class="input-group">
                      <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                              Browse… <input type="file" name="thumb" id="imgInp">
                          </span>
                      </span>
                      <input type="text" class="form-control" readonly>
                  </div>
                  <img src="{{asset($lab['thumbnail'])}}" id='img-upload'/>
                </div>
              </div>
            </div>
        </div>
          <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
@endsection

@section('js')
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