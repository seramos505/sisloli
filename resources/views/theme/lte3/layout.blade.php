<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Loli') | Sistema Loli</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/sweetalert2/sweetalert2.min.css")}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/toastr/toastr.min.css")}}">
    <!-- Select2 -->    
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/select2/css/select2.min.css")}}">
    
    <!-- OPTIONAL CSS -->
    @yield("css-optional")
    
    <!-- Theme style -->    
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.css")}}">

    <link rel="stylesheet" href="{{asset("assets/$theme/custom.css")}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        <!-- Inicio Header -->
        @include("theme/$theme/header")
        <!-- Fin Header -->
        <!-- Inicio Aside -->
        @include("theme/$theme/aside")
        <!-- Fin Aside -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@yield('header')</h1>
                    </div><!-- /.col -->                    
                </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
          <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <section class="container-fluid">
                    @yield('contenido')
                </section>
                <!-- /.container-fluid -->
          </div>
          <!-- /.content -->
        </div>
        <!--Inicio Footer -->
        @include("theme/$theme/footer")
        <!-- Fin Footer -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset("assets/$theme/plugins/jquery/jquery.min.js")}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- SweetAlert2 -->
    <script src="{{asset("assets/$theme/plugins/sweetalert2/sweetalert2.min.js")}}"></script>    
    <!-- Toastr -->
    <script src="{{asset("assets/$theme/plugins/toastr/toastr.min.js")}}"></script>
    <!-- moment -->
    <script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
    <script src="{{asset("assets/$theme/plugins/moment/locale/es.js")}}"></script>
    
    <!-- AdminLTE -->
    <script src="{{asset("assets/$theme/dist/js/adminlte.js")}}"></script>
    <script src="{{asset("assets/js/scripts.js")}}"></script>

    <!-- CONSULTAR TODOS LOS PERMISOS QUE TIENE EL USUARIO -->
    <script>
        @auth
            window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
            console.log(window.Permissions);
        @else
            window.Permissions = [];
        @endauth
    </script>
    <!-- OPTIONAL SCRIPTS -->


    <!-- SCRIPTS -->
    <script src="js/app.js"></script>
    <!-- Select2 -->
    <script src="{{asset("assets/$theme/plugins/select2/js/select2.full.min.js")}}"></script>
    

    @yield("scripts")
</body>
</html>