<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.frontend.portal.head-css')

</head>

@section('body')
@include('layouts.frontend.portal.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.frontend.portal.topbar')
    @include('layouts.frontend.portal.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.frontend.portal.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
@include('layouts.frontend.portal.right-sidebar')
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
@include('layouts.frontend.portal.vendor-scripts')
</body>

</html>