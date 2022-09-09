<!-- partial:partia/__header.html -->
<header class="sigma_header header-3 can-sticky header-absolute">

    <!-- Middle Header Start -->
    <div class="sigma_header-middle">
        <nav class="navbar">

            <!-- Logo Start -->
            <div class="sigma_logo-wrapper">
                <a class="navbar-brand" href="/">
                    <img src="{{ site_settings('logo') }}" alt="siddhamahayog">
                </a>
            </div>
            <!-- Logo End -->
            @include("frontend.layout.navigation")
            <!-- Controls -->
            <div class="sigma_header-controls style-2">

                <!-- <a href="donation.html" class="sigma_btn-custom"> Donate Here</a> -->

                <ul class="sigma_header-controls-inner">
                    <!-- Mobile Toggler -->
                    <li class="aside-toggler style-2 aside-trigger-left">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </li>
                </ul>

            </div>

        </nav>
    </div>
    <!-- Middle Header End -->

</header>
<!-- partial -->