<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('vedanta.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                @if (site_settings('logo'))
                    <img src="{{ site_settings('logo') }}" style="width:50px;" />
                @endif
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ site_settings('website_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ active_routes(['dashboard']) }}">
            <x-nav-link href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>

            </x-nav-link>
        </li>

        <!-- Layouts -->
        <li
            class="menu-item {{ active_routes(['user.account.notes.notes.index', 'user.account.notes.notes.create', 'user.account.notes.notes.edit']) }}">
            <x-nav-link href="{{ route('user.account.notes.notes.index') }}" class="menu-link">

                <i class="menu-icon tf-icons bx bxs-note"></i>
                <div data-i18n="Layouts">Notes</div>
            </x-nav-link>
        </li>
        @if (user()->role_id != 8)
            <!-- Layouts -->
            <li
                class="menu-item {{ active_routes(['user.account.support.ticket.index', 'user.account.support.ticket.create', 'user.account.support.ticket.edit']) }}">
                <x-nav-link href="{{ route('user.account.support.ticket.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Layouts">Support</div>
                </x-nav-link>
            </li>
        @endif

        @if (user()->role_id == 8)
            <!-- Support Staff -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Tickets</span>
            </li>

            <li class="menu-item {{ active_routes(['supports.staff.tickets.index', 'supports.staff.tickets.show']) }}">
                <x-nav-link href="{{ route('supports.staff.tickets.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Layouts">All Tickets</div>
                </x-nav-link>
            </li>
        @endif

        <!-- Personalise -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Personalise</span>
        </li>
        <li class="menu-item {{ active_routes(['user.account.list', 'user.account.connections']) }}">
            <a href="{{ route('user.account.list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
        </li>
        <li class="menu-item  {{ active_routes(['user.account.notifications']) }}">
            <a href="{{ route('user.account.notifications') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-bell-ring"></i>

                <div data-i18n="Notifications">Notifications</div>
            </a>
        </li>
        <li class="menu-item  {{ active_routes(['donations.list']) }}">
            <a href="{{ route('donations.list') }}" class="menu-link">
                <i class='menu-icon bx bx-donate-heart'></i>
                <div data-i18n="Notifications"> Guru Dakshina</div>
            </a>
        </li>
        @if (auth()->guard('web')->user()->role()->isTeacher())
            <li class="menu-item  {{ active_routes(['donations.list']) }}">
                <a href="{{ route('user.my-member') }}" class="menu-link">
                    <i class='menu-icon bx bx-user'></i>
                    <div data-i18n="Notifications"> My Members</div>
                </a>
            </li>
        @endif
        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>
        <!-- Cards -->
        <li class="menu-item {{ active_routes(['user.account.event.calendar']) }}">
            <a href="{{ route('user.account.event.calendar') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-calendar"></i>
                <div data-i18n="Basic">Calendar</div>
            </a>
        </li>
        <!-- User interface -->
        <li
            class="menu-item {{ active_routes(['user.account.dharmashala.booking.create', 'user.account.dharmashala.booking.index'], 'active open') }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-hotel"></i>
                <div data-i18n="User interface">Dharmashala</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ active_routes(['user.account.dharmashala.booking.index']) }}">
                    <a href="{{ route('user.account.dharmashala.booking.index') }}" class="menu-link">
                        <div data-i18n="Accordion">My Booking</div>
                    </a>
                </li>
                <li class="menu-item {{ active_routes(['user.account.dharmashala.booking.create']) }}">
                    <a href="{{ route('user.account.dharmashala.booking.create') }}" class="menu-link">
                        <div data-i18n="Alerts">New Booking</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Extended components -->
        <li
            class="menu-item {{ active_routes(['user.account.exams.exam.index', 'user.account.exams.exam.result'], 'active open') }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Exams</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ active_routes(['user.account.exams.exam.index']) }}">
                    <a href="{{ route('user.account.exams.exam.index') }}" class="menu-link">
                        <div data-i18n="Perfect Scrollbar">Attend Exam</div>
                    </a>
                </li>
                <li class="menu-item {{ active_routes(['user.account.exams.exam.result']) }} ">
                    <a href="{{ route('user.account.exams.exam.result') }}" class="menu-link">
                        <div data-i18n="Text Divider">Result</div>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="menu-item {{ active_routes(['user.account.programs.program.index', 'user.account.programs.program.notices', 'user.account.programs.program.offline.video', 'user.account.programs.program.resources', 'user.account.programs.program.request.index', 'user.account.programs.courses.fee.list', 'user.account.programs.resources.index', 'user.account.programs.videos.index', 'user.account.programs.program.request.create']) }}">
            <a href="{{ route('user.account.programs.program.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Boxicons">My Programs</div>
            </a>
        </li>

        @if (user()->role_id == 2)
            <!-- Branch Management -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Branch Management</span></li>

            <!-- Cards -->
            <li class="menu-item {{ active_routes(['user.account.event.calendar']) }}">
                <a href="{{ route('user.account.event.calendar') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-calendar"></i>
                    <div data-i18n="Basic">Event / Programs</div>
                </a>
            </li>
            <!-- Cards -->
            <li class="menu-item {{ active_routes(['user.account.event.calendar']) }}">
                <a href="{{ route('user.account.event.calendar') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-calendar"></i>
                    <div data-i18n="Basic">Verification</div>
                </a>
            </li>
            <li class="menu-item {{ active_routes(['user.account.event.calendar']) }}">
                <a href="{{ route('user.account.event.calendar') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-calendar"></i>
                    <div data-i18n="Basic">Live</div>
                </a>
            </li>
            <!-- Branch Management -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text"></span></li>
        @endif
        <li class="menu-item">
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link menu-link text-danger w-100">
                    <i class="menu-icon tf-icons bx bx-lock-alt"></i>
                    <div data-i18n="Boxicons">Logout</div>
                </button>
            </form>
        </li>
        <li class="menu-item">
        </li>
    </ul>
</aside>
<!-- / Menu -->
