<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Himalayan Siddhamahayog Spiritual Academy">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config("app.name","Siddhamahayog Sadhak Portal") }}
        @yield("page_title")
    </title>
    <link rel="stylesheet" href="{{ asset ('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    @yield("top_css")
    <link rel="stylesheet" href="{{ asset ('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset ('assets/css/color_skins.css') }}">
    @yield("page_css")
</head>

<body class="theme-black">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img src="{{ site_settings('loading_bar_image') }}" width="48" height="48" alt="Siddhamahayog">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <div class="overlay_menu">
        <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-close"></i></button>
        <div class="container">
            <div class="row clearfix">
                <div class="card">
                    <div class="body">
                        <div class="input-group m-b-0">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="social">
                        <p>Developed By: <a href="https://siddhamahayog.org" target="_blank">Siddhamahayog.org</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div><!-- Overlay For Sidebars -->
    @if(auth()->user()->role_id == 1)
    @include("inc.admin.nav")
    @include("inc.admin.menu")
    @include("inc.admin.aside")
    @endif
    @yield("content")
    @yield("modal")
    <script src="{{ asset ('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{ asset ('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
    @yield("page_script")

</body>

</html>
