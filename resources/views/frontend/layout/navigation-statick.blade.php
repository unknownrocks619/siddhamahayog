<!-- Menu -->
<div class="sigma_header-inner">
    <div class="sigma_header-top">
        <div class="sigma_header-top-inner">
            <ul class="sigma_header-top-links">
                @if(site_settings('main_contact'))
                <li class="menu-item">
                    <a href="tel:+123456789">
                        <i class="fal fa-phone"></i>
                        {{ site_settings("main_contact") }}
                    </a>
                </li>
                @endif
                @if(site_settings('official_email'))
                <li class="menu-item">
                    <a href="mailto:{{ site_settings('official_email') }}">
                        <i class="fal fa-envelope"></i> {{ site_settings('official_email') }}
                    </a>
                </li>
                @endif
            </ul>



            <ul class="sigma_header-top-links">
                @if(site_settings('live_show') )
                <li class="d-flex align-items-center">
                    <a href="#" class="live">
                        <i class="fa fa-circle"></i>
                        Live
                    </a>
                </li>
                @endif

                @auth

                <li class="menu-item menu-item-has-children d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-info bg-info signma_btn-custom">Logout</button>
                    </form>
                </li>
                <li class="ms-3 menu-item menu-item-has-children d-flex align-items-center">
                    <form method="get" action="{{ route('dashboard') }}">
                        <button type="submit" class="btn btn-sm btn-outline-primary signma_btn-custom">
                            <img src="{{ profile() }}" style="width:25px; height:25px;" />
                        </button>
                    </form>
                </li>
                @else
                <li class="menu-item menu-item-has-children d-flex align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-info bg-info sigma_btn-custom"> Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-warning bg-warning sigma_btn-custom">Register</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
    <div class="d-flex justify-content-center justify-content-lg-between">
        <ul class="navbar-nav">
            <li class="menu-item">
                <a href="/">
                    Home
                </a>
            </li>
            <li class="menu-item">
                <a href="/">
                    Photo Gallery
                </a>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#">
                    Sadhana
                </a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="#">Shaktipat</a>
                    </li>
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Hathayog</a>
                        <ul class="sub-menu">
                            <li class="menu-item">
                                <a href="">Surya Namaskar</a>
                            </li>
                            <li class="menu-item">
                                <a href="">Hasta Hana Darshan</a>
                            </li>
                            <li class="menu-item">
                                <a href="">84 Asanas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="#">Laya Yoga</a>
                    </li>
                    <li class="menu-item">
                        <a href="#">Raja Yoga</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#">
                    About
                </a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('jagadguru') }}">
                            Jagadguru
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('guru-parampara') }}">
                            Guru parampara
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#">
                    program
                </a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('sadhana.detail') }}">
                            Sadhana
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('vedanta.index') }}">
                            Vedanta Darshan
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#">
                    Events
                </a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('events.atirudri') }}">
                            Atirudri
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('events.atirudri') }}">
                            Tarak
                        </a>
                    </li>
                    <li class="menu-item"><a href="">
                            Jagadguru Ghosana
                        </a>
                    </li>
                    <li>
                        <a href="">Braman</a>
                    </li>
                    <li>
                        <a href="">Health camp</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="">Samadhi</a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="">Chatara</a>
                    </li>
                    <li class="menu-item">
                        <a href="">Pokhara</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="">Welness</a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="">Panchakarma</a>
                    </li>
                    <li class="menu-item">
                        <a href="">Self Healing</a>
                    </li>
                    <li class="menu-item">
                        <a href="">Rehabitation</a>
                    </li>
                    <li class="menu-item">
                        <a href="">Ayurveda</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="">Club & Communities</a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="">Anjeneya Club</a>
                    </li>
                    <li class="menu-item">
                        <a href="">Janaki Mata samuha</a>
                    </li>
                    <li class="menu-item">
                        <a href="">Ram Dal</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>