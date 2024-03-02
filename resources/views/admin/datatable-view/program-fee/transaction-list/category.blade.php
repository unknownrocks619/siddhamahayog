@if($program->getKey() == 5)
    <span class="transactionWrapper" data-table-wrapper="program_fee_overview" data-wrapper-id="{{$row->voucher_number}}">
        @if(is_null($row->request_type) ||  adminUser()->role()->isSuperAdmin())
        <span class="update-amount-fee-transaction" data-update-amount-id="update_span_7">{{$row->voucher_number ?? "-"}}</span>
        <span class="update-amount-container d-flex align-items-center d-none" id="update_span_7">
            <input type="text" class="form-control" value="{{$row->voucher_number}}">
                <span  data-params-key="voucher" data-action="{{route('admin.program.fee.api_update_voucher_number',['transaction'=>$row->transaction_id])}}" class="text-success mx-2 update-transaction-update" style="cursor: pointer">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text-danger cancel-transaction-update" style="cursor: pointer">
                    <i class="fas fa-close"></i>
                </span>
        </span>
        @else
            <span class="" >{{$row->voucher_number ?? "-"}}</span>
        @endif
    </span>
@else
    @php
        $seperate_category = explode("_", $row->amount_category);
        $category_text = "";
        foreach ($seperate_category as $value) {
            $category_text .= ucwords(strtolower($value)) . " ";
        }
    @endphp
    {{$category_text}};
@endif
