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
                    <h2>All Live Program</h2>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Active</strong> Programs </h2>
                    </div>
                    <div class="body">
                        <x-alert></x-alert>
                        <div class="table-responsive">
                            <table id="program-table" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>Zoom Account</th>
                                        <th>Program</th>
                                        <th>Started At</th>
                                        <th>Lock Status</th>
                                        <th>Started By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lives as $live)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>

                                            {{ $live->zoomAccount->account_username }}
                                        </td>
                                        <td>
                                            {{ $live->program->program_name }}
                                            @if($live->section_id)
                                            <span class="text-success">
                                                {{ $live->programSection->section_name }}
                                            </span>
                                            @else
                                            <span class="text-info">OPEN</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $live->created_at }}
                                        </td>
                                        <td>
                                            @if($live->started_by)
                                            <span>
                                                {{ $live->programCordinate->full_name }}
                                            </span>
                                            @else
                                            ADMIN
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.program.live_program.end',$live->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">End Program</button>
                                            </form>
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