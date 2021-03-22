@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Rekrutmen</h1>
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
            @foreach ($errors->all() as $message)
              {{ $message }}<br> 
            @endforeach
          </div>
      @endif
      <div class="card card-info collapsed-card">
        <div class="card-header">
          <a href="#buat-rekrutmen" data-card-widget="collapse"><h5 class="card-title">Buat Rekrutmen</h5></a>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-rekrutmen')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Pilih Laboratorium</label>
                      <select name="kode" id="kodeJurusan" onchange="getPraktikum(this.value)" class="custom-select form-control">
                        <option selected>Wajib dipilih</option>
                        @foreach ($data as $d)
                          <option value="{{$d->id}}">{{$d->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label>Tanggal Deadline:</label>
                        <div class="input-group date" id="deadlineDate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="deadline" data-target="#deadlineDate"/>
                            <div class="input-group-append" data-target="#deadlineDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Pilih Praktikum</label>
                      <select name="kode_praktikum" id="praktikum" class="custom-select form-control">
                        <option selected>pilih jurusan dahulu</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Kuota</label>
                      <select name="kuota" class="custom-select form-control">
                        <option selected>Wajib dipilih</option>
                        <option value"3">6</option>
                        <option value"4">8</option>
                        <option value"5">10</option>
                        <option value"0">> 10</option>
                      </select>
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
                  <input type="text" class="form-control" name="nama_rekrutmen" placeholder="Nama Jurusan Lengkap"> 
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" rows="5" name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi Jurusan" required autofocus></textarea>
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
          <h3 class="card-title">Data Rekrutmen</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Praktikum</th>
                    <th>Nama</th>
                    <th>Kuota</th>
                    <th>Deadline</th>
                    <th>Total Rekrutmen</th>
                    <th>File</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
      </div>

      <section id="detail-rekrut">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title judul-rekrutmen">List Pendaftaran Rekrutmen</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered list-rekrut">
              <thead>
                  <tr>
                      <th>Nama</th>
                      <th>NRP</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Opsi</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

            {{-- detail  --}}
            <div class="card card-primary card-outline mt-5" id="card-rekrutmen">

            </div>
          </div>
        </div>
      </section>

    </div>
@endsection

@section('js')
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
  $(function(){
    //Date range picker
    $('#deadlineDate').datetimepicker({
      format: 'L'
    });  

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

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-rekrutmen') }}",
        columns: [
            {data: 'status', 
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
            {data: 'praktikum_id'},
            {data: 'nama'},
            {data: 'kuota'},
            {data: 'deadline'},
            {data: 'total'},
            {data: 'file', orderable: false, searchable: false},
            {data: 'opsi', orderable: false, searchable: false}
        ]
    });
  });

function getPraktikum(id){
    $.ajax({
      type:'GET',
      url:"get-prak-rekrut/"+id,
      success:function (resp) {
        $('#praktikum').empty();
        var body = "";
        $.each(resp,function(index,value){
          console.log(value);
          body += `<option value="`+value.id+`">`+value.nama+`</option>`
        });
        $("#praktikum").append(body);
      }
    })
}

function getList(id) {
  $("#detail-rekrut").show();
  $('.list-rekrut').DataTable({
      processing: true,
      serverSide: true,
      ajax: "rekrutmen/list-rekrutmen/"+id,
      columns: [
          {data: 'nama'},
          {data: 'nrp'},
          {data: 'email'},
          {data: 'status', orderable: false, searchable: false},
          {data: 'opsi', orderable: false, searchable: false}
      ]
  });
}

function showRekrut(id) {
    $.ajax({
      type:'GET',
      url:"rekrutmen/get-detail-rekrutmen/"+id,
      success:function (resp) {
       console.log(resp);
       $('#card-rekrutmen').empty();
       var body = "";
       body +=`<div class="card-header">
                <h3 class="card-title">Detail Rekrutmen</h3>
              </div>
              <div class="card-body p-0">
                <div class="mailbox-read-info">
                  <h5>`+resp.nama+` | `+resp.nrp+`</h5>
                  <h6>`+resp.email+`
                    <span class="mailbox-read-time float-right">`+resp.tanggal+`</span></h6>
                </div>
                <ul class="mailbox-attachments d-flex align-items-stretch clearfix m-3">
                  <li>
                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
  
                    <div class="mailbox-attachment-info">
                      <a href="`+resp.bio+`" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>Biodata</a>
                          <span class="mailbox-attachment-size clearfix mt-1">
                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                          </span>
                    </div>
                  </li>
                  <li>
                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
  
                    <div class="mailbox-attachment-info">
                      <a href="`+resp.transkip+`" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Transkip Nilai</a>
                          <span class="mailbox-attachment-size clearfix mt-1">
                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                          </span>
                    </div>
                  </li>
                  <li>
                    <span class="mailbox-attachment-icon"><i class="fas fa-file-archive"></i></span>
  
                    <div class="mailbox-attachment-info">
                      <a href="`+resp.file+`" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> File Kelengkapan</a>
                          <span class="mailbox-attachment-size clearfix mt-1">
                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                          </span>
                    </div>
                  </li>
                 
                </ul>
              </div>

              <div class="card-footer">
                <button onclick="accept(`+resp.id+`,`+resp.user_id+`)" type="button" class="btn btn-danger"><i class="fa fa-check"></i> Diterima</button>
                <button onclick="denied(`+resp.id+`,`+resp.user_id+`)" type="button" class="btn btn-success"><i class="fa fa-ban"></i> Ditolak</button>
              </div>`;
          
        $("#card-rekrutmen").append(body);
      }
    })
}

function accept(id, userId) {

  swal({
      title: "Apakah Yakin?",
      text: "Proses ini tidak bisa diulang!",
      icon: "warning",
      buttons: [
        'Batal',
        'Terima!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Asisten Diterima!',
          text: 'Assisten berhasil ditambahkan',
          icon: 'success'
        }).then(function() {
          $.ajax({
            type:'GET',
            url:"rekrutmen/"+id+"/rekrutmen-accept/"+userId,
            success:function (resp) {
              console.log('berhasil');
              $('#card-rekrutmen').empty();
              $(".list-rekrut").dataTable().fnDestroy();
              getList(id);
            },error:function(resp){
              console.log('gagal');
            }
          });
        });
      } else {
        swal("Batal", "Silahkan pilih lagi", "error");
      }
    })
}

function denied(id, userId) {
  swal({
      title: "Apakah Yakin?",
      text: "Proses ini tidak bisa diulang!",
      icon: "warning",
      buttons: [
        'Batal',
        'Terima!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Asisten Ditolak!',
          text: 'Assisten berhasil ditolak',
          icon: 'info'
        }).then(function() {
          $.ajax({
            type:'GET',
            url:"rekrutmen/"+id+"/rekrutmen-denied/"+userId,
            success:function (resp) {
              console.log('berhasil');
              $('#card-rekrutmen').empty();
              $(".list-rekrut").dataTable().fnDestroy();
              getList(id);
            },error:function(resp){
              console.log('gagal');
            }
          })
        });
      } else {
        swal("Batal", "Silahkan pilih lagi", "error");
      }
    })
  
}
</script> 
@endsection