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
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
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
              <span class="info-box-text">Bookmarks</span>
              <span class="info-box-number">410</span>
            </div>
          </div>
        </div>
        <div class="col-md-4"><div class="info-box bg-success">
          <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Bookmarks</span>
              <span class="info-box-number">410</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box bg-success">
            <span class="info-box-icon"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Bookmarks</span>
              <span class="info-box-number">410</span>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection