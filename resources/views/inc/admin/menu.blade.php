<div class="menu-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="h-menu">
                    <li class="open active">
                        <a href="{{ route('admin.admin_dashboard') }}">
                            <i class="zmdi zmdi-home"></i>
                        </a>
                    </li>
                    <li><a href="javascript:void(0)">Website</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.website.menus.admin_menu_list') }}">Menu</a></li>
                            <li><a href="{{ route('admin.website.slider.admin_slider_index') }}">Slider</a></li>
                            <li><a href="{{ route('admin.post.index') }}">Post</a></li>
                            <li><a href="{{ route('admin.page.page.index') }}">Pages</a></li>
                            <li><a href="{{ route('admin.category.index') }}">Category</a></li>
                            <li><a href="contact.html">Activity</a></li>
                            <li><a href="{{ route('admin.website.events.events.index') }}">Programs</a></li>
                            <li><a href="{{ route('admin.website.settings.admin_website_settings') }}">Settings</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Zoom</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.admin_zoom_account_show') }}" title="Zoom Account List">Accounts</a></li>
                            <li><a href="{{ route('admin.meeting.admin_zoom_meetings') }}">Meetings</a></li>
                            <li><a href="blog-list.html">Reports</a></li>
                            <li><a href="blog-list.html">Live</a></li>

                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Programs</a>
                        <ul class="sub-menu mega-menu">
                            <li>
                                <ul class="sub-menu-two">
                                    <li><a href="{{ route('admin.program.admin_program_list',['paid']) }}">Paid Programs</a></li>
                                    <li><a href="{{ route('admin.program.admin_program_list',['open']) }}">Open Program</a></li>
                                    <!-- <li><a href="collapse.html">Clubs</a></li> -->
                                    <li><a href="{{ route('admin.program.admin_program_list') }}">All</a></li>
                                    <li><a href="{{ route('admin.program.all-live-program') }}">Live</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul class="sub-menu-two">
                                    <li><a href="icons.html">Program Calendars</a></li>
                                    <li><a href="{{ route('admin.notices.notice.index') }}">Notices</a></li>
                                    <li><a href="list-group.html">Resources</a></li>
                                    <li><a href="media-object.html">Annoucements</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul class="sub-menu-two">
                                    <li><a href="modals.html">Exam Center</a></li>
                                    <li><a href="notifications.html">Exam Evaluation</a></li>
                                    <li><a href="progressbars.html">Exam Schedules</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul class="sub-menu-two">
                                    <li><a href="sortable-nestable.html">Fee Structure</a></li>
                                    <li><a href="tabs.html">Paid List</a></li>
                                    <li><a href="waves.html">Pending</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Sadhana</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.batch.admin_batch_list') }}">Batch</a></li>
                            <li><a href="advanced-form-elements.html">Active Sadhana</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.widget.index') }}">Widgets</a>
                    </li>
                    <li><a href="javascript:void(0)">Staffs</a>
                    </li>
                    <li><a href="javascript:void(0)">Dharmashala </a>
                        <ul class="sub-menu">
                            <li><a href="widgets-app.html">Sadhak in Dharmashala</a></li>
                            <li><a href="widgets-data.html">Bookings</a></li>
                            <li><a href="widgets-chart.html">Report</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.members.all') }}">Sadhak</a>
                    </li>
                    <li><a href="{{ route('admin.holidays.holiday.index') }}">Holiday Request</a>
                    </li>
                    <li><a href="{{ route('admin.suppports.tickets.list') }}">Support Ticket</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>