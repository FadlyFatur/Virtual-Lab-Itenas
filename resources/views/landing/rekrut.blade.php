@extends('layouts.app')

@section('content')
{{-- <a  href="{{ url($pen->historyLatest()->first()->file_proposal) }}" download class="btn btn-info" style="color:#f9f9f9 !important;font-size:12px;"><i class="fa fa-download" style="color:#f9f9f9 !important"></i>  Download Proposal </a> --}}
    <div class="container margin-top" data-aos="fade-up">
        <h1>Rekrutmen Assisten Laboratorium</h1><hr><br><br>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        @if(session('errors'))
            <div class="alert alert-danger">
                @foreach ($errors->all() as $message)
                {!! $message !!} <br> 
                @endforeach
            </div>
        @endif
        
        <div class="row">
            <div class="col-md-4">
                <label for="lab">Pilih Laboratorium</label>
                <select id="lab" class="custom-select" onchange="getPraktikum(this.value)">
                    <option selected>Pilih Laboratorium</option>
                    @foreach ($lab as $l)
                        <option value="{{$l->id}}">{{$l->nama}}</option>
                    @endforeach
                </select>
                
                <label for="praktikum" class="mt-3">Pilih Praktikum</label>
                <select id="praktikum" class="custom-select" onchange="getRekrut(this.value)">
                    <option selected>Pilih Praktikum</option>
                </select>
                <hr>

                <ul class="list-group" id="list-rekrutmen"></ul>
            </div>
            <div class="col md-8 ml-3 pl-3" style="border-left: 1px solid black;" id="rekrut-area">
                <h2>Silahkan pilih laboratorium dan praktikum</h2>
            </div>
        </div>
    </div>
    
@endsection

@section('js')
<script>
    
    function getPraktikum(id){
        $.ajax({
        type:'GET',
        url:"get-list-prak/"+id,
        success:function (resp) {
            $('#praktikum').empty();
            var body = "";
            if (resp.length > 0) {
                body += `<option selected>Pilih Praktikum</option>`;
                $.each(resp,function(index,value){
                // console.log(value);
                body += `<option value="`+value.id+`">`+value.nama+`</option>`;
                });
                $("#praktikum").append(body);
            }
            else{
                body += `<option selected>Tidak ada Praktikum</option>`
                $("#praktikum").append(body);
            }
        }
        });
    }

    function getRekrut(id) {
        $.ajax({
        type:'GET',
        url:"get-list-rekrut/"+id,
        success:function (resp) {
            // console.log(resp);
            var body = "";
            $('#list-rekrutmen').empty();
            if (resp.length > 0) {
                $.each(resp,function(index,value){
                    // console.log(value);
                    body += `<li class="list-group-item">
                                <a href="#get-detail-`+value.id+`" onclick="getRekrutDetail(`+value.id+`)" id="`+value.id+`">`+value.nama+`</a>
                            </li>`
                });
                $("#list-rekrutmen").append(body);
            }else{
                body += `<p>Belum ada rekrutmen</p>`
                $("#list-rekrutmen").append(body);
            }
        }, error:function(resp){
            console.log(resp);
            alert(resp);
        }
        })
    }

    function getRekrutDetail(id) {
        $.ajax({
        type:'GET',
        url:"get-rekrutmen/"+id,
        success:function (resp) {
            console.log(resp);
            var csrf_token = "{{ csrf_token() }}"
            $('#rekrut-area').empty();
            var body = "";
            if (resp.length != 0) {
                if(resp.cek == true){
                    body += `<h2 style="font-size:3rem;"><span class="badge badge-primary">`+resp.nama+`</span></h2>
                            <p><b>Info :</b> Sudah mendaftar, harap tunggu info lebih lanjut atau cek halaman profil</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NRP</th>
                                    <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>`+resp.user.name+`</td>
                                    <td>`+resp.user.nomer_id+`</td>
                                    <td>`+resp.user.email+`</td>
                                    </tr>
                                </tbody>
                            </table>`
                }else{
                body += `<h2 style="font-size:3rem;"><span class="badge badge-primary">`+resp.nama+`</span></h2>
                        <h3>Deadline : `+resp.deadline+`</h3>
                        <br>
                        <p>`+resp.deskripsi+`</p>
                        <a href="`+resp.file+`" download><h4><span class="badge badge-success">Download Persyaratan <i class="fa fa-download"></i></span></h4></a>
                        <hr>
                        <h4>Form Kelengkapan Rekrutmen</h4><br>
                        <form method="post"  action="/post-rekrutmen" enctype="multipart/form-data">
                            <input name="_token" value="`+csrf_token+`" type="hidden">
                            <input name="userId" value="`+resp.user.id+`" type="hidden">
                            <input name="rekrutId" value="`+resp.rekrut+`" type="hidden">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NRP</th>
                                    <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>`+resp.user.name+`</td>
                                    <td>`+resp.user.nomer_id+`</td>
                                    <td>`+resp.user.email+`</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="form-group">
                                <label for="biodata">Lembar Biodata *pdf</label>
                                <input type="file" class="form-control-file" id="file-data-diri" name="biodata">
                            </div>

                            <div class="form-group">
                                <label for="transkip">Transkip Nilai *pdf</label>
                                <input type="file" class="form-control-file" id="transkip" name="transkip">
                            </div>

                            <div class="form-group">
                                <label for="file">File Kelengkapan lain *zip</label>
                                <input type="file" class="form-control-file" id="file-lain" name="file">
                            </div>

                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <br>
                        </form>`;
                }

                $("#rekrut-area").append(body);
            }else{
                body += `<p>Data tidak ada</p>`
                $("#rekrut-area").append(body);
            }
        }, error:function(resp){
            console.log(resp);
            $('#rekrut-area').empty();
            var body = "";
            body =`<p>`+resp+`</p>`;
            $("#rekrut-area").append(body);
        }
        })
    }
</script> 
@endsection

