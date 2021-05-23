@extends('layouts.admin.app')

@section('style')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
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
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Laboratorium</h1>
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
  
      @if(session('errors'))
          <div class="alert alert-danger">
              {{ implode('', $errors->all(':message ')) }}
          </div>
      @endif
      
      <div class="card card-warning collapsed-card">
        <div class="card-header">
          <h5 class="card-title">Input Laboratorium</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-Lab')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Laboratorium</label>
                  <input type="text" class="form-control" name="nama_lab" placeholder="Nama Jurusan Lengkap" required autofocus> 
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" rows="3" name="deskripsi_lab" placeholder="Masukan Deskripsi Jurusan" required autofocus></textarea>
                </div>
                <div class="form-group">
                  <label>Pilih Kepala Laboratorium</label>
                  <select name="klab" class="custom-select form-control">
                      <option selected>Pilih Kepala Laboratorium</option>
                    @foreach ($dosen as $d)
                      <option value="{{$d->nomer_id}}">{{$d->nomer_id}} | {{$d->dosen->nama}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Pilih Jurusan</label>
                  <select name="kode" class="custom-select form-control">
                    <option selected>Wajib dipilih</option>
                    @foreach ($data as $d)
                      <option value="{{$d->id}}">{{$d->nama}}</option>
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
                  <img id='img-upload'/>
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
          <h3 class="card-title">Data Laboratorium</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Jurusan</th>
                    <th>Laboratorium</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Status</th>
                <th>Jurusan</th>
                <th>Laboratorium</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
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
        ajax: "{{ route('get-Lab') }}",
        columns: [
            { data: 'DT_RowIndex',  
                orderable: false, 
                searchable: false,
                width: 10,
            },
            {data: 'status', 
                render: function (data, type, row) {
                    let checked = null;
                    if(data == 1){
                        checked = "checked";
                    }
                    return `<div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" onchange="changeStatus(`+row.id+`)" id="switch`+row.id+`" `+checked+`>
                              <label class="custom-control-label" for="switch`+row.id+`"></label>
                            </div>`
                },
                orderable: false, 
                searchable: false,
                width: 20,
            },
            {data: 'jurusan'},  
            {data: 'nama'},
            {data: 'deskripsi'},
            {data: 'aksi', orderable: false, searchable: false}
        ]
    });
    
  });

  function hapusLab(id) {
      swal({
          title: "Apakah yakin?",
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
                type: 'POST',
                url: "delete-lab/"+id ,
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

  function changeStatus(id){
    $.ajax({
        type:'GET',
        url:"status-lab/"+id,
        success:function(data){
          console.log('1');
            if(data.status === true){
                swal({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                });
            }else{
                let message = data.message;
                swal({
                title: "Ups!",
                    text: data.message,
                    icon: "error",
                });
            }
        }
    });
  }
  
</script>   
@endsection