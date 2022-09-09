@extends("layouts.portal.app")

@section("page_title")
Widgets
@endsection

@section("page_css")
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section("content")
<!-- Main Content -->
<section class="content home">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-6" id="import_form" style="display:none"></div>
            <div class="col-lg-12 col-md-12">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2><strong>Available</strong> Widgets </h2>
                        <ul class="header-dropdown">
                            <li>
                                <a href="{{ route('admin.widget.create') }}" class="btn btn-sm btn-info">
                                    <i class="zmdi zmdi-plus"></i> Add New Widget </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body sales_report">
                        <div class="table-responsive">
                            <table id="widget_table" class="table table-bordered table-hover m-b-0 table-hover">
                                <thead>
                                    <tr>
                                        <th>Widget Name</th>
                                        <th>Widget Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="6">Loading Please wait..</th>
                                    </tr>
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
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#widget_table").dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url()->full() }}",
            columns: [{
                    data: 'widget_name',
                    name: 'widget_name'
                },
                {
                    data: 'widget_type',
                    name: 'widget_type'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        })
    })
</script>
@endsection