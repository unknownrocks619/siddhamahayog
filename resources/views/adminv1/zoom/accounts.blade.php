@extends("layouts.portal.app")

@section("page_title")
    - Zoom Accounts
@endsection

@section("top_css")
    <link href="{{ asset ('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />

@endsection

@section("content")
<section class="content">
    <div class="container">

        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Used Zoom Account</h2> 
                    <small>
                        <a href="{{ route('admin.admin_zoom_acount_create') }}">[Create New Account]</a>
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
                        <h2><strong>Available</strong> Accounts </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li><a href="{{ route('admin.admin_zoom_acount_create') }}">Add Account</a></li>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Zoom ID</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $account->account_name }}</td>
                                            <td>{{ $account->account_username }}</td>
                                            <td>
                                                <a href="#">
                                                    {{ ucwords($account->account_status) }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href='#' class='text-danger'>
                                                    Edit
                                                </a>
                                                |
                                                <a href="#">
                                                    Delete
                                                </a>
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