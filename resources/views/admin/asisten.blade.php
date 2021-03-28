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
      <section class="content">
        
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
                  <div class="card-header text-muted border-bottom-0">
                    Praktikum {{$d->praktikum->nama}}
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{$d->getUser->name}}</b></h2>
                        @if ($d->getUser->roles == 3 || $d->getUser->roles == 0)
                        <p class="text-muted text-sm mb-0"><b>Assisten Laboratorium</b></p>
                          <p class="text-muted text-sm"><b>NRP: </b> {{$d->getUser->nrp}}</p>
                        @endif
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
                  {{-- <div class="card-footer">
                    <div class="text-right">
                      <a href="#" class="btn btn-sm bg-teal">
                        <i class="fas fa-comments"></i>
                      </a>
                      <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i> View Profile
                      </a>
                    </div>
                  </div> --}}
                </div>
              </div>
              @endforeach

            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
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
            </nav>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
  
      </section>
    </div>

    
@endsection