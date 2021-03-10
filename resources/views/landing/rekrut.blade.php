@extends('layouts.app')

@section('content')
    <div class="container margin-top" data-aos="fade-up">
        <h1>Rekrutmen Assisten Laboratorium</h1><hr><br><br>
        <div class="row">
            <div class="col-md-4">
                <label for="jurusan">Pilih Jurusan</label>
                <select id="jurusan" class="custom-select">
                    <option selected>Buka dan pilih jurusan</option>
                    @foreach ($jurusan as $j)
                        <option value="{{$j->id}}">{{$j->nama}}</option>
                    @endforeach
                  </select>
                <hr>

                <ul class="list-group"> 
                    <li class="list-group-item">
                        <a href="#" id="absen">Lab. Fisika Dasar</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" id="materi">Lab. Jaringan Komputer</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">Lab. Jaringan Komputer Lanjut</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">Lab. Pengenalan Citra Digital</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">Lab. Algoritma Dasar</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">Lab. Multimedia</a>
                    </li>
                </ul>
            </div>
            <div class="col md-8 ml-5" style="border-left: 1px solid black; padding-left:40px;">
                <h2 style="font-size:3rem;"><span class="badge badge-info">Jaringan Komputer</span></h2>
                <br>
                <p>Deskripsi - Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam ex, porro placeat perferendis maiores molestias, similique, ullam tenetur ipsa earum beatae labore voluptatum adipisci unde aliquam iste dolor. Vitae, cum.</p>
                <a href="#"><p><span class="badge badge-success">Download Persyaratan <i class="fa fa-download"></i></span></p></a>
                <hr>
                <p><span class="badge badge-info">Form Kelengkapan</span></p>
                <form>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">NRP</label>
                      <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Form Data Diri</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Transkip Nilai</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Surat A</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Surat B</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <br>
                  </form>
            </div>
        </div>
    </div>
@endsection