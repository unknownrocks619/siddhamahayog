@if (!\Illuminate\Support\Str::contains($row->source_detail, 'e-sewa', true) && !\Illuminate\Support\Str::contains($row->source, 'stripe', true))
    <span class="transactionWrapper" data-table-wrapper="program_fee_overview" data-wrapper-id="{{$row->transaction_id}}">
        @if (is_null($row->request_type) || adminUser()->role()->isSuperAdmin())
            <span class='update-amount-fee-transaction' data-update-amount-id='update_span_{$row->transaction_id}'>{{default_currency(strip_tags($row->amount ? $row->amount : 0))}}</span>
            @if($row->currency != 'NPR')
            <br />
            <span >Entry: {{default_currency(strip_tags($row->foreign_currency_amount ? $row->foreign_currency_amount : 0),$row->currency)}}</span>
            @endif

            <span class='update-amount-container d-flex align-items-center d-none' id='update_span_{{$row->transaction_id}}'>
            <input type='text' class='form-control' value='{{strip_tags($row->amount)}}' />
            <span class='text-success mx-2 update-transaction-update' style='cursor: pointer'><i class='fas fa-check'></i> </span>
            <span class='text-danger cancel-transaction-update' style='cursor: pointer'><i class='fas fa-close'></i> </span>
            </span>
        @else
            <span class='' data-update-amount-id='update_span_{{$row->transaction_id}}'>{{ default_currency(strip_tags($row->amount ? $row->amount : 0)) }}</span>
        @endif
    </span>
@else
{{default_currency(strip_tags($row->amount))}}
@endif
