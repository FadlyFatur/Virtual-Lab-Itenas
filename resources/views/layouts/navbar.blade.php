<section style="height:100%; width: 100%; box-sizing: border-box; background-color: #FFFFFF">
    <div class="header-4-1" style="font-family: 'Poppins', sans-serif;">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{ url('/') }}">
                <img style="margin-right:0.75rem" src="http://api.elements.buildwithangga.com/storage/files/2/assets/Header/Header2/Header-2-2.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#targetModal-header-4-1">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="modal-header-4-1 modal fade" id="targetModal-header-4-1" tabindex="-1" role="dialog" aria-labelledby="targetModalLabel-header-4-1" aria-hidden="true" >
                <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-header-4-1">
                    <div class="modal-header" style="padding:	2rem; padding-bottom: 0;">
                    <a class="modal-title" id="targetModalLabel-header-4-1">
                        <img style="margin-top:0.5rem" src="http://api.elements.buildwithangga.com/storage/files/2/assets/Header/Header2/Header-2-2.png" alt="V-lab">
                        <span>Virtual Lab Itenas</span>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                    </div>
                    <div class="modal-body" style="padding:	2rem; padding-top: 0; padding-bottom: 0;">
                    <ul class="navbar-nav responsive-header-4-1 me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                        <a class="nav-link"  href="{{ url('/') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/jurusan') }}">Jurusan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/pengajar') }}">Tim Pengajar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/berita') }}">Berita</a>
                        </li>
                        @if (Auth::check())
                            @if (Auth::user()->roles_id != 1)
                                @if (Auth::user()->roles_id != 3)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/rekrutmen') }}">Rekrutmen</a></li>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="dropdown-item" href="{{route('home')}}">Profil</a>
                                </li>  
                            @endif
                        @endif
                    </ul>
                    </div>
                    <div class="modal-footer" style="padding:2rem; padding-top: 0.75rem">
                        @guest
                            <button class="btn btn-fill-header-4-1"><a class="nav-link" href="{{ route('login') }}">Masuk</a></button>
                        @else
                            <button class="btn btn-fill-header-4-1">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form1').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </button>
                        @endguest
                    </div>
                </div>
                </div>
            </div>
            
            <div class="collapse navbar-collapse" id="navbarTogglerDemo-header-4-1">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link"  href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/jurusan') }}">Jurusan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/pengajar') }}">Tim Pengajar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/berita') }}">Berita</a>
                    </li>
                    @if (Auth::check())
                        @if (Auth::user()->roles_id != 1)
                            @if (Auth::user()->roles_id != 3)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/rekrutmen') }}">Rekrutmen</a></li>
                                </li>
                            @endif
                            @if (Auth::user()->roles_id == 0 )
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>
                @guest
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                    </li>
                </ul>
                    <button class="btn btn-fill-header-4-1"><a class="nav-link" href="{{ route('login') }}">Masuk</a></button>
                @else
                    <div class="dropdown" id="user_login">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('home')}}">Profil</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Keluar') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>    

    
    </div>
  </section>