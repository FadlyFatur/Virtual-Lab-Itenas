@extends('layouts.admin.app')
@section('style')
@parent

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
  height: 150px;
  width: 150px;
}
</style>
  {{-- modal Tambah Kelas --}}
  <div class="modal fade" id="tambah-kelas" tabindex="-1" role="dialog" aria-labelledby="tambah-kelasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambah-kelaslLabel">Tambah Kelas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" action="{{route('post-kelas')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Kelas</label>
                  <input type="text" class="form-control" name="nama_kelas" placeholder="Nama/Kode Kelas" required autofocus> 
                </div>
                <div class="form-group">
                  <label>Deskripsi Kelas</label>
                  <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" autofocus></textarea>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Waktu Mulai</label>
                  <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="wm" required/>
                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Waktu Selesai</label>
                  <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="ws" required/>
                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Hari</label>
                  <select name="hari" class="custom-select form-control" required>
                    <option value= "" selected>Pilih salah satu</option>
                      <option value="Senin">Senin</option>
                      <option value="Selasa">Selasa</option>
                      <option value="Rabu">Rabu</option>
                      <option value="Kamis">Kamis</option>
                      <option value="Jumat">Jumat</option>
                      <option value="Sabtu">Sabtu</option>
                  </select>
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
            <button class="btn btn-info" data-toggle="modal" data-target="#tambah-kelas" style="margin-left: 32px">Tambah Kelas</button>
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
                    <th>No</th>
                    <th>Status</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Tahun Ajaran</th>
                    <th>Kelas</th>
                    <th>Materi</th>
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
@parent

  <script type="text/javascript">
    $(document).ready( function() {

      $('#datetimepicker3').datetimepicker({
        format: 'H:mm',
      });

      $('#datetimepicker4').datetimepicker({
        format: 'H:mm'
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
  </script>   

  <script type="text/javascript">
    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('get-praktikum', "+$lab->id+") }}",
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
              {data: 'deskripsi'},
              {data: 'th'},
              {data: 'kelas'},
              {data: 'materi', orderable: false, searchable: false},
              {data: 'opsi', orderable: false, searchable: false}
          ]
      });
      
    });

    function hapusPrak(id) {
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
                url: "delete-prak/"+id ,
                // data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    if (results.success === true) {
                      swal("Oke! Praktikum dan data lainya telah dihapus", {
                        icon: "success",
                      });
                      location.reload();
                    } else {
                        swal("Gagal!", results.message, "error");
                        location.reload();
                    }
                }
            });
          swal("Praktikum telah terhapus!", {
            icon: "success",
          });
        } else {
          swal("Praktikum Aman!");
        }
      });
  }

  function changeStatus(id){
    $.ajax({
        type:'GET',
        url:"status-prak/"+id,
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