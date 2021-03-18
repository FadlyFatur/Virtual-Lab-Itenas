@extends('layouts.app')

@section('content')
    <div class="container margin-top" data-aos="fade-up">
        <h1>Rekrutmen Assisten Laboratorium</h1><hr><br><br>
        <div class="row">
            <div class="col-md-4">
                <label for="jurusan">Pilih Laboratorium</label>
                <select id="jurusan" class="custom-select" onchange="getPraktikum(this.value)">
                    <option selected>Pilih Laboratorium</option>
                    @foreach ($lab as $l)
                        <option value="{{$l->id}}">{{$l->nama}}</option>
                    @endforeach
                  </select>
                <hr>

                <ul class="list-group" id="list-praktikum">
                    
                </ul>
            </div>
            <div class="col md-8 ml-5" style="border-left: 1px solid black; padding-left:40px;" id="rekrut-area">
                <h1>Silahkan pilih laboratorium dan praktikum</h1>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function getPraktikum(id){
    $.ajax({
      type:'GET',
      url:"get-praktikum/"+id,
      success:function (resp) {
        $('#list-praktikum').empty();
        var body = "";
        if (resp.length > 0) {
            $.each(resp,function(index,value){
            console.log(value);
            body += `<li class="list-group-item" >
                            <a href="#get-detail-`+value.id+`" onclick="getRekrut(`+value.id+`)" id="`+value.id+`">`+value.nama+`</a>
                        </li>`
            });
            $("#list-praktikum").append(body);
        }else{
            body = `<p>Silahkan pilih laboratorium untuk melanjutkan</p>`
            $("#list-praktikum").append(body);
        }
      }
    })
}

function getRekrut(id) {
    $.ajax({
      type:'GET',
      url:"get-rekrutmen/"+id,
      success:function (resp) {
        console.log(resp.nama);
        $('#rekrut-area').empty();
        var body = "";
        if (resp.length != 0) {
            body += `<h2 style="font-size:3rem;"><span class="badge badge-primary">`+resp.nama+`</span></h2>
                    <h3>Deadline : `+resp.deadline+`</h3>
                    <br>
                    <p>`+resp.deskripsi+`</p>
                    <a href="`+resp.file+`" download><p><span class="badge badge-success">Download Persyaratan <i class="fa fa-download"></i></span></p></a>
                    <hr>
                    <p><span class="badge badge-warning">Form Kelengkapan</span></p>
                    <form>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control" id="" aria-describedby="" placeholder="Enter email">
                      <small id="" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">NRP</label>
                      <input type="number" class="form-control" id="" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Form Data Diri</label>
                        <input type="file" class="form-control-file" id="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Transkip Nilai</label>
                        <input type="file" class="form-control-file" id="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Surat A</label>
                        <input type="file" class="form-control-file" id="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Surat B</label>
                        <input type="file" class="form-control-file" id="">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <br>
                  </form>`

            $("#rekrut-area").append(body);
        }else{
            body = `<p>Data tidak ada</p>`
            $("#rekrut-area").append(body);
        }
      }
    })
}
</script> 
@endsection