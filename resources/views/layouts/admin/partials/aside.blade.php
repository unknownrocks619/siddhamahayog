<!-- Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">

            <!-- Dashboards -->
            <li class="menu-item active">
                <a href="{{route('admin.admin_dashboard')}}" class="menu-link menu-toggle">
                    <div data-i18n="Dashboards">Dashboards</div>
                </a>
            </li>

            <!-- Layouts -->
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                    <div data-i18n="Program & Settings">Programs & Settings</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('admin.program.admin_program_list')}}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-menu-2"></i>
                            <div data-i18n="All Program">All Program</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.program.all-live-program') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-layout-distribute-vertical"></i>
                            <div data-i18n="Live Program">Live Programs</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-layout-distribute-vertical"></i>
                            <div data-i18n="Zoom Settings">Zoom Settings</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.admin_zoom_account_show')}}" class="menu-link">
                                    <div data-i18n="Accounts">Accounts</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!-- Apps -->
            <li class="menu-item
">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-layout-grid-add'></i>
                    <div data-i18n="Members">Members</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('admin.members.all')}}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div data-i18n="All Members">All Members</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="app-chat.html" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div data-i18n="Sadhak List">Sadhak(s)</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="app-calendar.html" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div data-i18n="Volunteers">Volunteers</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="app-kanban.html" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                            <div data-i18n="Staffs">Staffs</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Notices -->
            <li class="menu-item">
                <a href="{{route('admin.notices.notice.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                    <div data-i18n="Notices">Notices</div>
                </a>
            </li>
            <!-- Misc -->
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-box-multiple"></i>
                    <div data-i18n="Misc">Misc</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="javascript:void(0)" target="_blank" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-lifebuoy"></i>
                            <div data-i18n="Support">Support</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list')}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Notices">All Notices</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'priority','filter' => 'high'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="High Priority">High Priority</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'priority','filter' => 'medium'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Medium Priority">Medium Priority</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'priority','filter' => 'low'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Low Priority">Low Priority</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'category','filter' => 'finance'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Finance Category">Finance Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'category','filter' => 'technical_support'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Technical Category">Technical Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'category','filter' => 'admission'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Admission Category">Admission Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.supports.tickets.list',['type' =>'category','filter' => 'other'])}}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-box-single"></i>
                                    <div data-i18n="Other Category">Other</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
<!-- / Menu -->
