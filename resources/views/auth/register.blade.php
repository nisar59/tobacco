@extends('layouts.auth_app')

@section('content')
    <div id="login-container" class="animation-fadeIn">
        <!-- Login Title -->
        <div class="login-title text-center">
            <h1><i class="gi gi-flash"></i> <strong>Tobacco</strong><br><small>Please <strong>Register</strong></small></h1>
        </div>
        <!-- END Login Title -->
        <div class="block push-bit">
            <!-- Register Form -->
            <form action="{{ route('register') }}" method="post" id="form-register" class="form-horizontal form-bordered form-control-borderless">
                @csrf
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            <input type="text" id="register-firstname" name="name" class="form-control input-lg @error('name') is-invalid @enderror" placeholder="FullName" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
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
                            <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                            <input type="email" id="register-email" name="email" class="form-control input-lg  @error('email') is-invalid @enderror" placeholder="Email"  value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
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
                            <input type="password" id="register-password" name="password" class="form-control input-lg  @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">

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
                            <input type="password" id="register-password-verify" name="password_confirmation" required autocomplete="new-password" class="form-control input-lg" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-6">
                        <a href="#modal-terms" data-toggle="modal" class="register-terms">Terms</a>
                        <label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">
                            <input type="checkbox" id="register-terms" name="register-terms">
                            <span></span>
                        </label>
                    </div>
                    <div class="col-xs-6 text-right">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Register Account</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <small>Do you have an account?</small> <a href="{{ route('login') }}" id="link-register"><small>Login</small></a>
                    </div>
                </div>
            </form>
            <!-- END Register Form -->

            <!-- Footer -->
            <footer class="text-muted text-center">
                <small><a href="http://goo.gl/TDOSuC" target="_blank">&copy; Tobacco 1.0</a></small>
            </footer>
            <!-- END Footer -->
        </div>
    </div>
@endsection
