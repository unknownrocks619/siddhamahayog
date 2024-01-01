@extends("layouts.portal.app")

@section("page_title")
::Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />


@endsection


@section("content")
<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Transaction Detail for `{{$member->full_name}}`</h2>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-4 col-lg-4 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Transaction</strong> Overview
                        </h2>
                    </div>
                    <div class="body">
                        <strong>Total Fee: </strong> {{ default_currency($transaction->total_amount) }}
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Transaction</strong> Detail
                        </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <button type="button" onclick="window.location.href='{{ route('admin.program.fee.admin_fee_overview_by_program',[$transaction->program_id]) }}'" class="btn btn-danger btn-sm boxs-close">
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
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <table id="program_overview" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->transactions as $all_detail_transaction)
                                <tr>
                                    <td>
                                        {{ date("Y-m-d", strtotime($all_detail_transaction->created_at)) }}
                                    </td>
                                    <td>
                                        {{ default_currency($all_detail_transaction->amount) }}
                                    </td>

                                    <td>
                                        @php
                                        $category_explode = explode('_',$all_detail_transaction->amount_category);
                                        foreach ( $category_explode as $category):
                                        echo ucwords(strtolower($category)) . " ";
                                        endforeach
                                        @endphp
                                    </td>

                                    <td>
                                        {{ $all_detail_transaction->source }}
                                        <hr />
                                        {!! $all_detail_transaction->source_detail !!}
                                    </td>

                                    <td>

                                        @php
                                        $status = "";
                                        if ($all_detail_transaction->verified) {
                                        $status .= '<span class="badge bg-success px-2"><a href="#" title="Verified"><i class="text-white zmdi zmdi-check"></i></a>';
                                            } else {
                                            $status .= '<span class="badge bg-danger px-2"><a href="#" title="Rejected"><i class="text-white zmdi zmdi-minus-circle-outline"></i></a>';

                                                }
                                                $status .= "</span>";
                                            echo $status;
                                            @endphp
                                    </td>

                                    <td>
                                        <?php
                                        // if ($all_detail_transaction->file) {
                                        //     $file_object = $all_detail_transaction->file;
                                        //     echo "<a href='" . asset($file_object->path) . "'>" . $all_detail_transaction->type . "</a>";
                                        // } else {
                                        //     echo "N/A";
                                        // }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $action = "";
                                        $action .= "<form style='display:inline' method='PUT' class='transaction_action_form' action='" . route('admin.program.fee.api_update_fee_detail', [$all_detail_transaction->id]) . "'>";
                                        $action .= "<input type='hidden' name='update_type' value='status' />";

                                        if ($all_detail_transaction->verified) {
                                            $action .= "<button type='submit' class='btn btn-danger btn-sm'>Reject</button>";
                                        } else {
                                            $action .= "<button type='submit' class='btn btn-success btn-sm'>Verify</button>";
                                        }
                                        $action .= "</form>";

                                        $action .= "<form style='display:inline' method='DELETE' action='" . route('admin.program.fee.api_delete_fee', $all_detail_transaction->id) . "' class='transaction_delete_form'>";
                                        $action .= "<input type='hidden' name='update_type' value='status' />";
                                        $action .= "<button type='submit' class='btn btn-danger btn-sm'><i class='zmdi zmdi-delete'></i></button>";
                                        $action .= "</form>";
                                        echo $action;
                                        ?>
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
</section>
@endsection



@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
    $('#program_overview').DataTable();

    // })
</script>
<script>
    $(document).on("click", ".transaction_action", function(event) {
        event.preventDefault();
        var confirm_action = confirm("You are about to change current status of transaction. Are you sure ?");
        let cur_elem = $(this);
        $.ajax({
            url: $(this).attr("href"),
            success: function(response) {
                $("#program_overview").DataTable().ajax.reload();
            }
        })
    })
    $(document).on('submit', '.transaction_action_form', function(event) {
        event.preventDefault();
        // alert("prevented.");
        let form = $(this);
        $(form).find('button').prop('disabled', true);
        $.ajax({
            type: $(this).attr('method'),
            data: $(this).serializeArray(),
            url: $(this).attr("action"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert("Fee detail updated.");
                location.reload();
            },
            error: function() {
                alert("unable to update form detail");
                $(form).find('button').prop('disabled', false);
            }

        })
    })
    $(document).on("click", '.transaction_delete_form', function(event) {
        event.preventDefault();
        $(form).find('button').prop('disabled', true);

        $.ajax({
            type: $(this).attr('method'),
            data: $(this).serializeArray(),
            url: $(this).attr('action'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Transaction deleted.');
                location.reload();
            },
            error: function() {
                alert("unable to update transaction detail.");
                $(form).find('button').prop('disabled', false);

            }
        })

    });
</script>
@endsection
