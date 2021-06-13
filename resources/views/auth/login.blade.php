@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container margin-top">
    <div class="row main-content bg-success text-center">
        <div class="col-md-4 text-center company__info">
            <span class="company__logo">
                <img src="https://ept.itenas.ac.id/assets/img/logo-itenas.png" alt="logo">
            </span>
            <h4 class="company_title">Virtual Laboratorium Itenas</h4>
        </div>
        <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
            <div class="container-fluid">
                <div class="row mt-3">
                    <h2>Masuk</h2>
                </div>
                <div class="row mb-3 mt-2">
                    <form method="POST" action="{{ route('login') }}" class="form-group">
                        @csrf
                        <div class="row">
                            <input id="email" type="email" class="form__input form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <input id="password" type="password" class="form-control form__input @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check float-left">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingat Saya?') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link float-right pt-0" href="{{ route('password.request') }}">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <input type="submit" value="Masuk" class="btn-login">
                        </div>
                    </form>
                </div>
                <div class="row">
                    <p>Belum Punya Akun? <a href="{{ route('register') }}">Daftar</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

