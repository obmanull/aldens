<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>srtdash - ICO Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/images/icon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/slicknav.min.css') }}">
    <!-- amchart css -->
    <link rel="stylesheet" href="{{ asset('admin/export/export.css') }}" type="text/css" media="all"/>
    <!-- others css -->
    <link rel="stylesheet" href="{{ asset('admin/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/default-css.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/responsive.css') }}">
    <!-- modernizr css -->
    <script src="{{ asset('admin/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<!-- preloader area end -->
<!-- page container area start -->
<div class="page-container">
    <!-- sidebar menu area start -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('admin/images/icon/logo.png') }}"
                                                              alt="logo"></a>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li><a href="{{ route('admin.dashboard') }}"><i class="ti-dashboard"></i> <span>dashboard</span></a>
                        </li>
                        <li><a href="{{ route('admin.users.index') }}"><i class="ti-user"></i> <span>Users</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- sidebar menu area end -->
    <!-- main content area start -->
    <div class="main-content">
        <!-- header area start -->
        <div class="header-area">
            <div class="row align-items-center">
                <!-- nav and search button -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <!-- profile info & task notification -->
                <div class="col-md-6 col-sm-4 clearfix">
                    <ul class="notification-area pull-right">
                        <li id="full-view"><i class="ti-fullscreen"></i></li>
                        <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <label for="logout-btn"><i class="fa fa-sign-out" aria-hidden="true"></i></label>
                                <button id="logout-btn" class="d-none"></button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- header area end -->
        <!-- page title area start -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6 py-3">
                    @section('breadcrumbs')
                        {{ Breadcrumbs::render() }}
                    @endsection
                    @yield('breadcrumbs')
                </div>
            </div>
        </div>
        <!-- page title area end -->
        <div class="main-content-inner">
            <!-- sales report area start -->
            <div class="sales-report-area mt-5 mb-5">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- main content area end -->
    <!-- footer area start-->
    <footer>
        <div class="footer-area">
            <p>© Copyright 2019. All right reserved.</p>
        </div>
    </footer>
    <!-- footer area end-->
</div>
<!-- jquery latest version -->
<script src="{{ asset('admin/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{ asset('admin/js/popper.min.js')}}"></script>
<script src="{{ asset('admin/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('admin/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('admin/js/metisMenu.min.js')}}"></script>
<script src="{{ asset('admin/js/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('admin/js/jquery.slicknav.min.js')}}"></script>

<!-- start chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- start highcharts js -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- start zingchart js -->
<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
<script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
</script>
<!-- all line chart activation -->
<script src="{{ asset('admin/js/line-chart.js') }}"></script>
{{--<!-- all pie chart -->--}}
<script src="{{ asset('admin/js/pie-chart.js') }}"></script>
{{--<!-- others plugins -->--}}
<script src="{{ asset('admin/js/plugins.js') }}"></script>
<script src="{{ asset('admin/js/scripts.js') }}"></script>
</body>

</html>
