@extends('layouts.app')
@section('style')
    @parent
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper">
    <div class="left">
        <img src="kak.img" alt="user" width="100">
        <h4>ilham muhammad haikal</h4>
        <p>Asisten Lab</p>
    </div>
    <div class="right">

        <div class="info">
            <div class="data">
                <h4>Email</h4>
                <p>ilhamadvntr27@gmail.com</p>
            </div>
            <div class="data">
                <h4>Phone</h4>
                <p>087735292871</p>
            </div>
        </div>

        <div class="project">
            <h3>project</h3>
            <div class="project_data">
                <div class="data">
                    <h4>Recent</h4>
                    <p>Loream ipsum</p>
                </div>
            <div class="data">
                <h4>Mostviwed</h4>
                <p>dolor sit amet.</p>
            </div>
        </div>
    </div>
</div>
@endsection