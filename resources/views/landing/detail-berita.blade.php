@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/detail-berita.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="VIRTUAL-LAB-ITENAS container">
        <div class="row">
            <div class="col-md-6">
                <div class="VIRTUAL-LAB-ITENAS_img" style="background-image: url('{{asset('news-kosong.png')}}'); object-fit: cover; background-size: cover;">
                    <img src="" alt="{{asset($data->judul)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="VIRTUAL-LAB-ITENAS_info">
                    <div class="VIRTXUAL-LAB-ITENAS_date">
                        <span>{{$data->created_at->format('l')}}</span>
                        <span>{{$data->created_at->format('M d,Y - H:i')}}</span>
                    </div>
                    <h1 class="VIRTUAL-LAB-ITENAS_title">{{$data->judul}}</h1>
                    <p class="VIRTUAL-LAB-ITENAS_text">{!!$data->deskripsi!!}</p>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('js')
    <script src="{{ asset('js/readmore.js') }}"></script>

    <script>
        $(function() {
            // $('.VIRTUAL-LAB-ITENAS_text').readmore();
        });
    </script>
@endsection
