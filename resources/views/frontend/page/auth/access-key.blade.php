<?php
$rateLimit = Illuminate\Support\Facades\RateLimiter::tooManyAttempts(request()->ip(), 3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Siddhamahayog Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="{{ site_settings('logo') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/animate/animate.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vassets/login/vendor/css-hamburgers/hamburgers.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/animsition/css/animsition.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/login/css/util.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/login/css/main.css') }}" />
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url({{ asset('assets/login/images/login-background.png') }})">
            <div class="wrap-login100 p-l-110 p-r-110 p-b-33">
                <div class="d-flex justify-content-center">
                    <a href="/">
                        <img src='{{ site_settings("logo") }}' class="text-center" />
                    </a>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 border-bottom" style="border-bottom:2px solid #ccc; padding-bottom:10px;">
                        <h4 class="text-center p-b-20 border-bottom w-100">Mahayogi Siddhababa Spiritual Academy </h4>
                        <h5 class="text-center text-info">
                            SSO LIVE PROGRAM
                        </h5>
                    </div>
                </div>
                <x-alert></x-alert>

                @if( ! $rateLimit)

                <form id="accessCode" class="validate-form" action="{{ route('access_key_store') }}" method="post">
                    @csrf
                    @google_captcha()
                    <div class="p-t-31 p-b-9">
                        <span class="txt1"> Access Code </span>
                    </div>
                    <div class="wrap-input100  validate-input " data-validate="Access Code is Required" required="true">
                        <input class="input100" type="text" name="access_code" id="access_code" autofocus="true" />
                        <span class="focus-input100"></span>

                        @error('access_code')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="container-login100-form-btn m-t-17">
                        <button type="submit" class="login100-form-btn">Validate Key</button>
                    </div>
                </form>
                <div class="d-flex justify-content-center pt-4 mt-4 text-secondary p-b-20"> Don't Have account ?</div>
                <div class="w-full text-center">
                    <a href="{{ route('register') }}" class=" btn btn-danger w-100 text-white py-3"> Sign up now </a>
                </div>
                <div class="row mt-4">

                    <div class="col-md-12">
                        <form action="{{ route('login') }}" id="specialPermission" method="get">
                            <button type="submit" class="w-100 btn btn-info  py-3 px-5 m-b-20">
                                <i class="fa fas fa-key"></i>
                                Login
                            </button>
                        </form>

                    </div>

                    <div class="col-md-12">
                        <form class="w-100" action="{{ route('social_login_redirect',['facebook']) }}" id="facebookForm" method="post">
                            @csrf
                            <button type="submit" class="w-100 btn btn-outline-primary px-5 py-3 m-b-20 px-4">
                                <i class="fa fa-facebook-official text-lg"></i>
                                Sign In Using Facebook
                            </button>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <form action="{{ route('social_login_redirect_google') }}" id="googleForm" method="post">
                            @csrf
                            <button type="submit" class="w-100 btn btn-outline-danger py-2 px-5 m-b-20">
                                <img src="{{ asset ('assets/login/images/icons/icon-google.png') }}" alt="GOOGLE" />
                                Sign In Using Google
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-danger">
                    Too many invalid login attempt. Please try again after few minutes
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="{{ asset ('assets/login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/login/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset ('assets/login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/login/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/login/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset ('assets/login/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/login/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.google.site_key') }}"></script>
    <script src="{{ asset ('assets/login/js/main.js') }}"></script>

</body>

</html>