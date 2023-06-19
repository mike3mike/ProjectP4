  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LOTUS</title>

  </head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">

  <body>
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">

          </ul>

          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
              {{-- <!-- Navbar Search -->
          <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="fas fa-search"></i>
              </a>
              <div class="navbar-search-block">
                  <form class="form-inline">
                      <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                          <div class="input-group-append">
                              <button class="btn btn-navbar" type="submit">
                                  <i class="fas fa-search"></i>
                              </button>
                              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                  <i class="fas fa-times"></i>
                              </button>
                          </div>
                      </div>
                  </form>
              </div>

          </li> --}}


              <!-- Notifications Dropdown Menu -->
              {{-- <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
      
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
          </li> --}}
              <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="far fa-user"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                      <a href="#" class="dropdown-item">
                          bekijk profiel
                      </a>
                      <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
                          uitloggen
                      </a>

                  </div>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </li>

          </ul>
      </nav>
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- Brand Logo -->
          <a href="index3.html" class="brand-link">
              <img src="https://lotuskringhwg.nl/wp-content/uploads/2020/09/cropped-logo-192x192.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8 ">
              <span class="brand-text font-weight-light">LOTUS</span>
          </a>

          <!-- Sidebar -->
          <div class="sidebar">


              <!-- Sidebar Menu -->
              <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                      @if(Auth::user()->hasRole('coordinator') AND Auth::user()->where('is_approved_coordinator', true)->exists() )

                      <li class="nav-item menu-open">
                          <a href="" class="nav-link ">
                              <p>
                                  Coordinator
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item menu-open">

                                  <a class="nav-link ">
                                      <p>
                                          Opdrachten
                                          <i class="right fas fa-angle-left"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/admin/tasks" class="nav-link ">
                                              <p>Beheren</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">

                                      <li class="nav-item">
                                          <a href="/admin/new-assignments" class="nav-link">
                                              <p>aanvragen zien</p>
                                          </a>
                                      </li>
                                  </ul>

                              </li>
                          </ul>


                          <ul class="nav nav-treeview">
                              <li class="nav-item menu-open">
                                  <a href="" class="nav-link ">
                                      <p>
                                          gebruikers
                                          <i class="right fas fa-angle-left"></i>
                                      </p>

                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/admin/role-requests" class="nav-link ">
                                              <p>Rol aanvragen</p>
                                          </a>
                                      </li>



                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/admin/approvals" class="nav-link ">
                                              <p>Account aanvragen</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/admin/members" class="nav-link ">
                                              <p>beheren</p>
                                          </a>
                                      </li>
                                  </ul>


                              </li>
                          </ul>

                      </li>

                      @endif


                      @if(Auth::user()->hasRole('lid') AND Auth::user()->where('is_approved_member', true)->exists() )
                      <li class="nav-item menu-open">
                          <a class="nav-link ">
                              <p>
                                  Lid
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">

                              <li class="nav-item menu-open">
                                  <a class="nav-link ">
                                      <p>
                                          Opdrachten
                                          <i class="right fas fa-angle-left"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/member/open-assignments" class="nav-link">
                                              <p>Openstaande opdrachten</p>
                                          </a>
                                      </li>



                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/member/accepted-assignments" class="nav-link">
                                              <p>Geaccepteerde opdrachten</p>
                                          </a>
                                      </li>



                                  </ul>
                              </li>
                          </ul>
                      </li>
                      @endif
                      @if(Auth::user()->hasRole('opdrachtgever') AND Auth::user()->where('is_approved_client', true)->exists() )
                      <li class="nav-item menu-open">
                          <a class="nav-link ">
                              <p>

                                  Opdrachtgever
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">

                              <li class="nav-item menu-open">
                                  <a class="nav-link ">
                                      <p>

                                          Opdrachten
                                          <i class="right fas fa-angle-left"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/client/task" class="nav-link">
                                              <p>Overzicht</p>
                                          </a>
                                      </li>



                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/client/task/create" class="nav-link">
                                              <p>Aanmaken</p>
                                          </a>
                                      </li>



                                  </ul>
                              </li>
                          </ul>
                      </li>
                      @endif

              </nav>
              <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1 class="m-0">Dashboard</h1>
                      </div><!-- /.col -->

                  </div><!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  @yield('content')
              </div>
              <!-- /.card -->
          </section>
          <!-- right col -->
      </div>
      <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
      </div>
      <!-- jQuery -->
      <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
          $.widget.bridge('uibutton', $.ui.button)
      </script>
      <!-- Bootstrap 4 -->
      <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <!-- ChartJS -->
      <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
      <!-- Sparkline -->
      <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
      <!-- JQVMap -->
      <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
      <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
      <!-- jQuery Knob Chart -->
      <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
      <!-- daterangepicker -->
      <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
      <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
      <!-- Summernote -->
      <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
      <!-- overlayScrollbars -->
      <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
      <!-- AdminLTE App -->
      <script src="{{asset('dist/js/adminlte.js')}}"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="{{asset('dist/js/demo.js')}}"></script>
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
      @yield('scripts')
  </body>

  </html>