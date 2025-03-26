<!DOCTYPE html>
<html>
<head>
    @include('admin.all.head')
    @include('admin.all.styles')
    @livewireStyles
    @livewireScripts
    @php($route = Route::currentRouteName())
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@php($route = Route::currentRouteName())
<div class="wrapper">

  <!-- Navbar -->
  @include('admin.all.topbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.all.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('title')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('admin.all.session_message')
                    @yield('content')
                </div>
            </div>
        </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

@include('admin.all.scripts')
@stack('scripts')
</body>
</html>
