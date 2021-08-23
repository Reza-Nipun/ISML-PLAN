<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Bill-Tracker').(isset($title) ? $title : '') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/min/dropzone.min.css') }}">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Favicon Start -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">
    <!-- Favicon End -->

    <style>
        .loader {
            border: 20px solid #f3f3f3;
            border-radius: 50%;
            border-top: 20px solid #3498db;
            width: 35px;
            height: 35px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" data-widget="navbar-search" href="#" role="button">--}}
                    {{--<i class="fas fa-search"></i>--}}
                {{--</a>--}}
                {{--<div class="navbar-search-block">--}}
                    {{--<form class="form-inline">--}}
                        {{--<div class="input-group input-group-sm">--}}
                            {{--<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
                            {{--<div class="input-group-append">--}}
                                {{--<button class="btn btn-navbar" type="submit">--}}
                                    {{--<i class="fas fa-search"></i>--}}
                                {{--</button>--}}
                                {{--<button class="btn btn-navbar" type="button" data-widget="navbar-search">--}}
                                    {{--<i class="fas fa-times"></i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</li>--}}

            <!-- Messages Dropdown Menu -->
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                    {{--<i class="far fa-comments"></i>--}}
                    {{--<span class="badge badge-danger navbar-badge">3</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<!-- Message Start -->--}}
                        {{--<div class="media">--}}
                            {{--<img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
                            {{--<div class="media-body">--}}
                                {{--<h3 class="dropdown-item-title">--}}
                                    {{--Brad Diesel--}}
                                    {{--<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
                                {{--</h3>--}}
                                {{--<p class="text-sm">Call me whenever you can...</p>--}}
                                {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Message End -->--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<!-- Message Start -->--}}
                        {{--<div class="media">--}}
                            {{--<img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                            {{--<div class="media-body">--}}
                                {{--<h3 class="dropdown-item-title">--}}
                                    {{--John Pierce--}}
                                    {{--<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
                                {{--</h3>--}}
                                {{--<p class="text-sm">I got your message bro</p>--}}
                                {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Message End -->--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<!-- Message Start -->--}}
                        {{--<div class="media">--}}
                            {{--<img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                            {{--<div class="media-body">--}}
                                {{--<h3 class="dropdown-item-title">--}}
                                    {{--Nora Silvester--}}
                                    {{--<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
                                {{--</h3>--}}
                                {{--<p class="text-sm">The subject goes here</p>--}}
                                {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Message End -->--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            <!-- Notifications Dropdown Menu -->
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                    {{--<i class="far fa-bell"></i>--}}
                    {{--<span class="badge badge-warning navbar-badge">15</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                    {{--<span class="dropdown-item dropdown-header">15 Notifications</span>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<i class="fas fa-envelope mr-2"></i> 4 new messages--}}
                        {{--<span class="float-right text-muted text-sm">3 mins</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<i class="fas fa-users mr-2"></i> 8 friend requests--}}
                        {{--<span class="float-right text-muted text-sm">12 hours</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<i class="fas fa-file mr-2"></i> 3 new reports--}}
                        {{--<span class="float-right text-muted text-sm">2 days</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" data-widget="fullscreen" href="#" role="button">--}}
                    {{--<i class="fas fa-expand-arrows-alt"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
                    {{--<i class="fas fa-th-large"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link text-center">
            {{--<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
            <span class="brand-text font-weight-light">
                {{ Auth::user()->name }}
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            {{--<div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
                {{--<div class="image">--}}
                    {{--<img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
                {{--</div>--}}
                {{--<div class="info">--}}
                    {{--<a href="#" class="d-block">Alexander Pierce</a>--}}
                {{--</div>--}}
            {{--</div>--}}

            <!-- SidebarSearch Form -->
            {{--<div class="form-inline">--}}
                {{--<div class="input-group" data-widget="sidebar-search">--}}
                    {{--<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">--}}
                    {{--<div class="input-group-append">--}}
                        {{--<button class="btn btn-sidebar">--}}
                            {{--<i class="fas fa-search fa-fw"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user nav-icon"></i>
                            <p>
                                Profile
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="far fa-circle nav-icon"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users-cog nav-icon"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user-type.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>User Types</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-store nav-icon"></i>
                            <p>
                                Plants
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('plant.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>Plants</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-crown nav-icon"></i>
                            <p>
                                Buyer
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('buyer.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>Buyer</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <p>
                                TNA
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('tna.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>TNA</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('po-tna.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>TNA Tasks</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-list-alt nav-icon"></i>
                            <p>
                                PO
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('po.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>PO List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>
                                Reports
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('shipment_summary') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>Shipment Summary</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shipment_forecast') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p>Shipment Forecast</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong><a href="http://www.viyellatexgroup.com/" target="_blank">VIYELLATEX GROUP</a> &copy; 2021</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard3.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- BS-Stepper -->
<script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD',
            allowInputToggle: true,
        });

        $('.reservationdate').datetimepicker({
            format: 'YYYY-MM-DD',
            allowInputToggle: true,
        });

        $('.reservationdate_2').datetimepicker({
            format: 'YYYY-MM-DD',
            allowInputToggle: true,
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('.reservationtime').daterangepicker({
//            timePicker: true,
//            timePickerIncrement: 30,
            locale: {
                format: 'YYYY-MM-DD'
            }
        })
        $('.reservationtime').val('');
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        bsCustomFileInput.init();
    });
</script>
</body>
</html>