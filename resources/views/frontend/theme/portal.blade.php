<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Siddhamahayog :: Portal</title>

    <meta name="description" content="" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('themes/app/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('themes/app/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('themes/app/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('themes/app/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <style>
        .select2-selection--single {
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            font-size: 24px;
        }

        .select2-selection__arrow {
            top: 30% !important;
        }

        .select2-container--default {
            width: 100% !important;
        }
    </style>
    <!-- Page CSS -->
    @stack('custom_css')

    <!-- Helpers -->
    <script src="{{ asset('themes/app/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('themes/app/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('inc.frontend.sidebar')

            <!-- Layout container -->
            <div class="layout-page">
                @if (session()->has('adminAccount'))
                    <div class="row mx-2">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                You are using debug mode for the user. Some action are being
                                restricted to use.
                                <hr />
                                <form action="{{ route('user.account.end_debug_session') }}" method="post">
                                    @csrf
                                    <button class="w-100 btn btn-danger text-right">
                                        End Debug
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @include('inc.frontend.topbar')
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('themes/app/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('themes/app/assets/vendor/libs/popper/popper.js') }}"></script>
    {{-- <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script> --}}
    <script src="{{ asset('themes/app/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('themes/app/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('themes/app/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="{{ asset('themes/app/assets/js/main.js') }}"></script>


    @stack('custom_script')

    <!-- Page JS -->
    <script src="{{ asset('themes/app/assets/js/dashboards-analytics.js') }}"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="{{ mix('js/portal.js') }}"></script>



    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        $("button.clickable").click(function(event) {
            event.preventDefault();
            $(this).prop("disabled", true);
            window.location.replace($(this).data("href"));
        })

        $(document).on('click', '.unlock-video-pricing', function(event) {
            event.preventDefault();
            let _this = this;
            // get type
            let _subscriptionType = $(_this).attr('data-type');
            let _typeID = $(_this).attr('data-id');

        })
    </script>
</body>

</html>
