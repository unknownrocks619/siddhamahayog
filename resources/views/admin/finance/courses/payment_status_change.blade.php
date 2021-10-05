@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        <div class="col-8">
            <div class='card'>
                <div class='card-header'>
                    <h3 class='card-title'>Payment Detail</h3>
                </div>
                <div class='card-body'>
                    <p>
                        <strong>Full Name: </strong> {{ $transaction->user_detail->full_name() }}
                        <br />
                        <strong>Phone:</strong> {{ $transaction->user_detail->phone_number }}
                    </p>
                    <p>
                        <strong>Deposit Source: </strong>{{ $transaction->source }}
                        <br />
                        <strong>Amount:</strong> NRs. {{ number_format($transaction->amount, 2) }}
                        <br />
                        <strong>Reference Number: {{ $transaction->reference_number }}</strong>
                        <br />
                        <strong>Owner Remark:</strong> {{ $transaction->owner_remarks }}
                    </p>
                    <p>
                        <strong>Status:</strong>{{ ucwords($transaction->status) }}
                        <br />
                        <strong>Admin Remark:</strong> {{ $transaction->admin_remarks }}
                    </p>
                    <p>
                        <strong>Uploaded File:</strong> @if( ! $transaction->file) Not Found @else <br />
                            <br />
                            <img src="{{profile_asset($transaction->file)}}" class='img-thumbnail' />
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class='col-4'>
            <x-alert></x-alert>
            <form method="post" action="{{ route('courses.admin_store_change_payment_status',[$transaction->id]) }}">
                @csrf
                <div class='card'>
                    <div class='card-header'>
                        <h4 class='card-title'>Verify Payment</h4>
                    </div>
                    <div class='card-body'>
                        <div class='form-row'>
                            <div class='col-md-12'>
                                <label class='label-control'>Remark</label>
                                <textarea class='form-control' name="admin_remarks"></textarea>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='col-md-12'>
                                <label class='label-control'>Payment Status</label>
                                <select class='form-control' name="approve">
                                    <option value="1"  selected>Approve</option>
                                    <option value="0">Reject</option>
                                </select>
                            </div>
                        </div>            
                    </div>
                    <div class='card-footer'>
                        <button type="submit" class='btn btn-primary'>
                            Change Status
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection

@section("footer_js")
@endsection