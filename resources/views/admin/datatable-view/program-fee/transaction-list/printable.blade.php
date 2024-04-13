<button type="button" class="d-none printableLink ajax-modal" id="transactionID_{{$row->transaction_id}}" data-bs-target='#transactionOptionModal' data-bs-toggle='modal' data-action="{{route("admin.modal.display",["view" => "programs.groups.select-transaction-user",'program' => $program->getKey(),'memberID' => $row->member_id,'transactionID' => $row->transaction_id ])}}">Select Category</button>
<input type='checkbox' 
        class="printableTransaction" 
        data-transaction-id="{{$row->transaction_id}}"
        data-member-id="{{$row->member_id}}"
        @if ($row->is_marked_to_print) checked @endif />