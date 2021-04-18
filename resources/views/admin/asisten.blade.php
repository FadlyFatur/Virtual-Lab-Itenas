@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">List Asisten/Staff Laboratorium</h1>
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
      <section class="content">
        <div class="card card-info collapsed-card">
          <div class="card-header">
            <h5 class="card-title">Input Assisten</h5>
  
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body pb-0">
            <form role="form" method="POST" action="{{route('post-assisten')}}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Pilih Mahasiswa</label>
                    <select name="maha" id="kodeMaha" class="custom-select form-control">
                      <option selected>Wajib dipilih</option>
                      @foreach ($maha as $m)
                        <option value="{{$m->id}}">{{$m->nrp}} | {{$m->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Pilih Jabatan Praktikum</label>
                    <select name="Jabatan" id="kodeJab" class="custom-select form-control">
                      <option selected>Pilih jabatan</option>
                      <option value='2'>Kordinator Laboratorium</option>
                      <option value='1'>Asissten Laboratorium</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Pilih Jurusan</label>
                    <select name="jurusan" id="kodeJurusan" onchange="getLab(this.value)" class="custom-select form-control">
                      <option selected>Wajib dipilih</option>
                      @foreach ($jur as $d)
                        <option value="{{$d->id}}">{{$d->nama}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Pilih Laboratorium</label>
                    <select name="lab" id="kodeLab" onchange="getPraktikum(this.value)" class="custom-select form-control">
                      <option selected>Pilih jurusan dahulu</option>
                    </select>
                  </div>

                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Pilih Praktikum</label>
                    <select name="Prak" id="kodePrak" class="custom-select form-control">
                      <option selected>Pilih Lab dahulu</option>
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
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-header">
                <h5 class="card-title">List Assisten</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              @foreach ($data as $d)
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0 clearfix">
                    <p class="float-left">{{$d->praktikum->nama}}</p>
                    <div class="float-right">
                      <a class="btn btn-primary btn-sm" href=""><i class="fas fa-edit"></i></a> 
                      <button class="btn btn-danger btn-sm" onclick="hapusAssisten({{$d->id}})"><i class="fas fa-trash"></i></button>
                    </div>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{$d->getUser->name}}</b></h2>
                        @if ($d->role == 1)
                          <p class="text-muted text-sm mb-0"><b>Asisten Laboratorium</b></p>
                        @else
                          <p class="text-muted text-sm mb-0"><b>Koordinator Asisten Laboratorium</b></p>
                        @endif
                          <p class="text-muted text-sm"><b>NRP: </b> {{$d->getUser->nrp}}</p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{$d->getUser->email}}</li>
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="{{asset('avatar-icon-6.jpg')}}" alt="" class="img-circle img-fluid" style="background-image: url('{{asset('avatar-icon-6.jpg')}}'); object-fit: cover; background-size: cover;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach

            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">6</a></li>
                <li class="page-item"><a class="page-link" href="#">7</a></li>
                <li class="page-item"><a class="page-link" href="#">8</a></li>
              </ul>
            </nav> --}}
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
  
      </section>
    </div>

    
@endsection

@section('js')
<script>
    function getLab(id){
      $.ajax({
        type:'GET',
        url:"get-lab-list/"+id,
        success:function (resp) {
          $('#kodeLab').empty();
          var body = "";
          body += `<option selected">Pilih salah satu</option>`
          $.each(resp,function(index,value){
            body += `<option value="`+value.id+`">`+value.nama+`</option>`
          });
          $("#kodeLab").append(body);
        }
      })
    }

    function getPraktikum(id){
      console.log('cek');
      $.ajax({
        type:'GET',
        url:"get-prak-rekrut/"+id,
        success:function (resp) {
          $('#kodePrak').empty();
          var body = "";
          $.each(resp,function(index,value){
            // console.log(value);
            body += `<option value="`+value.id+`">`+value.nama+`</option>`
          });
          $("#kodePrak").append(body);
        }
      })
    }

    function hapusAssisten(id) {
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
                url: "hapus-asisten/"+id ,
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