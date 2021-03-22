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
  height: 150px;
  width: 150px;
}
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">{{$lab->nama}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
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
  
      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif

      <div class="card card-info collapsed-card">
        <div class="card-header">
          <h5 class="card-title">Input Praktikum</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
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
                    <option value="2019-2020">2019-2020</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                  </select>
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

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Praktikum {{$lab->nama}}</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Tahun Ajaran</th>
                    <th>Kelas</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
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
  <script type="text/javascript">
    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('get-praktikum', "+$lab->id+") }}",
          columns: [
              {data: 'status', orderable: false, searchable: false,
                render: function (data, type, row) {
                    if (data == 1) {
                        return `<div class="custom-control custom-switch">
                                  <input type="checkbox" class="custom-control-input" id="switch`+row.id+`" checked>
                                  <label class="custom-control-label" for="switch`+row.id+`"></label>
                                </div>`;
                    }
                    if (data == 0) {
                        return `<div class="custom-control custom-switch">
                                  <input type="checkbox" class="custom-control-input" id="switch`+row.id+`">
                                  <label class="custom-control-label" for="switch`+row.id+`"></label>
                                </div>`;
                    }
                },
                orderable: false, 
                searchable: false
              },
              {data: 'nama'},
              {data: 'deskripsi'},
              {data: 'th'},
              {data: 'kelas'},
              {data: 'opsi', orderable: false, searchable: false}
          ]
      });
      
    });
  </script>  
@endsection