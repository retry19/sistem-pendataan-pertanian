<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', config('app.name'))</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed accent-blue">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-white">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="far fa-user"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <span class="dropdown-item dropdown-header">{{ auth()->user()->name }}</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('users.profile') }}" class="dropdown-item">
              <i class="fas fa-cog mr-2"></i> Edit Profil
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('auth.logout') }}" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Keluar
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-blue elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link navbar-dark">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <nav class="mt-3">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link @if(request()->is('dashboard')) active @endif">
                <i class="nav-icon fas fa-columns"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-header">DATA</li>
            <li class="nav-item has-treeview @if(request()->is('peternakan*')) menu-open @endif">
              <a href="" class="nav-link @if(request()->is('peternakan*')) active @endif">
                <i class="nav-icon fas fa-book"></i>
                <p>Peternakan <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('populasi-hewan.index') }}" class="nav-link @if(request()->is('peternakan/populasi-hewan*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Populasi</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link @if(request()->is('kepemilikan-lahan')) active @endif">
                <i class="nav-icon fas fa-book"></i>
                <p>Kepemilikan Lahan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link @if(request()->is('kepemilikan-hewan')) active @endif">
                <i class="nav-icon fas fa-book"></i>
                <p>Kepemilikan Hewan</p>
              </a>
            </li>

            <li class="nav-header">LIST</li>
            <li class="nav-item">
              <a href="" class="nav-link @if(request()->is('tanaman')) active @endif">
                <i class="nav-icon fas fa-seedling"></i>
                <p>Tanaman</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('hewan.index') }}" class="nav-link @if(request()->is('hewan')) active @endif">
                <i class="nav-icon fas fa-paw"></i>
                <p>Hewan</p>
              </a>
            </li>

            <li class="nav-header">PENGATURAN</li>
            <li class="nav-item">
              <a href="{{ route('quarters.index') }}" class="nav-link @if(request()->is('kuartal')) active @endif">
                <i class="nav-icon fas fa-swatchbook"></i>
                <p>Kuartal</p>
              </a>
            </li>
            <li class="nav-item has-treeview @if(request()->is('roles*') || request()->is('permissions*')) menu-open @endif">
              <a href="" class="nav-link @if(request()->is('roles*') || request()->is('permissions*')) active @endif">
                <i class="nav-icon fas fa-key"></i>
                <p>Role & Permissions <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('roles.index') }}" class="nav-link @if(request()->is('roles')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Role</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('permissions.index') }}" class="nav-link @if(request()->is('permissions')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Permission</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Kelola Akun</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">@yield('heading')</h1>
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

      <section class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </section>
    </div>

    <footer class="main-footer text-sm">
      <strong>Copyright &copy; 2020</strong>
      Kelompok 13 KP
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>

  </div>

  <div class="wrapper-loading" id="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script>$(window).bind("load", function() { $('#loader').fadeOut(); });</script>
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script>$.widget.bridge('uibutton', $.ui.button)</script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/app.js?v=0.1') }}"></script>
  @yield('js')
</body>
</html>
