<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tobacco is providing some different version of tobacco business.">
    <meta name="author" content="Tobacco">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tobacco</title>
    @if(!str_contains(Request::url(), 'config/index/flavour'))
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/custom_app.css') }}" rel="stylesheet">

    <!-- START Icons -->
    <link rel="shortcut icon" href="{{ asset('backend/icons/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon57.png') }}" sizes="57x57">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon72.png') }}" sizes="72x72">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon114.png') }}" sizes="114x114">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon144.png') }}" sizes="144x144">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon152.png') }}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/icon180.png') }}" sizes="180x180">
    <!-- END Icons -->

    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/themes.css') }}">
    <script src="{{ asset('backend/js/vendor/modernizr.min.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <link rel="stylesheet" href="{{asset('izitoast/css/iziToast.min.css')}}">
    @yield('styles')
</head>
<body>
<div id="page-wrapper">
    <!-- Preloader -->
    <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
    <!-- Used only if page preloader is enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
    <div class="preloader themed-background">
        <h1 class="push-top-bottom text-light text-center"><strong>Toba</strong>cco</h1>
        <div class="inner">
            <h3 class="text-light visible-lt-ie10"><strong>Loading..</strong></h3>
            <div class="preloader-spinner hidden-lt-ie10"></div>
        </div>
    </div>

    <div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">

        <!-- Main Sidebar -->
        <div id="sidebar">
            <!-- Wrapper for scrolling functionality -->
            <div id="sidebar-scroll">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Brand -->
                    <a href="{{url('/')}}" class="sidebar-brand">
                        <i class="gi gi-flash"></i>
                        <span class="sidebar-nav-mini-hide"><strong>Tobacco</strong></span>
                    </a>
                    <!-- END Brand -->
                    <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                        <div class="sidebar-user-avatar">
                            <a href="{{url('/')}}">
                                <img src="{{ asset('backend/icons/35568.png') }}"
                                     alt="avatar">
                            </a>
                        </div>
                        <div class="sidebar-user-name"><a href="{{url('/')}}">{{ Auth::user()->name }}</a></div>
                    </div>

                    <!-- Sidebar Navigation -->
                    <ul class="sidebar-nav">
                        <li class="">
                            <a href="{{url('/')}}">
                                <i class="fa fa-home sidebar-nav-icon"></i>
                                <span class="sidebar-nav-mini-hide">Home</span>
                            </a>
                        </li>

                        @canany(['configuration.view','product.view'])
                        <li class="sidebar-header">
                                <span class="sidebar-header-options clearfix">
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title="Create and manage configuration">
                                              <img  height="18px" src="{{ asset('navicons/configure.png') }}"
                                                   alt="cog">
                                        {{--<i class="fa fa-cog"></i>--}}
                                    </a>
                                </span>
                            <span class="sidebar-header-title">Configurations</span>
                        </li>
                        <li class="{{ (strpos(Request::url(), 'config') || strpos(Request::url(), 'product')) ? 'active' : '' }}">
                            <a href="#" class="sidebar-nav-menu">
                                <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                                {{--<i class="gi gi-settings sidebar-nav-icon"></i>--}}
                                <img height="18px" src="{{ asset('navicons/configure.png') }}"
                                     alt="cog">&nbsp;&nbsp;
                                <span class="sidebar-nav-mini-hide">Configurations</span>
                            </a>
                            <ul>
                                @php
                                    $configTypes = \App\Helpers\GeneralHelper::getConfigList();
                                @endphp
                                @foreach($configTypes as $key=>$types)
                                    @php
                                        if($types == 'Products'){
                                           $addPermission = 'product.view';
                                            $url = url('/product/index');
                                        }else{
                                            $addPermission = 'configuration.view';
                                            $url = url('config/index/'.$key);
                                        }
                                    @endphp
                                    @can($addPermission)
                                        <li>
                                            <a href="{{$url}}">
                                                <img height="13px" src="{{ asset('navicons/configure.png') }}"
                                                     alt="cog">&nbsp;&nbsp;
                                                {{--<i class="fa fa-cog sidebar-nav-icon"></i>--}}
                                                <span class="sidebar-nav-mini-hide">{{$types}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endforeach

                            </ul>
                        </li>
                        @endcanany
                        @canany(['user.view','permissions.view'])
                        <li class="sidebar-header">
                                <span class="sidebar-header-options clearfix">
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title="Create and manage configuration">
                                        {{--<i class="fa fa-user"></i>--}}
                                        <img height="18px" src="{{ asset('navicons/users.png') }}"
                                             alt="cog">&nbsp;&nbsp;
                                    </a>
                                </span>
                            <span class="sidebar-header-title">Permissions</span>
                        </li>
                        @can('permissions.view')
                            <li>
                                <a href="{{url('roles')}}">
                                    {{--<i class="fa fa-users sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/roles.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Roles</span>
                                </a>
                            </li>
                        @endcan
                        @can('user.view')
                            <li>
                                <a href="{{url('users')}}">
                                    {{--<i class="fa fa-users sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/users.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Users</span>
                                </a>
                            </li>
                        @endcan
                        @endcanany
                        @canany(['purchases.view','supplier.view','returns.purchase'])
                        <li class="sidebar-header">
                            <span class="sidebar-header-options clearfix">
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title="Create and manage purchases, sales and inventory!">
                                    {{--<i class="fa fa-shopping-cart"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/purchases-1.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                </a>
                            </span>
                            <span class="sidebar-header-title">Purchases</span>
                        </li>
                        @can('supplier.view')
                            <li>
                                <a href="{{url('supplier/index')}}">
                                    {{--<i class="fa fa-industry sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/suppliers.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Suppliers</span></a>
                            </li>
                        @endcan
                        @can('purchases.view')
                            <li>
                                <a href="{{url('purchase/index')}}">
                                    {{--<i class="fa fa-shopping-cart sidebar-nav-icon"></i>--}}

                                    <img height="18px" src="{{ asset('navicons/purchases.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Purchases</span></a>
                            </li>
                        @endcan
                        @can('returns.purchase')
                            <li>
                                <a href="{{url('purchasereturns/index')}}">
                                    {{--<i class="fa fa-shopping-cart sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/return.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Returns</span></a>
                            </li>
                        @endcan
                        @endcanany
                        @canany(['sales.view','customer.view','returns.sale'])
                        <li class="sidebar-header">
                            <span class="sidebar-header-options clearfix">
                                <a href="javascript:void(0)" data-toggle="tooltip" title=""
                                   data-original-title="Create the most amazing pages with the widget kit!">
                                    {{--<i class="fa fa-tag"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/sales-2.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                </a>
                            </span>
                            <span class="sidebar-header-title">Sales</span>
                        </li>
                        @can('customer.view')
                            <li>
                                <a href="{{url('customer/index')}}">
                                    {{--<i class="fa fa-user sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/customers.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Customers</span>
                                </a>
                            </li>
                        @endcan
                        @can('sales.view')
                            <li>
                                <a href="{{url('sales/index')}}">
                                    {{--<i class="fa fa-tag sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/sales.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Sales</span>
                                </a>
                            </li>
                        @endcan
                        @can('returns.sale')
                            <li>
                                <a href="{{url('salesreturns/index')}}">
                                    {{--<i class="fa fa-shopping-cart sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/return.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Returns</span></a>
                            </li>
                        @endcan
                        @endcanany
                        @canany(['cash.view','expense.view','reports.view'])
                        <li class="sidebar-header">
                            <span class="sidebar-header-options clearfix">
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title="Create and manage purchases, sales and inventory!">
                                    {{--<i class="fa fa-money"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/Cash.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                </a>
                            </span>
                            <span class="sidebar-header-title">Financial's</span>
                        </li>
                        @can('cash.view')
                            <li>
                                <a href="{{url('cash/index')}}">
                                    {{--<i class="fa fa-money sidebar-nav-icon"></i>--}}
                                    <img height="16px" src="{{ asset('navicons/cash-input.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Cash Input</span></a>
                            </li>
                        @endcan
                        @can('purchases.payable')
                            <li>
                                <a href="{{url('purchase/payable')}}">
                                    {{--<i class="fa fa-cc-amex sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/add-payment.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Add Payments</span></a>
                            </li>
                        @endcan
                        @can('sales.receivable')
                            <li>
                                <a href="{{url('sales/receivable')}}">
                                    {{--<i class="fa fa-hand-holding-usd sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/add-receipts.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Add Receipts</span></a>
                            </li>
                        @endcan
                        @can('expense.view')
                            <li>
                                <a href="{{url('expense/index')}}">
                                    {{--<i class="fa fa-money sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/add-expense.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Add Expense</span></a>
                            </li>
                        @endcan
                        @can('reports.cash_flow')
                            <li>
                                <a href="{{url('report/profit/loss')}}">
                                    {{--<i class="fa fa-money sidebar-nav-icon"></i>--}}
                                    <img height="18px" src="{{ asset('navicons/Cash-flow.png') }}"
                                         alt="cog">&nbsp;&nbsp;
                                    <span class="sidebar-nav-mini-hide">Cash Flow</span></a>
                            </li>
                        @endcan
                        @endcanany
                    </ul>
                    <!-- END Sidebar Navigation -->
                </div>
                <!-- END Sidebar Content -->
            </div>
            <!-- END Wrapper for scrolling functionality -->
        </div>
        <!-- END Main Sidebar -->

        <!-- Main Container -->
        <div id="main-container">

            <header class="navbar navbar-default">
                <!-- Left Header Navigation -->
                <ul class="nav navbar-nav-custom">
                    <!-- Main Sidebar Toggle Button -->
                    <li>
                        <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                            <i class="fa fa-bars fa-fw"></i>
                        </a>
                    </li>
                    <!-- END Main Sidebar Toggle Button -->

                    <!-- Template Options -->
                    <!-- Change Options functionality can be found in js/app.js - templateOptions() -->
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="gi gi-settings"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-custom dropdown-options">
                            <li class="dropdown-header text-center">Header Style</li>
                            <li>
                                <div class="btn-group btn-group-justified btn-group-sm">
                                    <a href="javascript:void(0)" class="btn btn-primary active"
                                       id="options-header-default">Light</a>
                                    <a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse">Dark</a>
                                </div>
                            </li>
                            <li class="dropdown-header text-center">Page Style</li>
                            <li>
                                <div class="btn-group btn-group-justified btn-group-sm">
                                    <a href="javascript:void(0)" class="btn btn-primary active" id="options-main-style">Default</a>
                                    <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt">Alternative</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- END Template Options -->
                </ul>
                <!-- END Left Header Navigation -->
                <!-- Search Form -->
                {{--<form action="javascript:void(0)" method="post" class="navbar-form-custom">--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" id="top-search" name="top-search" class="form-control"--}}
                               {{--placeholder="Search..">--}}
                    {{--</div>--}}
                {{--</form>--}}

                <!-- Right Header Navigation -->
                <ul class="nav navbar-nav-custom pull-right">
                    <!-- User Dropdown -->
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('backend/img/placeholders/avatars/smoker.png') }}" alt="avatar"> <i
                                    class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                            <li class="dropdown-header text-center">Account</li>
                            <li>
                                <a data-toggle="tooltip" data-placement="bottom" title="Logout"
                                   href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="gi gi-exit"></i> LogOut
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                    <!-- END User Dropdown -->
                </ul>

            </header>

            <!-- Page content -->
            <div id="page-content">
                @yield('content')
            </div>
            <!-- END Page Content -->

            <!-- Footer -->
            <footer class="clearfix">
                <div class="pull-right">
                    Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://goo.gl/vNS3I"
                                                                               target="_blank">Tobacco</a>
                </div>
                <div class="pull-left">
                    <span id="year-copy"></span> &copy; <a href="http://goo.gl/TDOSuC" target="_blank">Tobacco-1.0</a>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
</div>
<div id="mdl">
    @yield('mdl')
</div>
<script src="{{ asset('backend/js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset('backend/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins.js') }}"></script>
<script src="{{ asset('backend/js/app.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key="></script>
<script src="{{ asset('backend/js/helpers/gmaps.min.js') }}"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="{{ asset('backend/js/pages/index2.js') }}"></script>
<script src="{{ asset('backend/js/pages/ecomOrders.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4-4.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/fc-4.1.0/fh-3.2.4/r-2.3.0/sc-2.0.7/sb-1.3.4/datatables.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<script src="{{asset('izitoast/js/iziToast.min.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>


<script type="text/javascript">

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    error("{{$error}}", 'Input error');
    @endforeach
    @elseif (Session::has('warning'))
    warning("{{ Session::get('warning') }}");
    @elseif (Session::has('success'))
    success("{{ Session::get('success') }}");
    @elseif (Session::has('error'))
    error("{{ Session::get('error') }}");
    @elseif (Session::has('info'))
    info("{{ Session::get('info') }}");
    @elseif (isset($warning))
    warning("{{ $warning }}");
    @elseif (isset($success))
    success("{{ $success }}");
    @elseif (isset($error))
    error("{{ $error }}");
    @elseif (isset($info))
    info("{{ $info }}");
    @else
    @endif


</script>


<script>
    $(function () {
        Index2.init();
    });
    $(".sidebar-nav-menu a").on("click", function () {
        $(".sidebar-nav-menu").find(".active").removeClass("active");
        $(this).parent().addClass("active");
    });
</script>

@yield('script')
</body>
</html>
