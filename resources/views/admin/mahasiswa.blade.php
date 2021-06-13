@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Mahasiswa</h1>
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
      <div class="card card-primary collapsed-card">
        <div class="card-header">
          <h5 class="card-title">Input Mahasiswa</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-mahasiswa')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>NRP</label>
                  <input class="form-control" id="jurusan" name="noMaha" placeholder="Nomer ID" required autofocus>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required autofocus> 
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

      <div class="card card-info card-edit">
        <div class="card-header">
          <h5 class="card-title">Edit mahasiswa</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" id="form-edit" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>NRP</label>
                  <input type="text" class="form-control" id="nrp" name="nrp" placeholder="NRP" required autofocus>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required autofocus> 
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
          <button type="button" class="btn btn-sm btn-primary ml-3" data-toggle="modal" data-target="#importExcel">
            Import Excel
          </button>
        </div>
        <div class="card-body">
          <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NRP</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Nomer Pegawai</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
        </table>
        </div>
      </div>
      
      
    </div>

    <!-- Import Excel -->
		<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="mahasiswa/import_excel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
						</div>
						<div class="modal-body">
 
							{{ csrf_field() }}
 
							<label>Pilih file excel</label>
							<div class="form-group">
								<input type="file" name="file" required="required">
							</div>
 
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
@endsection

@section('js')
<script type="text/javascript">
  $(function () {
    $(".card-edit").hide();
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-mahasiswa') }}",
        columns: [
            { data: 'DT_RowIndex',  
              orderable: false, 
              searchable: false,
              width: 20,
            },
            {data: 'nrp', name: 'nrp'},
            {data: 'nama', name: 'nama'},
            {data: 'status', render: function (data){
                if (data == 1){
                  return '<small class="badge badge-warning">Aktif</small>';
                }else{
                  return '<small class="badge badge-danger">Non-Aktif</small>';
                }
              }
            },
            {data: 'aksi'}
        ]
    });
    
  });

  function editMahasiswa(id) {
    $(".card-edit").hide();
    $.ajax({
        type: 'get',
        url: "get-mahasiswa-detail/"+id ,
        dataType: 'JSON',
        success: function (resp) {
            $(".card-edit").show();
            $("form").attr("action", "edit-maha/"+resp.nrp);
            $("#nrp").attr("value", resp.nrp);
            $("#nama").attr("value", resp.nama);
        }
    });
  }

  function hapusMaha(id) {
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
                type: 'post',
                url: "mahasiswa/hapus-mahasiswa/"+id ,
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
</script>   
@endsection