    <nav class="navbar">
        <div class="container">
            <ul class="nav navbar-nav">
                <li>
                    <div class="navbar-header">
                        <a href="javascript:void(0);" class="h-bars"></a>
                        <a class="navbar-brand" href="{{ route('admin.admin_dashboard') }}">
                            <img src="{{ site_settings('logo') }}" width="35" alt="Siddhamahayog">
                            <span class="m-l-10">Siddhamahayog ADMIN PANEL</span></a>
                    </div>
                </li>

                <li class="float-right">
                    <!-- <a href="javascript:void(0);" class="fullscreen" data-provide="fullscreen"><i class="zmdi zmdi-fullscreen"></i></a>
                    <a href="javascript:void(0);" class="btn_overlay"><i class="zmdi zmdi-sort-amount-desc"></i></a>
                    <a href="javascript:void(0);" class="js-right-sidebar"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a> -->
                    <form method="post" action="{{ route('logout') }}" style="display:inline-block">
                        @csrf
                        <button type="submit" class='btn btn-danger btn-sm'>
                            <i class="zmdi zmdi-power"></i> Logout
                        </button>
                    </form>

                </li>
            </ul>
        </div>
    </nav>