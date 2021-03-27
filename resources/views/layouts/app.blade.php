<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'VLab') }}</title>
      
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="{{asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
      @section('style')

      @show
    </head>
    <body>
      @include('layouts.navbar')
      
      <!-- //content  -->
      <section style="height:100%; width: 100%; box-sizing: border-box; background-color: #FFFFFF">
        @include('sweetalert::alert')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
          .btn:focus, .btn:active {
            outline: none !important;
          }
          .title-text-content-2-1 {
            padding-top: 5rem;
            margin-bottom: 3rem;
          }
          .text-title-content-2-1 {
            color: #121212;
            margin-bottom: 0.625rem;
            font-size: 2.25rem;
            line-height: 2.5rem;
            font-weight: 600;
          }
          .text-caption-content-2-1 {
            color: #121212;
            font-weight: 300;
          }
          .column-content-2-1 {
            padding-left: 2.25rem;
            padding-right: 2.25rem;
            padding-top: 2rem;
            padding-bottom: 2rem;
          }
          .icon-content-2-1 {
            margin-bottom: 1.5rem;
          }
          .icon-content-2-1-title {
            font-size: 1.5rem;
            line-height: 2rem;
            margin-bottom: 0.625rem;
            color: #121212;
          }
          .icon-content-2-1-caption {
            font-size: 1rem;
            line-height: 1.625;
            letter-spacing: 0.025em;
            color: #565656;
          }
          .card-block-content-2-1 {
            padding: 1rem 1rem 5rem 1rem;
            }
          .card-content-2-1 {
            padding: 1.75rem;
            background-color: #fff7f4;
            border-radius: 0.75rem;
            border: 1px solid #ff7c57;
          }
          .card-content-2-1-title {
            font-size: 1.5rem;
            line-height: 2rem;
            margin-bottom: 0.625rem;
            color: #000000;
            font-weight: 600;
          }
          .card-content-2-1-caption {
            font-size: 1rem;
            line-height: 1.5rem;
            color: #565656;
            letter-spacing: 0.025em;
            font-weight: 300;
            margin-bottom: 0;
          }
          .btn-card-content-2-1 {
            font-size: 1rem;
            line-height: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            background-color: #ff7c57;
            padding-top: 1rem;
            padding-bottom: 1rem;
            width: 100%;
            border-radius: 0.75rem;
            margin-bottom: 1.25rem;
          }
          .btn-card-content-2-1:hover {
            color: #ffffff;
            --tw-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
              0 4px 6px -2px rgba(0, 0, 0, 0.05);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
              var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
          }
          .btn-outline-content-2-1 {
            font-size: 1rem;
            line-height: 1.5rem;
            color: #979797;
            border: 1px solid #979797;
            padding-top: 1rem;
            padding-bottom: 1rem;
            width: 100%;
            border-radius: 0.75rem;
          }
          .btn-outline-content-2-1:hover {
            border: 1px solid #ff7c57;
            color: #ff7c57;
          }
          .card-text-content-2-1 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
          }
          .grid-padding-content-2-1 {
            padding: 0rem 1rem 3rem 1rem;
          }
          @media (min-width: 576px) {
            .grid-padding-content-2-1 {
              padding: 0rem 2rem 3rem 2rem;
            }
            .card-block-content-2-1 {
            padding: 3rem 2rem 5rem 2rem;
            }
          }
          @media (min-width: 768px) {
            .grid-padding-content-2-1 {
              padding: 0rem 4rem 3rem 4rem;
            }
            .card-block-content-2-1 {
            padding: 3rem 4rem 5rem 4rem;
            }
          }
          @media (min-width: 992px) {
            .grid-padding-content-2-1 {
              padding: 1rem 6rem 3rem 6rem;
            }
            .card-block-content-2-1 {
            padding: 3rem 6rem 5rem 6rem;
            }
            .column-content-2-1 {
            padding-left: 2.25rem;
            padding-right: 2.25rem;
            padding-top: 0;
            padding-bottom: 0;
          }
          }
          @media (min-width: 1200px) {
            .grid-padding-content-2-1 {
              padding: 1rem 10rem 3rem 10rem;
            }
            .card-block-content-2-1 {
            padding: 3rem 6rem 5rem 6rem;
            }
            .card-btn-space-content-2-1 {
              margin-top: 15px;
              margin-bottom: 15px;
            }
            .btn-card-content-2-1 {
              width: 95%;
              float: right;
            }
            .btn-outline-content-2-1 {
              width: 95%;
              float: right;
            }
          }
          @media (max-width: 980px) {
            .card-btn-space-content-2-1 {
              width: 100%;
            }
          }
        </style>
        <div style="font-family: 'Poppins', sans-serif;">

          @yield('content')
        </div>
      </section>

      @include('layouts.footer')

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
      <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      
      <!-- Template Main JS File -->
      {{-- <script src="{{ asset('assets/js/main.js') }}"></script> --}}
      <script src="{{ asset('js/app.js') }}"></script>
      <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      </script>
      @section('js')
      
      @show
    </body>
  </html>