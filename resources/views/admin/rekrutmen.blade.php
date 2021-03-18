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
            @foreach ($errors->all() as $message) {
              {!! $message !!} <br> 
            @endforeach
          </div>
      @endif
      <div class="card card-warning">
        <div class="card-header">
          <h5 class="card-title">Buat Rekrutmen</h5>

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
                        <option value"3">3</option>
                        <option value"4">4</option>
                        <option value"5">5</option>
                        <option value"0">> 5</option>
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
                  <label>Nama Rekrutmen (*Opsional)</label>
                  <input type="text" class="form-control" name="nama_rekrutmen" placeholder="Nama Jurusan Lengkap"> 
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi Jurusan" required autofocus></textarea>
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
                    <th>Deskripsi</th>
                    <th>Kuota</th>
                    <th>Deadline</th>
                    <th>File</th>
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
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
  $(function(){
    //Date range picker
    $('#deadlineDate').datetimepicker({
      format: 'L'
    });  

    bsCustomFileInput.init();

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
            {data: 'deskripsi'},
            {data: 'kuota'},
            {data: 'deadline'},
            {data: 'file', orderable: false, searchable: false},
            {data: 'opsi', orderable: false, searchable: false}
        ]
    });
  });

function getPraktikum(id){
    $.ajax({
      type:'GET',
      url:"get-praktikum/"+id,
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
</script> 
@endsection