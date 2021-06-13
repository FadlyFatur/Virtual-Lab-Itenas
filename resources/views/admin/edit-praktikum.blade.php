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

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Edit Praktikum </h1>
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

      <div class="card card-info">
        <div class="card-header">
          <h5 class="card-title">Edit Praktikum {{$prak['nama']}}</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pb-0">
          <form role="form" method="POST" action="{{route('post-edit-prak', $prak['id'])}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Praktikum</label>
                  <input type="text" class="form-control" name="nama_praktikum" placeholder="Nama Praktikum" value="{{$prak['nama']}}" required autofocus> 
                </div>
                <div class="form-group">
                  <label>Deskripsi/Rangkuman Singkat</label>
                  <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukan Deskripsi/Penjelsan Singkat" required autofocus>{{$prak['deskripsi']}}</textarea>
                </div>
              </div>
              <div class="col-sm-6">
                
                <div class="form-group">
                  <label>Semester</label>
                  <select name="semester" class="custom-select form-control" required>
                    <option value="Genap" {{$prak['semester'] == "Genap" ? 'selected' : '' }}>Genap</option>
                    <option value="Ganjil" {{$prak['semester'] == "Ganjil" ? 'selected' : '' }}>Ganjil</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Tahun Ajaran</label>
                  <select name="tahun_ajaran" class="custom-select form-control" required>
                    <option selected>Pilih salah satu</option>
                    <option value="2021-2022" {{$prak['tahun_ajaran'] == "2021-2022" ? 'selected' : '' }}>2021-2022</option>
                    <option value="2022-2023" {{$prak['tahun_ajaran'] == "2022-2023" ? 'selected' : '' }}>2022-2023</option>
                    <option value="2023-2024" {{$prak['tahun_ajaran'] == "2023-2024" ? 'selected' : '' }}>2023-2024</option>
                    <option value="2024-2025" {{$prak['tahun_ajaran'] == "2024-2025" ? 'selected' : '' }}>2024-2025</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Kelas</label>
                  <input list="kelases" name="kelas" id="kelas" value="{{$prak['kelas']}}">
                  <datalist id="kelases">
                    @foreach ($kelas as $d)
                      <option value= "{{$d->id}}">{{$d->nama}}</option>
                    @endforeach
                  </datalist>
                </div>

                <div class="form-group">
                  <label for="koor_dosen">Koordinator Praktikum (Dosen)</label>
                  <input list="koor_dosens" name="koor_dosen" id="koor_dosen" value="{{$prak['koor_dosen_prak']}}">
                  <datalist id="koor_dosens">
                    @foreach ($dosen as $d)
                      <option value="{{$d->nomer_id}}">{{$d->nama}}</option>
                    @endforeach
                  </datalist>
                </div>

                <div class="form-group">
                  <label>Koordinator Assisten</label>
                  <input list="koor_asiss" name="koor_asis" id="koor_asis" value="{{$prak['koor_assisten']}}">
                  <datalist id="koor_asiss">
                    @foreach ($assisten as $d)
                      <option value="{{$d->nrp}}">{{$d->nama}}</option>
                    @endforeach
                  </datalist>
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

@endsection