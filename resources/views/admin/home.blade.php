@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="info-box bg-success">
            <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Jurusan</span>
              <span class="info-box-number">{{$jur}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4"><div class="info-box bg-success">
          <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Laboratorium</span>
              <span class="info-box-number">{{$lab}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box bg-success">
            <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Praktikum</span>
              <span class="info-box-number">{{$prak}}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Mahasiswa</span>
              <span class="info-box-number">{{$mahasiswa}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4"><div class="info-box bg-gray">
          <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Dosen</span>
              <span class="info-box-number">{{$dosen}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Enroll</span>
              <span class="info-box-number">{{$enroll}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection