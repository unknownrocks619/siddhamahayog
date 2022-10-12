@extends("layouts.portal.app")

@section("page_title")
Support Ticket
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />


@endsection


@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Holiday Request</h2>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Support</strong> Ticket </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li>
                                        <a href="{{ route('admin.program.admin_program_new') }}">All Tickets</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.program.admin_program_new') }}">Pending Tickets</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.program.admin_program_new') }}">Resolved Tickets</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.program.admin_program_new') }}">Cancelled Tickets</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <x-alert></x-alert>
                        <div class="table-responsive">
                            <table id="program-table" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Full Name</th>
                                        <th>Program Involved</th>
                                        <th>Total Number of Days</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($holidays as $holiday)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $holiday->student->full_name }}
                                        </td>
                                        <td>
                                            {{ $holiday->program->program_name }}
                                        </td>
                                        <td>
                                            <?php
                                            $start_date = \Carbon\Carbon::parse($holiday->start_date);
                                            $end_date = \Carbon\Carbon::parse($holiday->end_date);
                                            echo $end_date->diffInDays($start_date);
                                            ?>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.holidays.holiday.show',$holiday->id) }}" class="btn btn-success">View Detail</a>
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

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="addBatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_content">
            <div class="moda-body">
                <p>Please wait...loading your data</p>
            </div>
        </div>
    </div>
</div>

@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>


<script>
    $('#program-table').DataTable();
</script>
@endsection