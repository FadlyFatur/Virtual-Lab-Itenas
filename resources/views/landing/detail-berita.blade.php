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
                    karena penggunaan Twitter.Tak hanya itu, investor juga menyoroti dewan Tesla yang dianggap lalai 
                    saat melakukan penyelesaian dengan U.S. Securities and Exchange Commission (SEC), sehingga pemegang 
                    saham mengalami kerugian miliaran dolar.Penyelesaian dengan SEC berasal dari tweet Musk pada Agustus 2018. 
                    Ia menyebut bila pihaknya sedang mempertimbangkan untuk mengambil Tesla secara pribadi dan memiliki 
                    penjaminan dana untuk kemungkinan transaksi USD 72 miliar. Pada bulan berikutnya, Musk dan Tesla setuju 
                    untuk membayar denda perdata sebesar USD 20 juta agar bisa diselesaikan dengan regulator. Musk juga meminta 
                    pengacara Tesla untuk memeriksa beberapa tweetnya terlebih dahulu. Gugatan pemegang saham mengatakan, 
                    Musk terus mengeluarkan tweet tanpa persetujuan sebelumnya. Karena itu, Musk dan direktur Tesla diharapkan 
                    untuk membayar ganti rugi karena melanggar kewajiban fidusia. Meski gugatan ini telah diberikan oleh  
                    investor Tesla, hingga saat ini belum ada penjelasan secara resmi dari Tesla terkait masalah yang sedang terjadi.
                    </p>
                </div>
            </div>
        </div>
    </div>    
@endsection
