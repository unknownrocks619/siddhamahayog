<!DOCTYPE html>
<!--
Template Name: Ashram Admin Template
Author: :Binod Giri
Website: http://www.binodgiri.com.np/
Contact: info@binodgiri.com.np
Like: www.facebook.com/binodgiri41
-->
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
    <title>
        Admin Panel
        @yield('title')
    </title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/components.min.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/themes/dark-layout.min.css') }}"> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/themes/semi-dark-layout.min.css') }}"> -->
    <!-- END: Theme CSS-->

    @yield('page_css')


  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern dark-layout 2-column  navbar-sticky footer-static bg-full-screen-image @if( ! Auth::check()) blank-page @endif" data-open="click" data-menu="vertical-menu-modern" data-col="2-column" data-layout="dark-layout">
    <!-- BEGIN: Content-->
    @if(auth()->check() && isCenter())
      @include('centers.inc.sidebar_navigation')
    @endif
    <div class="app-content content">
      <div class="content-overlay"></div>
        <div class="content-wrapper">
          <div class="content-header row">
          </div>
          <div class="content-body">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- <script src="{{ asset ('admin/app-assets/vendors/js/vendors_mod.min.js') }}"></script> -->
    <!-- <script src="{{ asset ('admin/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script> -->

    <!-- BEGIN: Page Vendor JS-->
    
    <!-- END: Page Vendor JS-->
    <script src="{{ asset ('admin/app-assets/js/scripts/unision.min.js') }}"></script>
    <!-- BEGIN: Theme JS-->

       <!-- <script src="{{ asset ('admin/app-assets/vendors/js/vendors.min.js') }}"></script> -->
 <script src="{{ asset ('admin/app-assets/js/scripts/configs/vertical-menu-dark.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/js/core/app.min.js') }}"></script>
    <!-- <script src="{{ asset ('admin/app-assets/js/scripts/components.min.js') }}"></script> -->
    <script src="{{ asset ('admin/app-assets/js/scripts/footer.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
        @yield('page_js')
        @yield('footer_js')
    <!-- END: Page JS-->

  </body>
  <!-- END: Body-->
</html>