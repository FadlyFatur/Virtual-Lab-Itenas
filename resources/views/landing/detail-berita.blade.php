@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/detail-berita.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="VIRTUAL-LAB-ITENAS container">
        <div class="row">
            <div class="col-md-6">
                <div class="VIRTUAL-LAB-ITENAS_img">
                    <img src="tesla.jpg" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="VIRTUAL-LAB-ITENAS_info">
                    <div class="VIRTXUAL-LAB-ITENAS_date">
                        <span>Selasa</span>
                        <span>15 maret 2021</span>
                    </div>
                    <h1 class="VIRTUAL-LAB-ITENAS_title">Investor Tesla Gugat Elon Musk, Mengapa?</h1>
                    <p class="VIRTUAL-LAB-ITENAS_text"> 
                    CEO Tesla Elon Musk dan dewan perusahaan mobil listrik Tesla secara resmi digugat pemegang saham 
                    karena penggunaan Twitter.
                    </p>
                </div>
            </div>
        </div>
    </div>    
@endsection
