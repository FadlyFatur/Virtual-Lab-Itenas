@extends('layouts.app')

@section('style')
    @parent
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
@endsection

@section('content')

    <div class="container-fluid margin-top">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
      @endif

      @if(session('errors'))
          <div class="alert alert-danger">
            {{ implode('', $errors->all(':message, ')) }}
          </div>
      @endif
      
      @if (count($data)>0)
        <div class="row">
            <div class="col-md-3">
                <h4 class="text-center">Pilih Tugas</h4>
                <ul class="list-group" id="list-tugas">
                  @foreach ($data as $d => $items)
                    <li class="list-group-item">
                      <a href="#get-detail-{{$items['id']}}" onclick="getTugas({{$items['id']}})" id="{{$items['id']}}">{{$items['nama']}}</a>
                    </li>
                  @endforeach
                </ul>
            </div>

            <div class="col-md-8 side-line">
                
                <div class="pull-left" id="input_area">
                    <p id="notif">*Refresh halaman untuk menyimpan semua nilai</p>
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_materi">Rekap Nilai</button> --}}
                <hr></div>

                <div id="materi-area">
                  <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Nama</th>
                            <th>File</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                </table>

                </div>
            </div>
        </div>
        <br>
      @else
        <h3>Belum ada tugas untuk praktikum ini</h3>
      @endif

    </div>

@endsection

@section('js')
    @parent
    <link href="{{ asset('js/detail-materi.js') }}">
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script> --}}
    {{-- excel  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function () {
      $("#input_area").hide();
    });

      function updateNilai(id) {
        var nilai = $('#nilai'+id).val();
        nilai = parseInt(nilai);
        // console.log(id, nilai);
        if (isNaN(nilai)) {
          alert('Masukan input berupa angka');
          $('#nilai'+id).val("")
        }else{
          // console.log('no');
          $.ajax({
              url: "updateNilai/"+id,
              type : 'get',
              dataType: "json",
              async: true,
              cache: false,
              data: {
                  nilai: nilai,
              },
              success: function(data, status)
              {
                  console.log(status);
                  $("#input_area").show();
              },
              error: function (data, status) {
                  alert(status);
              }
          });
        }
      }

      function getTugas(id) {
        var table = $('.table').DataTable();
        table.destroy();
        $('.table').DataTable({
          dom: 'Bfrtip',
          buttons: [
            'copy',
            {
              extend: 'excel',
              exportOptions: {
                  columns: [ 0, 1, 3 ]
              }
            },
            {
              extend: 'pdf',
              exportOptions: {
                  columns: [ 0, 1, 3 ]
              }
            }
          ],
          processing: true,
          serverSide: true,
          ajax: "get-list-tugas/"+id,
          columns: [
              {data: 'status'},
              {data: 'user_id'},
              {data: 'file_tugas'},
              {data: 'nilai'},
            ]
        });
      }

    </script>
@endsection