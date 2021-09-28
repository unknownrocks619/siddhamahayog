@extends('layouts.admin')
    @section('title')
        Authentication Required !!
    @endSection()

    @section('page_css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/pages/authentication.css') }}">
        <!-- END: Page CSS-->
    @endSection()

    @section('content')
        <section id="auth-login" class="row flexbox-container">
            <div class="col-xl-8 col-11">
                <div class="card bg-authentication mb-0">
                    <div class="row m-0">
                        <!-- left section-login -->
                        <div class="col-md-6 col-12 px-0">
                            <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                <div class="card-header pb-1">
                                    <div class="card-title">
                                        <h4 class="text-center mb-2 text-danger">STOP, Authentication Required!</h4>
                                    </div>
                                </div>
                                <div class="card-body" id='login_box'>
                                    <x-alert></x-alert>
                                    <form action="{{ route('center_user_login_post') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name='route' value="center" />
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="email_address">Email address</label>
                                            <input type="email" name="email_address" class="form-control" id="email_address"
                                                placeholder="Email address" value="{{ old('email_address') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-bold-600" for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Password">
                                        </div>
                                        <div
                                            class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                            <div class="text-left">
                                                
                                            </div>
                                            <div class="text-right"><a href="#"
                                                    class="card-link" id='forgot_password' ><small>Forgot Password?</small></a></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary glow w-100 position-relative">Login<i
                                                id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                    </form>
                                </div>
                                <div class="card-body" id="forgot_password_box" style="display:none">
                                    <x-alert></x-alert>
                                    <form action="" method="POST">
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="forgot_email_address">Email address</label>
                                            <input type="email" name="email_address" class="form-control" id="forgot_email_address"
                                                placeholder="Email address" value="{{ old('email_address') }}" />
                                        </div>
                                        <div
                                            class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                            
                                            <div class="text-right"><a href="#"
                                                    class="card-link" id='login_link' ><small>I remembered my password</small></a></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary glow w-100 position-relative">Forgot Password<i
                                                id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- right section image -->
                        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                            <img class="img-fluid" src="{{ asset ('admin/app-assets/images/pages/gurudev_login.jpeg') }}" alt="branding logo">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endSection()
    @section('page_js')
        <script>
            $(document).ready(function() {
                online = window.navigator.onLine;
                if( online === false)
                {
                    $("#forgot_password").hide();
                }

                if (online === true)
                {
                    $("#forgot_password").click(function(){
                        $("#login_box").fadeOut('slow',function() {
                            $("#forgot_password_box").fadeIn('fast');
                        })
                    })
                }

                if( online === true )
                {
                    $("#login_link").click(function (){
                        $("#forgot_password_box").fadeOut('slow',function (){
                            $("#login_box").fadeIn('fast');
                        })
                    })
                }
            })

        </script>
    @endSection()
