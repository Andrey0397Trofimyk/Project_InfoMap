<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Page | InfoMap</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icon page -->
    <link rel="shortcut icon" href="https://lh6.googleusercontent.com/proxy/ojkdtfNDmLGs6YUqSUz9Xt5paZ5jXBaArA6ypqZoIgU-IgH6sRAEIuFJvZ8iyZybIJyP6WQkRyobbyeU7ExA0zrL6dGDeASzaKtuIP0" type="image/png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/js/adminPlugins/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/js/adminPlugins/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/admin/app-admin.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id='warder'>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    </ul>
    <!-- Exit to basic -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                        {{ __('Вихід') }}
        <i class='fas fa-sign-out-alt'></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
    </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
    <img src="/js/adminPlugins/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Page</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" id='treeview' data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <!-- <li class="nav-item">
                    <a href="../widgets.html" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                    Widgets
                    <span class="right badge badge-danger">New</span>
                    </p>
                    </a>
                </!--> -->
                <li class='nav-item'>
                    <router-link 
                    class='nav-link active' 
                    :to="{ name: 'map' }">
                        <i class="nav-icon fas fa-atlas"></i>   
                        <p>Головна</p>
                    </router-link >
                </li>
                <list-component
                :locations ='{{$locations->select("id","title")->get()}}'
                :new-title = 'newTitle'
                :update-title = 'updateTitle'
                :remove-location = 'locationId'
                @openlocation='insertLocations'
                ></list-component>
                <!-- :new-location = 'locationNew' -->
                <li class='nav-item'>
                    <router-link class='nav-link' :to="{ name: 'newLocation' }">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>Створити</p>
                    </router-link>                
                </li>
            </ul>
        </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
    <!-- Content page -->
    <!-- @yield('content') -->
    <router-view
    :info-location='locationInfo'
    :images ='images'
    :comments ='comments'
    @newlocation = 'addNewLocation($event)'
    @updatelocation = 'updateLocation($event)'
    @openlocation = 'insertLocations($event)'
    @removeloc='removeLocation($event)'
    >
    </router-view>

<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/js/adminPlugins/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/js/adminPlugins/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/js/adminPlugins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/js/adminPlugins/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/js/adminPlugins/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- <script src="/js/adminPlugins/plugins/jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="/js/adminPlugins/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart -->
<script src="/js/adminPlugins/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/js/adminPlugins/plugins/moment/moment.min.js"></script>
<script src="/js/adminPlugins/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/js/adminPlugins/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/js/adminPlugins/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/js/adminPlugins/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminPlugins/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="/js/adminPlugins/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="/js/adminPlugins/dist/js/demo.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
