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
    <title>
        {{ $title }}
    </title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/components.min.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.min.css"> -->
    <!-- END: Theme CSS-->

    @stack('page_css')

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/assets/css/style.css') }}">
    <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="dark-layout">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          {{ $slot }}
        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset ('admin/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>

    <!-- BEGIN: Page Vendor JS-->
    
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset ('admin/app-assets/js/scripts/configs/vertical-menu-dark.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/js/scripts/components.min.js') }}"></script>
    <script src="{{ asset ('admin/app-assets/js/scripts/footer.min.js') }}"></script>
    <!-- END: Theme JS-->

   @stack('page_js')
   @stack('footer_js')

  </body>
  <!-- END: Body-->
</html>