<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4>
                Payment Transaction Detail.
            </h4>
            <button data-bs-toggle="modal" data-bs-target="#addPayment" class="btn btn-outline-primary @if( ! $member->member_detail->count()) disabled @endif">
                <x-plus>
                    Add Payment
                </x-plus>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>
                        Program name
                    </th>
                    <th>
                        Transaction Date
                    </th>
                    <th>
                        Transaction Amount
                    </th>
                    <th>
                        Remarks
                    </th>
                </tr>
            </thead>
            <tbody>
                @if( ! $member->member_detail->count())
                <tr>
                    <td colspan="4" class="text-muted text-center">
                        Transaction Not Found.
                    </td>
                </tr>
                @else
                @foreach ($member->transactions as $transaction)
                <tr>
                    <td>
                        {{ $transaction->program->program_name}}
                    </td>
                    <td>
                        {{ date('Y-m-d',strtotime($transaction->created_at)) }}
                    </td>
                    <td>
                        {{ default_currency($transaction->amount) }}
                    </td>
                    <td>
                        {{ __('payment.'. $transaction->amount_category) }}
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<x-modal modal="addPayment">
    <form enctype="multipart/form-data" action="{{ route('center.admin.member.payment.store',$member->id) }}" method="post">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">
                Add Member Payment Info
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="enrolledProgram">Select Program
                            <sup class="text-danger">*</sup>
                        </label>
                        <select name="program" id="program" class="form-control">
                            @foreach ($member->member_detail as $enrolled)
                            <option value='{{ $enrolled->program->id }}'>
                                {{ $enrolled->program->program_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment">
                            Add Payment
                        </label>
                        <select name="payment" id="payment" class="form-control">
                            <option value="voucher">Voucher Upload</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="voucher">Upload Voucher
                            <sup class="text-danger">
                                *
                            </sup>
                        </label>
                        <input type="file" required accept="image/*" name="voucher" id="voucher" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount">Amount (NRs)
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="amount" id="amount" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="uploaded_date">Transaction Date
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="date" required name="transaction_date" id="transaction_date" class="form-control" />
                        <div class="text-info">
                            Use Actual transaction that reflects in bank statement.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="verified">Verification Status</label>
                        <select name="verified" id="verified">
                            <option value="0">Pending</option>
                            <option value="1">Verified</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Add Transaction Detail
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-modal>