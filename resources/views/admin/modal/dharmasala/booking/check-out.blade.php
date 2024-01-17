@php
    $booking = null;
    $today =  \Illuminate\Support\Carbon::today();
    $checkOut = \Illuminate\Support\Carbon::today();
    if ( request()->booking ) {
        $booking = \App\Models\Dharmasala\DharmasalaBooking::where('id',request()->booking)->first();
        $checkOut = \Illuminate\Support\Carbon::createFromFormat('Y-m-d',$booking->check_out);
    }
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel1">Check Out Confirmation</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax-form ajax-append" action="{{route('admin.dharmasala.booking-check-out-reservation',['booking' => $booking->getKey()])}}" method="post">

    <div class="modal-body">
        <div class="card-datatable table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="check_out">
                            Check Out
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="date" name="check_out" id="check_out" class="form-control" value="{{date('Y-m-d')}}" />
                    </div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="donation">Donation Amount</label>
                        <input type="number" class="form-control" name="donation" id="donation" min="0" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="donation_through">Donation Method</label>
                        <select name="donation_through" id="donation_through" class="form-control">
                            <option value="" selected>--</option>
                            <option value="cash">Cash</option>
                            <option value="fonepay">FonePay</option>
                            <option value="esewa">eSewa</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ref_id">Reference / Receipt / Voucher Number</label>
                        <input type="text" name="refId" id="ref_id" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea name="remark" id="remark"  class="textarea form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm Checkout</button>
    </div>
</form>
