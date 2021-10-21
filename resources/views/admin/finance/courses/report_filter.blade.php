@if( ! $funds->count())
    <h4 class='text-danger'>Record Not Found.</h4>
@else
    <table id="user_table" class='table table-responsive table-bordered table-hover '>
        <thead>
            @if(request()->record_type == "overview" || request()->record_type == "all")
                <tr>
                    <th>Sadhak Detail</th>
                    <th class="bg-light">Amount</th>
                    <th class="bg-light">Total Transaction</th>
                    <th class="bg-light">Last Transaction Date</th>
                    <th class="bg-light">Last Transaction Amount</th>
                    <th>Status</th>
                </tr>
            @elseif(request()->record_type == "transaction")
                <tr>
                    <th>Sadhak Detail</th>
                    <th class="bg-light">Transaction Amount</th>
                    <th class="bg-light">Source</th>
                    <th class="bg-light">Remarks</th>
                    <td class='bg-dark text-white'>Transaction Date</td>
                    <th>Status</th>
                </tr>

            @endif
        </thead>
        <tbody>
            @if(request()->record_type == "overview" || request()->record_type == "all")
                @foreach ($funds as $fund)
                    <tr>
                        <td>
                            {{ $fund->user_detail->full_name() }}
                        </td>
                        <td>
                            NRs.{{ number_format($fund->fund_amount,2) }}
                        </td>
                        <td>
                            {{ $fund->fund_detail->count() }}
                            <br />
                            <small>[<a href="{{ route('courses.admin_view_transaction_detail',[$fund->id]) }}" target="_blank" style="text-decoration:underline">view detail</a>]</small>
                        </td>
                        <td>
                            {{ $fund->fund_detail->last()->created_at }}
                        </td>
                        <td>
                            Nrs. {{ number_format($fund->fund_detail->last()->amount,2) }}
                        </td>
                        <td>
                            {{ ucwords($fund->fund_detail->last()->status) }}
                        </td>
                    </tr> 
                @endforeach
            @elseif(request()->record_type == "transaction")
                @foreach ( $funds as $fund )
                    <tr>
                        <td>
                            {{ $fund->user_detail->full_name() }}
                        </td>
                        <td>
                            NRs. {{ number_format($fund->amount,2) }}
                        </td>
                        <td>
                            {{ $fund->source }}
                            <br />
                            <span class='text-info'>
                                Transaction ID : {{ $fund->reference_number }}
                            </span>
                        </td>
                        <td>
                            {{ $fund->owner_remarks }}
                        </td>
                        <td>
                            {{ $fund->created_at }}
                        </td>
                        <td>
                            {{ ucwords($fund->status) }}
                        </td>
                    </tr> 
                @endforeach
            @endif
        </tbody>
    </table>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
        <!-- END: Page Vendor JS-->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#user_table").DataTable();
            });
        </script>
@endif


<!-- 
lalpurja
Mom Citizenship
Nirman Sapana
Trace Nakasa 
-->



