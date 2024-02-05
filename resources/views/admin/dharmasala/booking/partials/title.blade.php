@if($booking->status === \App\Models\Dharmasala\DharmasalaBooking::PROCESSING)
    <h4 class="mb-4 text-danger">Please Confirm All Booking Details are correct.</h4>
@endif

@if($booking->status === \App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN)
    <h4 class="mb-4 text-danger">User Already Check IN</h4>
@endif

@if($booking->status === \App\Models\Dharmasala\DharmasalaBooking::CHECKED_OUT)
    <h4 class="mb-4 text-danger">User Already Checked Out</h4>
@endif

@if($booking->status === \App\Models\Dharmasala\DharmasalaBooking::CANCELLED)
    <h4 class="mb-4 text-danger">Booking Cancelled</h4>
@endif
