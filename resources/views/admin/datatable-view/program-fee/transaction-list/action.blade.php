<div class='d-flex justify-content-between'>
    @if (!\Illuminate\Support\Str::contains($program->source_detail, 'e-sewa', true) && !\Illuminate\Support\Str::contains($program->source, 'stripe', true))
        @if ($program->verified)
            <button data-method='PUT' data-action='{{route('admin.program.fee.api_update_fee_detail', ['fee_detail' => $program->transaction_id,'source' => 'datatable','refresh'=>1,'sourceID' => 'program_fee_overview'])}}' data-confirm='You are about to change the transaction status to `Unverified` state. User will be notified about the change. Are you sure you want to continue ?' data-bs-original-title='Reject Transaction' data-bs-toggle='tooltip' type='submit' class='btn btn-danger btn-icon data-confirm'><i class='fas fa-close'></i></button>
        @else
            <button  data-method='PUT'  data-action='{{route('admin.program.fee.api_update_fee_detail', ['fee_detail' => $program->transaction_id,'source' => 'datatable','refresh' => true,'sourceID' => 'program_fee_overview'])}}' data-confirm='You are about to update the transaction status to `Verified`. User will be notified about the changes. Do you wish to continue your action ?' type='submit' data-bs-toggle='tooltip' data-bs-original-title='Mark as verified Transaction' class='btn btn-success btn-icon data-confirm'><i class='fas fa-check'></i></button>
        @endif
    @endif
    <button type='button' data-confirm='You are about to delete selected transaction. This action cannot be undone. Do you wish to continue your action ?' data-method='DELETE' data-action="{{route('admin.program.fee.api_delete_fee', ['fee' => $program->transaction_id])}}" class='btn btn-warning btn-icon data-confirm'><i class='fas fa-trash'></i></button>
</div>
