@extends('layouts.app')

@section('style')
    @parent
    <link href="{{ asset('css/detail-materi.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid margin-top">
        <div class="row">
            <div class="col-md-3 list-materi">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="#" id="absen">Absen</a>
                    </li>
                    @foreach ($data as $d)
                        <li class="list-group-item">
                            <a href="#" id="materi">{{$d->nama}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-8 detail-materi">
                <h1 class="text-center">Judul Materi 1</h1><br>
                <div id="materi-area">
                    <div class=" container multimedia-area d-flex justify-content-center">
                        <img class="img-fluid" src="https://www.gurupendidikan.co.id/wp-content/uploads/2019/07/Jaringan-Komputer.jpg" alt="">
                    </div><br><hr>
                    <h2>Deskrispi materi 1</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus eius aut sint esse provident voluptates quaerat, quod blanditiis aspernatur excepturi culpa sed, minus, ad corrupti itaque repellendus error eligendi in!</p>
                    <hr><br>
                    <div class="file-area">
                        <h2>Materi Download</h2>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="#">File Materi 1 <i class="fa fa-download"></i></a>
                            </li>
                            <li class="list-group-item">
                                <a href="#">File Materi 2 <i class="fa fa-download"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="link-area">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="#">Link Materi 1 <i class="fa fa-globe"></i></a>
                            </li>
                            <li class="list-group-item">
                                <a href="#">Link Materi 2 <i class="fa fa-globe"></i></a>
                            </li>
                        </ul>
                    </div><hr><br>
                    <div class="upload-area">
                        <h2>Upload Tugas</h2>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Kirim
                        </button>
                    </div>
                </div>

                
            </div>
        </div>
        <br>
        <div id="scrollhere"></div>
        <div class="row">
            <div class="col">
                <div class="p-3" id="absen-area">
                    <h2>Absen Mahasiswa</h2><br>
                    <div class="table-responsive-md">
                        <table class="table">
                            <caption>Absen 15-02-2021</caption>
                            <thead>
                              <tr>
                                <th scope="col">Materi</th>
                                <th scope="col">Absen</th>
                                <th scope="col">Tanggal Absen</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Materi 1</td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Masuk</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Telat</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Absen</label>
                                      </div>
                                    </div>
                                </td>
                                <td>-</td>
                                <td><span class="badge badge-danger">Belum Absen</span></td>
                                <td><a class="btn btn-primary" href="#">Simpan</a></td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('js')
    @parent
    <link href="{{ asset('js/detail-materi.js') }}">

    <script>
         $("#absen").on('click', function() {
                $('html,body').animate({
                    scrollTop: $("#scrollhere").offset().top},
                    'slow');
            });
    </script>

@endsection