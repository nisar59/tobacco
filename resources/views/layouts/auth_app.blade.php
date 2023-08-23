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

    <title>{{ config('app.name', 'Tobacco') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
</head>
<body>
<!-- Login Background -->
<div id="login-background">
    <!-- For best results use an image with a resolution of 2560x400 pixels (prefer a blurred image for smaller file size) -->
    <img src="{{ asset('backend/img/placeholders/headers/login_header.jpg') }}" alt="Login Background" class="animation-pulseSlow">
</div>
<!-- END Login Background -->
    @yield('content')
<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

<div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Settings</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="index.html" method="post" enctype="multipart/form-data"
                      class="form-horizontal form-bordered" onsubmit="return false;">
                    <fieldset>
                        <legend>Vital Info</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Username</label>
                            <div class="col-md-8">
                                <p class="form-control-static">Admin</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-email">Email</label>
                            <div class="col-md-8">
                                <input type="email" id="user-settings-email" name="user-settings-email"
                                       class="form-control" value="admin@example.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-notifications">Email
                                Notifications</label>
                            <div class="col-md-8">
                                <label class="switch switch-primary">
                                    <input type="checkbox" id="user-settings-notifications"
                                           name="user-settings-notifications" value="1" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Password Update</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-password">New Password</label>
                            <div class="col-md-8">
                                <input type="password" id="user-settings-password" name="user-settings-password"
                                       class="form-control" placeholder="Please choose a complex one..">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-repassword">Confirm New
                                Password</label>
                            <div class="col-md-8">
                                <input type="password" id="user-settings-repassword" name="user-settings-repassword"
                                       class="form-control" placeholder="..and confirm it!">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<script src="{{ asset('backend/js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset('backend/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins.js') }}"></script>
<script src="{{ asset('backend/js/app.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key="></script>
<script src="{{ asset('backend/js/helpers/gmaps.min.js') }}"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="{{ asset('backend/js/pages/index2.js') }}"></script>

<script>$(function () {
        Index2.init();
    });</script>
</body>
</html>
