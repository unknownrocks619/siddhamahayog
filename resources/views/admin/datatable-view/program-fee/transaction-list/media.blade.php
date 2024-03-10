@php
 $row->remarks = (json_decode( $row->remarks)); 
@endphp
@if($row->file || $row->transaction_file)
    <a 
        class='ajax-modal' 
        data-bs-toggle='modal' 
        data-action="{{route('admin.modal.display',['view' => 'fees.media.images','transactionID' => $row->transaction_id,'programID' => $program->getKey(),'memberID' => $row->member_id])}}" 
        data-bs-target='#imageFile' 
        href="{{route('admin.program.fee.admin_display_fee_voucher', $row->transaction_id)}}"> 
            View Image 
    </a>
    @if ($row->remarks && isset($row->remarks->upload_date))
        <br /> 
        Deposit Date: {{$row->remarks->upload_date}}
    @endif

@elseif(\Illuminate\Support\Str::contains($row->source_detail, 'e-sewa', true))
        OID: {{$row->remarks->oid}}
        <br />
        refId :  {{$row->remarks->refId}}
        
@elseif (\Illuminate\Support\Str::contains($row->source, 'stripe', true))
        Rate : {{$row->remarks->rate->exchange_data->buy}}  NRs
        <br />
        Currency: {{$row->remarks->paid_currency}}
        <br />
        Amount: {{$row->remarks->paid_amount}};
@else
    @if($row->currency != 'NPR')
    <a 
    class='ajax-modal' 
    data-bs-toggle='modal' 
    data-action="{{route('admin.modal.display',['view' => 'fees.media.images','transactionID' => $row->transaction_id,'programID' => $program->getKey(),'memberID' => $row->member_id])}}" 
    data-bs-target='#imageFile' 
    href="{{route('admin.program.fee.admin_display_fee_voucher', $row->transaction_id)}}"> 

    Currency: {{$row->currency}}</a>
    @else

        Media Not Available
    @endif 


@endif
