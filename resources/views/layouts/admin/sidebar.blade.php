  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link text-center">
      <img src="https://rekreartive.com/wp-content/uploads/2018/11/Logo-ITENAS-Institut-Teknologi-Nasional-Original.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"style="opacity: .8">
      <span class="brand-text font-weight-light"><b>Virtual-lab</b> Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ71Tc9Tk2q1eJUUlX1bXhWrc0-g8O9xnAplw&usqp=CAU" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link" data-toggle="push-menu" role="button">
                  <i class="nav-icon fa fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link" data-toggle="push-menu" role="button">
                    <i class="nav-icon fa fa-users"></i>
                <p>
                    Data User
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview" data-widget="tree">
                    <li class="nav-item">
                        <a href="{{route('user')}}" class="nav-link" data-toggle="push-menu" role="button">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('dosen')}}" class="nav-link" data-toggle="push-menu" role="button">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dosen</p>
                      </a>
                  </li>
                    <li class="nav-item">
                        <a href="{{route('mahasiswa')}}" class="nav-link" data-toggle="push-menu" role="button">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Mahasiswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('asisten')}}" class="nav-link" data-toggle="push-menu" role="button">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Asisten</p>
                      </a>
                  </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link" data-toggle="push-menu" role="button">
                    <i class="nav-icon fa fa-chalkboard-teacher"></i>
                <p>
                    Data Kelas
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('jurusan-admin')}}" class="nav-link" data-toggle="push-menu" role="button">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jurusan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('laboratorium')}}" class="nav-link" data-toggle="push-menu" role="button">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Laboratorium</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{route('rekrutmen')}}" class="nav-link" data-toggle="push-menu" role="button">
                    <i class="nav-icon fa fa-user-plus"></i>
                  <p>
                    Rekrutmen
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('Berita')}}" class="nav-link" data-toggle="push-menu" role="button">
                    <i class="nav-icon fa fa-newspaper"></i>
                  <p>
                    Berita/Informasi
                  </p>
                </a>
            </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>