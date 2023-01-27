@extends("layouts.portal.app")

@section("page_title")
    ::Student Assign
@endsection

@section("page_css")
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <x-alert></x-alert>
                    <form id="member_search_form" action="{{ route('admin.members.admin_add_assign_member_to_program',$program->id) }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2><strong>Member</strong> Registration </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button" onclick="window.location.href='{{route('admin.program.admin_program_detail',[$program->id])}}'" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</button>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-11 px-0 mx-0">
                                    <div class="form-group">
                                        <strong>
                                            Search Member
                                        </strong>
                                        (Email or Phone)
                                        <input type="text" placeholder="Search Member by Email or phone" name="member" id="member" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-1 mt-3 px-0 mx-0">
                                    <button type="submit" class="btn btn-icon btn-round btn-block btn-outline">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="search_result"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script type="text/javascript">
        $("form#member_search_form").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url : $(this).attr("action"),
                data : $(this).serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method : "GET",
                success : function (response) {
                    $("#search_result").addClass('body mt-2').html(response);
                },
                error : function (response) {
                    if (response.status == 401)  {
                        // window.location.href = '/login';
                    }
                    // if (resonse.data.stats)
                }
            })
        });
    </script>
@endsection
