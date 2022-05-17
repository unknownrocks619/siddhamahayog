@extends("layouts.portal.app")

@section("page_title")
::Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>


@endsection


@section("content")
<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Program `{{$program->program_name}}`</h2>                    
                </div>
            </div>
        </div>
 
        <div class="row clearfix">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Transaction</strong> Detail
                        </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <button type="button" onclick="window.location.href='{{ route('admin.program.admin_program_detail',[$program->id]) }}'" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</button>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="zmdi zmdi-more"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="{{ route('admin.program.fee.admin_program_create_fee',[$program->id]) }}">
                                            Add Fee
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.program.fee.admin_fee_overview_by_program',[$program->id]) }}">
                                            Overview Transaction
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <table id="program_overview" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>         
        </div>        
    </div>
</section>
@endsection



@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#program_overview').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{url()->full()}}',
            columns: [
                {data: 'member_name',name:"member_name"},
                {data: 'transaction_amount', name: 'transaction_amount'},
                {data: "category",name: "category"},
                {data: "source", name: "source"},
                {data: "status", name: "status"},
                {data: "media", name: "media"},
                {data: "action", name: "action"},
            ]
        });

    })
</script>
<script>
    $(document).on("click",".transaction_action",function(event) {
        event.preventDefault();
        var confirm_action = confirm("You are about to change current status of transaction. Are you sure ?");
        let cur_elem = $(this);
        $.ajax({
            url : $(this).attr("href"),
            success : function (response) {
                $("#program_overview").DataTable().ajax.reload();
            }
        })
    })
    $(document).on('submit','.transaction_action_form', function (event) {
        event.preventDefault();
        // alert("prevented.");
        $.ajax({
            type : $(this).attr('method'),
            data : $(this).serializeArray(),
            url : $(this).attr("action"),
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            success : function (response){
                $("#program_overview").DataTable().ajax.reload();
            }

        })
    })
    $(document).on("click",'.transaction_delete_form', function (event) {
        event.preventDefault();
        $.ajax({
            type : $(this).attr('method'),
            data : $(this).serializeArray(),
            url : $(this).attr('action'),
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            success : function (response) {
                $("#program_overview").DataTable().ajax.reload();
            }
        })

    });
</script>
@endsection