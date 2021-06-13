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
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Jurusan</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div> 

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
          <h5 class="card-title">Input Jurusan</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-jurusan')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Jurusan</label>
                  <input type="text" class="form-control" name="nama_jurusan" placeholder="Nama Jurusan Lengkap" required autofocus> 
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" id="jurusan" name="deskripsi_jurusan" placeholder="Masukan Deskripsi Jurusan" required autofocus rows="10"></textarea>
                </div>
              </div>
              <div class="col-sm-6">
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
          <h3 class="card-title">Data Jurusan</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Nama Jurusan</th>
                    <th>Deskripsi Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Status</th>
                <th>Nama Jurusan</th>
                <th>Deskripsi Jurusan</th>
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

        var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('get-jurusan') }}",
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
                orderable: false, 
                searchable: false
              },
              {data: 'nama'},
              {data: 'deskripsi', width:500},
              {data: 'aksi', orderable: false, searchable: false},
            ]
        });
    });

    function changeStatus(id){
      $.ajax({
          type:'GET',
          url:"status-jurusan/"+id,
          success:function(data){
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

    function hapusJurusan(id){
      swal({
        title: "Apakah yakin?",
        text: "Jurusan yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
              type: 'get',
              url: "{{url('admin/delete-jurusan')}}/" + id,
              dataType: 'JSON',
              success: function (results) {
                  // console.log(results);
                  if (results.success === true) {
                    swal("Oke!", results.message, "success");
                    window.setTimeout(function(){ 
                      location.reload();
                    } ,2000);
                  } else {
                    swal("Gagal!", results.message, "error");
                  }
              }
          });
        } 
      });
    }
  </script>   
@endsection