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
    height: 100px;
    width: 100px;
  }
</style>
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
            <form action="{{route('post-materi',$lab->id)}}" method="POST">
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

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Materi {{$lab->nama}}</h1>
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

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Materi {{$lab->nama}}</h3>  <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Materi</button>
          
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    {{-- <th>Opsi</th> --}}
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
          ajax: "{{ route('get-materi', "+$lab->id+") }}",
          columns: [
              { data: 'DT_RowIndex',  
                  orderable: false, 
                  searchable: false,
                  width: 20,
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
                  width:50,
                  orderable: false, 
                  searchable: false
              },
              {data: 'nama'},
              {data: 'deskripsi'},
              // {data: 'opsi', orderable: false, searchable: false}
          ]
      });
      
    });

  function changeStatus(id){
    $.ajax({
        type:'GET',
        url:"status-materi/"+id,
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