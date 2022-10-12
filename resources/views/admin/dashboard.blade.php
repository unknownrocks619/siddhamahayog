@extends("layouts.portal.app")
@section("page_title")
- Dashboard
@endsection
@section("top_css")
<link rel="stylesheet" href="assets/plugins/morrisjs/morris.css" />
<link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css" />
<!-- Custom Css -->

@endsection
<!-- Main Content -->
<section class="content home">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Dashboard</h2>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="card tasks_report">
                    <div class="body">
                        <input type="text" class="knob" value="66" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#26dad2" readonly>
                        <h6 class="m-t-20">Satisfaction Rate</h6>
                        <p class="displayblock m-b-0">47% Average <i class="zmdi zmdi-trending-up"></i></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="card tasks_report">
                    <div class="body">
                        <input type="text" class="knob dial2" value="26" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#7b69ec" readonly>
                        <h6 class="m-t-20">Project Panding</h6>
                        <p class="displayblock m-b-0">13% Average <i class="zmdi zmdi-trending-down"></i></p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="card tasks_report">
                    <div class="body">
                        <input type="text" class="knob dial3" value="76" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#f9bd53" readonly>
                        <h6 class="m-t-20">Productivity Goal</h6>
                        <p class="displayblock m-b-0">75% Average <i class="zmdi zmdi-trending-up"></i></p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="card tasks_report">
                    <div class="body">
                        <input type="text" class="knob dial4" value="88" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#00adef" readonly>
                        <h6 class="m-t-20">Total Revenue</h6>
                        <p class="displayblock m-b-0">54% Average <i class="zmdi zmdi-trending-up"></i></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Monthly</strong> Earnings</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <canvas id="line_chart" class="m-b-20" height="150"></canvas>
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="margin-0">5,124</h4>
                                <p>Marketplace</p>
                            </div>
                            <div class="col-4">
                                <h4 class="margin-0">349</h4>
                                <p>Last week</p>
                            </div>
                            <div class="col-4">
                                <h4 class="margin-0">821</h4>
                                <p>Last Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Revenue</strong></h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <canvas id="bar_chart" class="m-b-20" height="150"></canvas>
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="margin-0">5,124</h4>
                                <p>Marketplace</p>
                            </div>
                            <div class="col-4">
                                <h4 class="margin-0">349</h4>
                                <p>Last week</p>
                            </div>
                            <div class="col-4">
                                <h4 class="margin-0">821</h4>
                                <p>Last Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <?php
                    $tickets = \App\Models\SupportTicket::where('parent_id', null)->where('status', "pending")->with(["user"])->paginate();
                    ?>
                    <div class="header">
                        <h2><strong>Support</strong> Tickets</h2>

                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li><a href="{{ route('admin.suppports.tickets.list') }}">View All</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body m-b-10 bg-dark">
                        <div class="row">
                            <div class="col-6">
                                <small>Total Unresolved Tickets</small>
                                <h4 class="text-success m-b-0 m-t-0">10</h4>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="table-responsive earning-report">
                            <table class="table m-b-0 table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Priority</th>
                                        <th>Department</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->user->full_name }}</td>
                                        <td> {!! __("support.".$ticket->priority) !!} </td>
                                        <td> {!! __("support.".$ticket->category) !!} </td>
                                        <td>
                                            <a href="{{ route('admin.suppports.tickets.show',$ticket->id) }}">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Hurry ! Sit back and Relax, You don't have support ticket.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>User</strong> Holiday Request</h2>
                    </div>
                    <div class="body activities">
                        <div class="streamline b-accent">
                            <?php
                            $holiday_requests = \App\Models\ProgramHoliday::where('status', "pending")->with(["student", "program"])->paginate(10);
                            ?>
                            @forelse ($holiday_requests as $holiday)
                            <div class="sl-item">
                                <div class="sl-content">
                                    <div class="text-muted">{{ $holiday->student->full_name }} :: {{ $holiday->program->program_name }}</div>
                                    <p>Holiday From {{ $holiday->start_date }} - {{ $holiday->end_date }}</p>
                                    <p>
                                        <a href="{{ route('admin.holidays.holiday.show',$holiday->id) }}">View Detail</a>
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="sl-item">
                                <div class="sl-content">
                                    <div class="text-muted">---</div>
                                    <p>
                                        Relax, You don't have pending holiday request.
                                    </p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Radar</strong> Chart</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <canvas id="radar_chart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Polar</strong> Area Chart</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <canvas id="chart-area" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="carousel slide twitter feed" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <i class="zmdi zmdi-twitter zmdi-hc-2x"></i>
                                <p>23th Feb</p>
                                <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
                                <div class="m-t-20"><i>- post form ThemeMakker</i></div>
                            </div>
                            <div class="carousel-item">
                                <i class="zmdi zmdi-twitter zmdi-hc-2x"></i>
                                <p>25th Jan</p>
                                <h4>Now Get <span>50% Off</span><br>on buy</h4>
                                <div class="m-t-20"><i>- post form WrapTheme</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="carousel slide google feed" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <i class="zmdi zmdi-google-plus zmdi-hc-2x"></i>
                                <p>18th Feb</p>
                                <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
                                <div class="m-t-20"><i>- post form WrapTheme</i></div>
                            </div>
                            <div class="carousel-item">
                                <i class="zmdi zmdi-google-plus zmdi-hc-2x"></i>
                                <p>28th Mar</p>
                                <h4>Now Get <span>50% Off</span><br>on buy</h4>
                                <div class="m-t-20"><i>- post form ThemeMakker</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="carousel slide facebook feed" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <i class="zmdi zmdi-facebook zmdi-hc-2x"></i>
                                <p>20th Jan</p>
                                <h4>Now Get <span>50% Off</span><br>on buy</h4>
                                <div class="m-t-20"><i>- post form Theme</i></div>
                            </div>
                            <div class="carousel-item">
                                <i class="zmdi zmdi-facebook zmdi-hc-2x"></i>
                                <p>23th Feb</p>
                                <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
                                <div class="m-t-20"><i>- post form Theme</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Jquery Core Js -->
@section("page_script")
<script src="{{ asset ('assets/bundles/knob.bundle.js') }}"></script>
<script src="{{ asset ('assets/bundles/sparkline.bundle.js') }}"></script>
<script src="{{ asset ('assets/plugins/chartjs/Chart.bundle.js') }}"></script>
<script src="{{ asset ('assets/plugins/chartjs/polar_area_chart.js') }}"></script>

<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset ('assets/js/pages/index.js') }}"></script>
<script src="{{ asset ('assets/js/pages/charts/polar_area_chart.js') }}"></script>
@endsection