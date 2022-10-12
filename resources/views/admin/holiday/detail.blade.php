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
            <div class="col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2><strong>Holiday</strong> for {{ $holiday->student->full_name }} </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="{{ route('admin.holidays.holiday.index') }}" class="btn btn-danger btn-sm">
                                    <i class="zmdi zmdi-close"></i>
                                    close
                                </a>

                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <x-alert></x-alert>
                        <div class="table-responsive">
                            <div class="border px-2 py-2">
                                {{ $holiday->reason }}
                            </div>
                            <div class="mt-2 row">
                                <div class="col-md-4">
                                    <dit class="mt-3">
                                        <strong>
                                            Start Date
                                        </strong>
                                        {{ $holiday->start_date }}
                                    </dit>
                                </div>
                                <div class="col-md-4">
                                    <strong>
                                        End Date
                                    </strong>
                                    {{ $holiday->end_date }}
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>
                                        Status:
                                    </strong>
                                    {{ $holiday->status }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="co-lg-4">
                <x-alert></x-alert>
                <div class="card">
                    <div class="body">
                        <form action="{{ route('admin.holidays.holiday.update',$holiday->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12"><strong>Options</strong>
                                    <select name="options" id="options" class="form-control">
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <strong>
                                            Message
                                        </strong>
                                        <textarea name="message" id="message" class="form-control"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
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