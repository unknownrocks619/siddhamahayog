@extends("layouts.portal.app")

@section("page_title")
    Meeting Configuration
@endsection

@section("page_css")
<link href="{{ asset ('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection


@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Meetings</h2> 
                    <small>
                        <a href="{{ route('admin.meeting.admin_create_new_meeting') }}">[Create New Meeting]</a>
                    </small>                   
                </div>            
                <!-- <div class="col-lg-7 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Charts</a></li>
                        <li class="breadcrumb-item active">Jquery DataTables</li>
                    </ul>
                </div> -->
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Available</strong> Meetings </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li>
                                        <a href="{{ route('admin.meeting.admin_create_new_meeting') }}">Create New Meeting</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Zoom ID</th>
                                    <th>Status</th>
                                    <th>Lock Status</th>
                                </tr>
                            </thead>
                                <tfoot>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Meeting Type</th>
                                        <th>Status</th>
                                        <th>Lock Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($meetings as $meeting)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $meeting->meeting_name }}</td>
                                            <td>{{ $meeting->meeting_type }}</td>
                                            <td>
                                                @if($meeting->live)
                                                    <span class='bg-success text-white px-2'>Live</span>
                                                @else
                                                    <span class='bg-danger px-2'>Inactive<live>
                                                @endif
                                            </td>
                                            <td>
                                                @if($meeting->lock)
                                                    <span class='bg-success px-2'>Enabled</span>
                                                    <br />
                                                    @if($meeting->lock_setting)
                                                        <span class='bg-info'>Meeting Will be Locked at: {{$meeting->lock_setting}}</span> 
                                                    @endif
                                                @else
                                                    <span class='bg-warning px-2'>Disabled</span><br />
                                                    <a href="#">Click here to enable</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($meeting->live)
                                                    <a href='#' class='btn btn-success btn-sm'>
                                                        Join As Admin
                                                    </a>
                                                    <br />
                                                    <a href='#' class='btn btn-info btn-sm'>
                                                        Join Regular
                                                    </a>
                                                @else
                                                    <button type="button" disabled class='btn btn-success btn-sm disabled'>
                                                            Join As Admin
                                                    </button>
                                                    <br />
                                                    <button type="button" disabled class='btn btn-info btn-sm  btn-disabled'>
                                                        Join Regular
                                                    </button>

                                                @endif
                                            </td>
                                            <td>
                                                <a onclick="window.location.href='{{ route('admin.meeting.admin_edit_meeting',[$meeting->id]) }}'">
                                                    Edit 
                                                </a>
                                                |
                                                @if($meeting->live)
                                                    Detail | 
                                                @endif
                                                Delete
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")

<!-- Jquery DataTable Plugin Js --> 
<script src="{{ asset ('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset ('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset ('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset ('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset ('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset ('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>

<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset ('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection