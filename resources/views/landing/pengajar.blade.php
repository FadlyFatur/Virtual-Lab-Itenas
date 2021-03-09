@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/pengajar.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <!-- ======= Team Section ======= -->
        <section id="pengajar" class="pengajar">

            <div class="container">
    
                <div class="text-center mx-auto">
                    <h1>Pengajar dan Asisten Laboratorium</h1>
                </div><br><hr>
    
            <div class="row gy-4 text-center">
    
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
    
            </div>
  
        </section><!-- End Team Section -->
    </div>
@endsection