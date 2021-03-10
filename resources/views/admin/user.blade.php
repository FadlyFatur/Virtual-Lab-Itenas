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

      {{-- <div class="card card-warning collapsed-card">
        <div class="card-header">
          <h5 class="card-title">Input User</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
      </div> --}}
        <!-- /.card-header -->
        {{-- <div class="card-body">
          <form role="form">
            <div class="row">
              <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                  <label>Text</label>
                  <input type="text" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Text Disabled</label>
                  <input type="text" class="form-control" placeholder="Enter ..." disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <!-- textarea -->
                <div class="form-group">
                  <label>Textarea</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Textarea Disabled</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." disabled=""></textarea>
                </div>
              </div>
            </div>

            <!-- input states -->
            <div class="form-group">
              <label class="col-form-label" for="inputSuccess"><i class="fas fa-check"></i> Input with
                success</label>
              <input type="text" class="form-control is-valid" id="inputSuccess" placeholder="Enter ...">
            </div>
            <div class="form-group">
              <label class="col-form-label" for="inputWarning"><i class="far fa-bell"></i> Input with
                warning</label>
              <input type="text" class="form-control is-warning" id="inputWarning" placeholder="Enter ...">
            </div>
            <div class="form-group">
              <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> Input with
                error</label>
              <input type="text" class="form-control is-invalid" id="inputError" placeholder="Enter ...">
            </div>

            <div class="row">
              <div class="col-sm-6">
                <!-- checkbox -->
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">Checkbox</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" checked="">
                    <label class="form-check-label">Checkbox checked</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled="">
                    <label class="form-check-label">Checkbox disabled</label>
                  </div>
                </div>
              </div> 
              <div class="col-sm-6">
                <!-- radio -->
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio1">
                    <label class="form-check-label">Radio</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio1" checked="">
                    <label class="form-check-label">Radio checked</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" disabled="">
                    <label class="form-check-label">Radio disabled</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <!-- select -->
                <div class="form-group">
                  <label>Select</label>
                  <select class="form-control">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Select Disabled</label>
                  <select class="form-control" disabled="">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <!-- Select multiple-->
                <div class="form-group">
                  <label>Select Multiple</label>
                  <select multiple="" class="form-control">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Select Multiple Disabled</label>
                  <select multiple="" class="form-control" disabled="">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div> --}}
        <!-- /.card-body -->
      {{-- </div> --}}

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
                }
            },
        ]
    });
    
  });
</script>   
@endsection