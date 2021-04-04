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