<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar"
    style="z-index : 1 !important">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- Place this tag where you want the button to render. -->
            <li class="nav-item lh-1 me-3">
                <button type="button" data-href="{{ route('user.account.notifications') }}"
                    class="clickable btn btn-outline-primary btn-sm">
                    <i class="menu-icon tf-icons bx bxs-bell-ring"></i>
                    Notification
                    <?php

                    use App\Models\MemberNotification;

                    $notification = MemberNotification::where('member_id', user()->id)
                        ->where('seen', false)
                        ->count();
                    ?>
                    <span
                        class="badge bg-white text-primary rounded-pill border notification">{{ $notification }}</span>
                </button>

            </li>
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ profile() }}" alt class="w-px-40 h-auto rounded-circle border border-2" style="height: 100% !important;width: 100% !important;" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ profile() }}" alt
                                            class="w-px-40 h-auto rounded-circle border border-2" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ user()->full_name }}</span>
                                    <small class="text-muted">{{ \App\Models\Role::$roles[user()->role_id] }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('user.account.list') }}">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    @if (in_array(user()->role_id,\App\Models\Role::ADMIN_DASHBOARD_ACCESS))
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.admin_dashboard') }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Admin</span>
                            </a>
                        </li>
                    @endif

                    @if (user()->role_id == \App\Models\Role::CENTER_ADMIN)
                        <li>
                            <a class="dropdown-item" href="{{ route('center.admin.dashboard') }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Admin</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<!-- / Navbar -->
