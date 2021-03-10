@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-lab.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container margin-top nama-lab">
        <div class="text-center mx-auto">
            <h1>Laboratorium {{$lab->nama}}</h1>
        </div>
        
        <div class="m-3 container d-flex justify-content-center">
            
            <select class="form-select mr-2" aria-label="Default select example">
                <option selected>Pilih Semester</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <button class="btn btn-primary">Cek</button>
        </div>
        <br><hr>
    
        <div class="row">
          @foreach ($data as $d)
            <div class="col-md-6 mb-4">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <div class="jadwal-materi text-center">
                            <h2 style="color:#230b50;">Jadwal</h2>
                            <hr>
                            <h3>kelas</h3>
                            <h5>Jam</h5><br>
                            <p>Koor Lab</p><hr>
                            <p>Semester {{$d->Semester}} <br> {{$d->tahun_ajaran}}</p>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h4 class="card-title" style="color:#230b50;">{{$d->nama}}</h4>
                          <p class="card-text">{{substr($d->deskripsi, 0, 300)}}</p>
                          <p class="card-text"><small class="text-muted">Tanggal Dibuat : {{$d->created_at->format('d F Y')}}</small></p>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                          @if ($enroll->where('praktikum_id', $d->id)->count() > 0)
                            <a href="{{route('detail-materi',['id' => $d->id, 'slug' => $d->slug])}}"><button class="btn btn-info" style="color: #fff;">Masuk</button></a>
                          @else
                            <a href="{{route('daftar-prak',['id' => $d->id, 'slug' => $d->slug])}}"><button class="btn btn-success">Daftar</button></a>
                          @endif
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          @endforeach
        </div>

    </div>
@endsection

@section('js')
    @parent
    $('')
@endsection