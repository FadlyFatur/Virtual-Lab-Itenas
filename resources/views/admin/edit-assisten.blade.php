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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Edit Assisten</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
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
      <div class="container">
        <div class="card card-primary">
            <div class="card-header">
              <h5 class="card-title">Edit Assisten</h5>
    
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body pb-0">
              <form role="form" method="POST" action="{{route('post-edit-Assisten',$data['id'])}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
  
                      <label for="maha">Mahasiswa</label>
                      <input list="mahasiswas" type="text" name="maha" id="maha" value="{{$data['maha']}}" disabled>
                      <input type="hidden" name="maha_id" value="{{$data['maha_id']}}">
                    </div>
  
                    <div class="form-group">
                      <label>Pilih Jabatan Praktikum</label>
                      <select name="Jabatan" id="kodeJab" class="custom-select form-control">
                        <option value='2' {{$data['role'] == 2 ? 'selected' : '' }}>Kordinator Assisten Laboratorium</option>
                        <option value='1' {{$data['role'] == 1 ? 'selected' : '' }}>Asissten Laboratorium</option>
                      </select> 
                    </div>
                  </div>
  
                  <div class="col-md-6">
                    {{-- <div class="form-group">
                      <label>Pilih Jurusan</label>
                      <select name="jurusan" id="kodeJurusan"  class="custom-select form-control" disabled>
                        <option selected>{{}}</option>

                      </select>
                    </div> --}}
  
                    <div class="form-group">
                      <label>Pilih Laboratorium</label>
                      <select name="lab" id="kodeLab" class="custom-select form-control" disabled>
                        <option selected>{{$data['lab']}}</option>
                      </select>
                    </div>
  
                    <div class="form-group">
                      <label>Pilih Praktikum</label>
                      <select name="Prak" id="kodePrak" class="custom-select form-control">
                          @foreach ($prak as $p)
                            <option value="{{$p->id}}" {{$data['prak_id'] == $p->id ? 'selected' : '' }}>{{$p->nama}}</option>
                          @endforeach
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

      </div>

    </div>
@endsection

@section('js')
  <script>
    $(document).ready( function() {
 
    });

  </script>   
@endsection