<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/morris.js/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/jvectormap/jquery-jvectormap.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('dist/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/bower_components/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom2.css')}}">

    <link href="{{asset('jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet">
    <link href="{{asset('jquery-ui/jquery-ui.structure.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fullcalendar.print.min.css')}}" media="print">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- jQuery 3 -->
    <script src="{{asset('dist/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- datepicker -->
    <script src="{{asset('dist/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{-- Sweet alert javascript --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script>
        var baseUrl = '{{ url('/') }}/';
    </script>
    <style>
        .select2-container .select2-selection--single{
            height: 35px !important;
            padding: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 40px !important;
        }



        .navbar-custom-menu>.navbar-nav>li>.dropdown-menu{
            left: auto;
            width: 260px;
        }

        .navbar-nav>.user-menu>.dropdown-menu>.user-footer{
            padding: 7px !important;
        }

        .navbar-nav>.user-menu>.dropdown-menu>.user-footer{
            background-color: #ecf0f5;
        }

        .canvasjs-chart-credit{
            display: none;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" style="position: relative;">
        @include('layouts.header')
        @include('layouts.side_nav')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
            @include('layouts.footer')
            @include('layouts.right-side-nav')
    </div>
    
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('dist/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('dist/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="{{asset('dist/bower_components/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('dist/bower_components/morris.js/morris.min.js')}}"></script>
    <!-- Select2 -->

    <!-- DataTables -->
    <script src="{{asset('dist/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dist/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script src="{{asset('dist/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('dist/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{asset('dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('dist/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('dist/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('dist/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('dist/js/demo.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <!-- fullCalendar -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.min.js') }}"></script>

    @yield('script')
</body>
</html>
