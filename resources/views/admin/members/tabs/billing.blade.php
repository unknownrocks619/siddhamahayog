<!-- Project table -->
<div class="card mb-4">
    <h5 class="card-header">Payment History</h5>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-info ajax-modal" data-bs-toggle="modal" data-bs-target="#addPayment" data-action="{{route('admin.modal.display',['view' => 'programs.program-payment','member'=>$member->getKey()])}}" data-method="post">
                    <i class="fas fa-plus me-2"></i>
                    Add Payment
                </button>
            </div>
        </div>


    </div>

    <div class="table-responsive mb-3">
        <table class="table table-border table-hover">
            <thead>
            <tr>
                <th>
                    Program Name
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Source
                </th>
                <th>
                    Status
                </th>
                <th></th>
                <th>
                    Action
                </th>
            </tr>
            </thead>
            <tbody>

            @forelse ($member->transactions as $transaction)
                <tr>
                    <td>
                        {{ $transaction->program->program_name }}
                    </td>
                    <td>
                        NRs. {{$transaction->amount}}
                    </td>
                    <td>
                        {{ ($transaction->source) }}
                        <br />
                        {{ $transaction->source_detail }}
                    </td>
                    <td>

                        @if($transaction->rejected)
                            <span class="badge bg-danger px-2">
                                                        <a href="#" title="Rejected" class="text-white">
                                                            <i class="text-white fas fa-cancel"></i>
                                                            Rejected
                                                        </a>
                                                    </span>
                        @elseif ( ! $transaction->verified)
                            <span class="badge bg-warning px-2">
                                                        <a href="#" title="Unverified">
                                                            <i class="text-white fas fa-exclamation-circle"></i>
                                                            Pending
                                                        </a>
                                                    </span>
                        @else
                            <span class="badge bg-success px-2"><i class="text-white fas fa-check"></i> Verified</span>
                        @endif
                    </td>
                    <td>
                        @if(str($transaction->source)->lower()->value() == 'online')

                            @foreach ($transaction->remarks as $key => $remarks)
                                <strong>
                                    {{ $key }} :
                                </strong>
                                {{ $remarks }}
                                <br />
                            @endforeach

                        @elseif($transaction->source == 'Voucher Upload')
                            Date : {{ $transaction->remarks->upload_date }}
                            @if($transaction->file && isset($transaction->file->path))
                                <br />
                                [<a href="#" data-bs-target="#voucherView" class="ajax-modal" data-bs-toggle="modal" data-action="{{ route('admin.modal.display', ['view' => 'programs.voucher-view','fee_detail' => $transaction->id]) }}">View File</a>]
                            @endif
                        @endif
                    </td>
                    <td>
                        <a data-method="PUT" data-title-="Change Transaction Status ??" data-confirm="You are about the change the status of current transaction. Notification will be sent to user regarding their status change. Do you wish to continue ?" data-action="{{route('admin.program.fee.api_update_fee_detail', [$transaction->id])}}"
                            class='btn btn-{{$transaction->verified ? 'danger' : 'success'}} btn-sm data-confirm text-white'>
                            {{$transaction->verified ? "Reject" : 'Verify'}}
                        </a>

                        <a type='submit' class='btn btn-danger btn-sm data-confirm text-white' data-action="{{ route('admin.program.fee.api_delete_fee', $transaction->id) }}" data-method="delete"><i class='fas fa-trash'></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Payment not found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- /Project table -->
<x-modal modal="addPayment"></x-modal>
<x-modal modal="voucherView"></x-modal>
