@extends('layouts.auth_app')

@section('content')
    <!-- Login Container -->
    <div id="login-container" class="animation-fadeIn">
        <!-- Login Title -->
        <div class="login-title text-center">
            <h1><i class="gi gi-flash"></i> <strong>Tobacco</strong><br><small>Please <strong>Login</strong></small></h1>
        </div>
        <!-- END Login Title -->

        <!-- Login Block -->
        <div class="block push-bit">
            <!-- Login Form -->
            <form action="{{ route('login') }}" method="post" id="form-login" class="form-horizontal form-bordered form-control-borderless">
                @csrf
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                            <input type="email" id="login-email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control input-lg  @error('email') is-invalid @enderror" placeholder="Email">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                            <input type="password" id="password" name="password" required autocomplete="current-password" class="form-control input-lg" placeholder="Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-4">
                        <label class="switch switch-primary" data-toggle="tooltip" title="Remember Me?">
                            <input type="checkbox" id="login-remember-me" name="remember" checked>
                            <span></span>
                        </label>
                    </div>
                    <div class="col-xs-8 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login to Dashboard</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        {{--<a href="{{ route('password.request') }}" id="link-reminder-login"><small>Forgot password?</small></a> ---}}
                        <a href="{{ route('register') }}" id="link-register-login"><small>Create a new account</small></a>
                    </div>
                </div>
            </form>
            <!-- END Login Form -->

            <!-- Footer -->
            <footer class="text-muted text-center">
                <small><a href="http://goo.gl/TDOSuC" target="_blank">&copy; Tobacco 1.0</a></small>
            </footer>
            <!-- END Footer -->

        </div>
        <!-- END Login Block -->
    </div>
    <!-- END Login Container -->
@endsection
