@php
    $booking = null;
    $today =  \Illuminate\Support\Carbon::today();
    $checkOut = \Illuminate\Support\Carbon::today();
    $group = false;

    if ( request()->booking ) {
        $booking = \App\Models\Dharmasala\DharmasalaBooking::where('id',request()->booking)->first();
        $checkOut = \Illuminate\Support\Carbon::createFromFormat('Y-m-d',$booking->check_out ?? date('Y-m-d'));
    }

    if (request()->type && request()->type == 'group') {
        $group = true;
    }
@endphp
<div class="modal-header bg-light py-2">
    <h5 class="modal-title" id="exampleModalLabel1">Check Out Confirmation</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax-form ajax-append" action="{{route('admin.dharmasala.update-booking-status',['booking' => $booking->getKey(),'type' => 'check-out','group'=>$group])}}" method="post">

    <div class="modal-body">
        @if($group && $booking->getChildBookings()->where('status',\App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN)->count())
            <input type="hidden" name="group" value="true" />
            <h5 class="text-danger">You are also About Perform Check out For Following People</h5>
            @foreach ($booking->getChildBookings()->where('status',\App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN)->get() as $familyBooking)
                <div class="row bg-light my-4 p-2">
                    <div class="col-md-2">
                        @if($familyBooking->profileImage)
                            <img src="{{App\Classes\Helpers\Image::getImageAsSize($familyBooking->profileImage->filepath,'m')}}" class="img-fluid " />
                        @else
                            <img src="{{asset('no-image.png')}}" class="img-fluid" />
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>{{$familyBooking->full_name}}</h6>
                        <p>
                            {{$familyBooking->relation}}<br />
                            {{$familyBooking->phone_number}}
                        </p>
                    </div>
                </div>
            @endforeach
        @endif

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
