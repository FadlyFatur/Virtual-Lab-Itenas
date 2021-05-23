@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">User</h1>
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
              {{ session('errors') }}
          </div>
      @endif
      
      <div class="card card-info">
        <div class="card-header">
          <h5 class="card-title">Edit Mahasiswa</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" id="nama-user" placeholder="Nama Jurusan Lengkap" required autofocus> 
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" id="email-user" placeholder="Nama Jurusan Lengkap" required autofocus> 
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group=">
                  <label>Level</label>
                  <select name="roles_id" class="custom-select form-control">
                      <option value="0">Admin</option>
                      <option value="1">User/Tamu</option>
                      <option value="2">Mahasiswa</option>
                      <option value="3">Dosen</option>
                      <option value="4">Dosen | Kepala Lab</option>
                      <option value="5">Dosen | Koor Praktikum</option>
                      <option value="6">Mahasiswa | Assisten Lab</option>
                      <option value="7">Kaprodi</option>
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
          <h3 class="card-title">Data Semua User</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Nomer Unik</th>
                    <th>Tanggal Registrasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Level</th>
                <th>Nomer Unik</th>
                <th>Tanggal Aktif</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
        </table>
        </div>
      </div>

    </div>
@endsection

@section('js')
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-user') }}",
        columns: [
            {data: 'DT_RowIndex', width: 20, orderable: false, searchable:false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {   data: "roles_id",
                render: function (data) {
                    if (data == 0) {
                        return 'Admin';
                    }
                    
                    if (data == 1) {
                        return 'User/Tamu'
                    }

                    if (data == 2) {
                        return 'Mahasiswa'
                    }

                    if (data == 3) {
                        return 'Dosen'
                    }

                    if (data == 4){
                      return 'Dosen | Kepala Lab'
                    }

                    if (data == 5){
                      return 'Dosen | Koor Praktikum'
                    }

                    if (data == 6){
                      return 'Mahasiswa | Assisten Lab'
                    }

                    if (data == 7){
                      return "Kaprodi"
                    }
                }
            },
            { data: "nomer" },
            { data: "tanggal" },
            { data: 'aksi' }
        ]
    });

    $(".card-info").hide();
    
  });

  function editUser(id) {
    $(".card-info").hide();
    $.ajax({
        type: 'get',
        url: "get-user-detail/"+id ,
        dataType: 'JSON',
        success: function (resp) {
            $(".card-info").show();
            // console.log(resp.id);
            $("form").attr("action", "edit-user/"+resp.id);
            $("#nama-user").attr("value", resp.name);
            $("#email-user").attr("value", resp.email);
            // $('select option[value='+resp.roles_id+']').attr('selected','selected');
            $("select").val(resp.roles_id);
        }
    });
  }
</script>   
@endsection