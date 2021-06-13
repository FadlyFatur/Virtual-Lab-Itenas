@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Edit Rekrutmen</h1>
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
            @foreach ($errors->all() as $message)
              {{ $message }}<br> 
            @endforeach
          </div>
      @endif
      <div class="card card-info">
        <div class="card-header">
          <a href="#buat-rekrutmen" data-card-widget="collapse"><h5 class="card-title">Edit Rekrutmen</h5></a>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-edit-Rekrut', $data['id'])}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">

                <div class="row">
                  <div class="col-md-6">
                    
                    <div class="form-group">
                      <label>Tanggal Deadline:</label>
                        <div class="input-group date" id="deadlineDate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="deadline" id="deadline" data-target="#deadlineDate" value="{{$data['deadline']}}"/>
                            <div class="input-group-append" data-target="#deadlineDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="col-md-6">

                    <div class="form-group">
                      <div class="form-group">
                        <label>Kuota</label>
                        <input type="number" class="form-control" name="kuota" value="{{$data['kuota']}}" placeholder="Masukan jumlah kuota dalam nomer"> 
                      </div>
                    </div>
                    
                  </div>
                </div>

                <div class="form-group">
                  <label for="fileSyarat">File Persyaratan (*rar/zip)</label>

                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="fileSyarat" id="fileSyarat">
                    <label class="custom-file-label" for="fileSyarat">Pilih file</label>
                  </div>
                </div>

              </div>
              
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Rekrutmen</label>
                  <input type="text" class="form-control" name="nama_rekrutmen" value="{{$data['nama']}}" placeholder="Nama Jurusan Lengkap"> 
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" rows="5" name="deskripsi" id="deskripsi"  placeholder="Masukan Deskripsi Jurusan" required autofocus>{{$data['deskripsi']}}</textarea>
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
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
  $(function(){
    var tgl = $('#deadline').val()
    console.log(tgl);

    //Date range picker
    $('#deadlineDate').datetimepicker({
      format: 'L'
    });  
    $('#deadlineDate').datetimepicker('date', tgl);

    $('#deadlineDate').val("2018-07-22")

    bsCustomFileInput.init();
    $("#detail-rekrut").hide();
    $('#deskripsi').summernote({
      height: 150,
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