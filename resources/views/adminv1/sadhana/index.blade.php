@extends("layouts.portal.app")

@section("page_title")
    Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection


@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Menus</h2> 
                </div>
            </div>
        </div>
        <x-alert></x-alert>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Menus</strong> Available 
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i>
                                    </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#addBatch">
                                                Add New Sadhana
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>S.No</td>
                                            <td>Batch</td>
                                            <td>
                                                Status
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sadhanas as $sadhana)
                                            <tr>
                                                <td>
                                                    {{ $sadhana-> }}
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#menu_table').DataTable();
    })
</script>
@endsection