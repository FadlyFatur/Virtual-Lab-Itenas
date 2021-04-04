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

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Semua User</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
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
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-user') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {   data: "roles_id",
                render: function (data) {
                    if (data == 0) {
                        return 'Admin';
                    }
                    
                    if (data == 1) {
                        return 'User'
                    }

                    if (data == 2) {
                        return 'Mahasiswa'
                    }

                    if (data == 3) {
                        return 'Dosen'
                    }
                }
            },
        ]
    });
    
  });
</script>   
@endsection