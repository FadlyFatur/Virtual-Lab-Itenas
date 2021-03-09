@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection
@section('content')
<div>
    <div class="mx-auto d-flex flex-lg-row flex-column hero-header-4-1">
      <!-- Left Column -->
      <div class="left-column-header-4-1 d-flex flex-lg-grow-1 flex-column align-items-lg-start text-lg-start align-items-center text-center">
        <p class="text-caption-header-4-1">Virtual Laboratorium itenas</p>
        <h1 class="title-text-big-header-4-1 d-lg-inline d-none text-left"><span style="font-size: 2.5rem">Tempat Praktikum Online</span><br>Insitut Teknologi Nasional Bandung</h1>
        <h1 class="title-text-small-header-4-1 d-lg-none d-inline text-left">Tempat Praktikum Online Insitut Teknologi Nasional</h1>
        <div class="div-button-header-4-1 d-inline d-lg-flex align-items-center mx-lg-0 mx-auto justify-content-center">
          <button class="btn d-inline-flex mb-md-0 btn-try-header-4-1">Try it free</button>
        </div>
      </div>
      <!-- Right Column -->
      <div class="right-column-header-4-1 text-center d-flex justify-content-lg-end justify-content-center pe-0">
        <img id="img-fluid" style="display: block;max-width: 100%;height: auto;" src="http://api.elements.buildwithangga.com/storage/files/2/assets/Header/Header4/Header-4-1.png" alt="">
      </div>

    </div>
</div>

 <div class="text-center title-text-content-2-1">
    <h1 class="text-title-content-2-1">Statistik</h1>
    <p class="text-caption-content-2-1" style="  margin-left: 3rem; margin-right: 3rem;">Lihat perkembangan Virtual Laboratorium Itenas</p>
  </div>

  <div class="grid-padding-content-2-1 text-center">
    <div class="row">
      <div class="col-lg-4 column-content-2-1">
        <div class="icon-content-2-1">
          <img src="http://api.elements.buildwithangga.com/storage/files/2/assets/Content/Content2/Content-2-2.png" alt="">
        </div>
        <p class="icon-content-2-1-caption">Pengguna</p>            
          <h3 class="icon-content-2-1-title">500</h3>
      </div>
      <div class="col-lg-4 column-content-2-1">
        <div class="icon-content-2-1">
          <img src="http://api.elements.buildwithangga.com/storage/files/2/assets/Content/Content2/Content-2-3.png" alt="">
        </div>
        <p class="icon-content-2-1-caption">Laboratorium</p>
          <h3 class="icon-content-2-1-title">10</h3>
      </div>
      <div class="col-lg-4 column-content-2-1">
        <div class="icon-content-2-1">
          <img src="http://api.elements.buildwithangga.com/storage/files/2/assets/Content/Content2/Content-2-4.png" alt="">
        </div>
        <p class="icon-content-2-1-caption">Materi</p>
        <h3 class="icon-content-2-1-title">70</h3>
      </div>
    </div>
  </div>

    @if (!Auth::check())   
    <div class="card-block-content-2-1">
        <div class="card-content-2-1">
            <div class="d-flex flex-lg-row flex-column align-items-center">
                <div class="me-lg-3">
                    <img src="http://api.elements.buildwithangga.com/storage/files/2/assets/Content/Content2/Content-2-1%20(1).png" alt="">          
                </div>
                <div class="flex-grow-1 text-lg-start text-center card-text-content-2-1">
                    <h3 class="card-content-2-1-title">Akses Materi tak Terbatas Selamanya</h3>
                    <p class="d-none d-lg-block card-content-2-1-caption">Itenas menyediakan berbagai macam materi pembelajaran <br>laboratorium yang mudah diakses</p>
                    <p class="d-block d-lg-none card-content-2-1-caption">Segera Daftarkan diri</p>
                </div>
                <div class="card-btn-space-content-2-1">
                    <a href="{{ route('register') }}"><button class="btn btn-card-content-2-1">Daftar</button></a>
                </div>
            </div>
        </div>
    </div>
    @endif

<!-- ======= Services Section ======= -->
<section id="lab" class="lab">

    <div class="text-center title-text-content-2-1">
        <h1 class="text-title-content-2-1">Jurusan / Bidang Ilmu</h1>
        <p class="text-caption-content-2-1" style="  margin-left: 3rem; margin-right: 3rem;">Silahkan Pilih salah satu untuk bisa <b>Akses Virtual Laboratorium</b> yang Tersedia</p>
    </div>

    <div class="container mb-5">
        <div class="row">
            @foreach ($jurusan as $j)
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                    <div class="card" style="width: 18rem;">
                        <img src="{{asset($j->thumbnail_path)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$j->nama}}</h5>
                            {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                            <a href="{{ route('lab', $j->slug) }}" class="btn btn-primary">Lihat Selengkapnya <i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>

        <hr>
        <div class="text-center text-lg-start d-flex justify-content-center">
            <a href="{{ url('/jurusan') }}" class="btn btn-primary d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Lihat Lebih Banyak</span>
            </a>
        </div>
    </div>

    </div>

</section><!-- End Services Section -->

<!-- ======= Team Section ======= -->
<section id="pengajar" class="pengajar">

    <div class="text-center title-text-content-2-1">
        <h1 class="text-title-content-2-1">Pengajar</h1>
        <p class="text-caption-content-2-1" style="margin-left: 3rem; margin-right: 3rem;">Menyiapkan para pendidik dari bidangnya</p>
    </div>
    
    <div class="container">
        <div class="row text-center">

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                        <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                    <h4>Walter White</h4>
                    <span>Chief Executive Officer</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                    <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                    <h4>Walter White</h4>
                    <span>Chief Executive Officer</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                    <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                    <h4>Walter White</h4>
                    <span>Chief Executive Officer</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                    <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                    <h4>Walter White</h4>
                    <span>Chief Executive Officer</span>
                    </div>
                </div>
            </div>
            
        </div>
        <hr>
        <div class="text-center text-lg-start d-flex justify-content-center">
            <a href="{{ url('/pengajar') }}" class="btn btn-primary d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Lihat Lebih Banyak</span>
            </a>
        </div>
    </div>
</section><!-- End Team Section -->

<!-- ======= berita Section ======= -->
<section id="berita" class="berita">

    <div class="text-center title-text-content-2-1">
        <h1 class="text-title-content-2-1">Info/Berita</h1>
        <p class="text-caption-content-2-1" style="margin-left: 3rem; margin-right: 3rem;">Lihat perkembangan dari dari virtual laboratorium</p>
    </div>
    
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="post-img">
                    <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                        <span class="post-date">Tue, September 15</span>
                        <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur sit</h3>
                        <a href="blog-singe.html" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="post-img">
                    <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                        <span class="post-date">Tue, September 15</span>
                        <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur sit</h3>
                        <a href="blog-singe.html" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="post-img">
                    <img src="" class="img-fluid" alt="">
                    </div>
                    <div class="member-info mt-2">
                        <span class="post-date">Tue, September 15</span>
                        <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur sit</h3>
                        <a href="blog-singe.html" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <div class="text-center text-lg-start d-flex justify-content-center">
            <a href="{{ url('/berita') }}" class="btn btn-primary d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Lihat Lebih Banyak</span>
            </a>
        </div>
    </div>
</section><!-- End Team Section -->

@endsection
