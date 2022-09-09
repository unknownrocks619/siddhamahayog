@extends("layouts.portal.app")

@section("page_title")
Program
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
                    <h2>Programs</h2>
                    <small>
                        <a href="{{ route('admin.program.admin_program_new') }}">[Create New Batch]</a>
                    </small>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Available</strong> Programs </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li>
                                        <a href="{{ route('admin.program.admin_program_new') }}">Create New Program</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                                x
                            </button>
                            <div class='d-flex align-items-center'>
                                <i class="bx bx-check"></i>
                                <span>{{ Session::get('success') }}</span>
                            </div>
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                            <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                                x
                            </button>
                            <div class='d-flex align-items-center'>
                                <i class="bx bx-check"></i>
                                <span>{{ Session::get('error') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table id="program-table" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Program Name</th>
                                        <th>Total Student</th>
                                        <th>Live</th>
                                        <th>Batch</th>
                                        <th></th>
                                    </tr>
                                </thead>
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
    $('#program-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{url()->full()}}',
        columns: [{
                data: 'id',
                name: "id"
            },
            {
                data: 'program_name',
                name: 'program_name'
            },
            {
                data: "program_duration",
                name: "program_duration"
            },
            {
                data: "promote",
                name: "promote"
            },
            {
                data: "batch",
                name: "batch"
            },
            {
                data: "action",
                name: "action"
            }
        ]
    });
</script>

<script type="text/javascript">
    $('#addBatch').on('shown.bs.modal', function(event) {
        $.ajax({
            method: "get",
            url: event.relatedTarget.href,
            success: function(success) {
                $("#modal_content").html(success);
            }
        })
    })
</script>
@endsection