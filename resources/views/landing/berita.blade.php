@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/berita.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <section id="Berita" class="berita">

            <div class="container" data-aos="fade-up">
    
                <div class="text-center mx-auto">
                    <h1>Info/Pengumuman</h1>
                </div><br><hr>
    
            <div class="row">
    
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
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
    
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
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
    
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
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

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
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
    
            </div>
    
        </section><!-- End Recent Blog Posts Section -->
    </div>
@endsection