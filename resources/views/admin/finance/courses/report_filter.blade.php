@if( ! $funds->count())
    <h4 class='text-danger'>Record Not Found.</h4>
@else
    <table class='table table-bordered'>
        <thead>
            @if(request()->record_type == "overview")
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
            @if(request()->record_type == "overview")
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
                            <small>[<a href="" style="text-decoration:underline">view detail</a>]</small>
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
@endif

