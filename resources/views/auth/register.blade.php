@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container margin-top">
    @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Gagal</strong>{!! implode('', $errors->all('<div>:message</div>')) !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
                    <h2>Daftar</h2>
                    <div class="d-flex justify-content-center mb-3 mt-2">
                        <button type="button" id="btn-umum" class="btn btn-light mr-3">Umum</button>
                        <button type="button" id="btn-Dosen" class="btn btn-light ml-3 mr-3">Dosen</button>
                        <button type="button" id="btn-Maha" class="btn btn-light ml-3">Mahasiswa</button>
                    </div>
                </div>
                <div class="row">
                    <form method="POST" action="{{ route('register') }}" class="form-group">
                        @csrf
                        <div class="row dosen-input">
                            <input id="nomer_id" type="number" class="form-control form__input @error('nomor_id') is-invalid @enderror" placeholder="Nomer Pegawai" name="nomer_id" value="{{ old('nomor_id') }}">

                            @error('nomer_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row maha-input">
                            <input id="nrp" type="number" class="form-control form__input @error('nrp') is-invalid @enderror" placeholder="NRP" name="nrp" value="{{ old('nrp') }}">

                            @error('nrp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <input id="name" type="text" class="form-control form__input @error('name') is-invalid @enderror" placeholder="Nama" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <input id="email" type="email" class="form-control form__input @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <input id="password" type="password" class="form-control form__input @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <input id="password-confirm" type="password" class="form-control form__input" name="password_confirmation" placeholder="Password Konfirmasi" required autocomplete="new-password">
                        </div>
                        <div class="row d-flex justify-content-center">
                            <input type="submit" value="Daftar" class="btn-login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/login.js') }}"></script>
@endsection
