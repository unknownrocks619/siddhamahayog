@extends("layouts.portal.app")

@section("page_title")
    Edit Program
@endsection

@section("page_css")
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Programs</h2> 
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
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
                <div class="card">
                    <div class="header">
                        <h2><strong>Update</strong> Program Detail </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <button type="button" onclick="window.location.href='{{ route('admin.program.admin_program_list') }}'" class="btn btn-danger btn-sm boxs-close"><i class="zmdi zmdi-close"></i> Close</button>
                            </li>
                        </ul>
                    </div>
                    <div id="app">
                        <edit-program upload_path="{{ route('program.admin_api_program_update',[$program->id]) }}" resource="{{$program}}"></edit-program>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection