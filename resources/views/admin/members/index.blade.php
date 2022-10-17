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
                        <h2><strong>All</strong> Users </h2>

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
                                        <th>Full Name</th>
                                        <th>Login Source</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Subscription</th>
                                        <th>Action</th>
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
                data: 'full_name',
                name: 'full_name'
            },
            {
                data: "login_source",
                name: "login_source"
            },
            {
                data: "country",
                name: "country"
            },
            {
                data: "phone",
                name: "phone"
            },
            {
                data: "program_involved",
                name: "program_involved"
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
            dataType: 'html',
            success: function(success) {
                $("#modal_content").html(success);
            }
        })
    })
</script>
@endsection