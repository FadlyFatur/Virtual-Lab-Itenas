@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container margin-top">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="wrapper">
                <div class="left">
                    <img src="https://www.searchpng.com/wp-content/uploads/2019/02/Deafult-Profile-Pitcher.png" alt="user" width="100">
                    <h4>{{Auth::user()->name}}</h4>
                    <p>{{(Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2)? 'User' : 'Admin'}}</p>
                </div>
                <div class="right">
        
                    <div class="info">
                        <h3>Informasi</h3>
                        <div class="info_data">
                            <div class="data">
                                <h4>Email</h4>
                                <p>{{Auth::user()->email}}</p>
                            </div>
                            <div class="data">
                                <h4>Nomer Id</h4>
                                <p>{{ !empty(Auth::user()->nomer_id)  ? Auth::user()->nomer_id : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="project">
                        <h3>Laboratorium</h3>
                        <div class="project_data">
                            <div class="data">
                                <h4>Recent</h4>
                                <p>Loream ipsum blalalala</p>
                            </div>
                            <div class="data">
                                <h4>Most viewed</h4>
                                <p>Loream ipsum blalalala</p>
                            </div>
                        </div>
                    </div>
        
                    {{-- <div class="socialmedia">
                        <ul>
                            <li><a herf="#"><i class="fab fa-facebook-square"></i></a></li>
                            <li><a herf="#"></a><i class="fab fa-twitter"></i></li>
                            <li><a herf="#"><i class="fab fa-instagram-square"></i></a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
