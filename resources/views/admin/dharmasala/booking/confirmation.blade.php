@php
    use App\Models\Dharmasala\DharmasalaBooking;
    /** @var  \App\Models\Dharmasala\DharmasalaBooking $booking */
    $disabled = false;
    if(in_array($booking->status,[DharmasalaBooking::CHECKED_IN,DharmasalaBooking::CHECKED_OUT,DharmasalaBooking::RESERVED,DharmasalaBooking::BOOKING])) {
        $disabled = true;
    }
@endphp
@extends('layouts.admin.master')
@push('page_title') Booking Confirmation >> {{$booking->full_name}} @endpush

@section('main')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Dharmasala / <a href="{{route('admin.dharmasala.booking.list')}}">Bookings</a></span>/
            Booking Confirmation
        </h4>
        <a class="btn btn-icon btn-primary mb-2" href="{{route('admin.dharmasala.booking.list')}}">
            <i class="fas fa-arrow-left"></i>
        </a>

        <!-- Sticky Actions -->
        <div class="row">
            <div class="col-8" id="confirmationDetail">
                @include('admin.dharmasala.booking.partials.confirmation-detail',['booking' => $booking])
            </div>

            <div class="col-md-4" id="confirmationNavigation">
                @include('admin.dharmasala.booking.partials.confirmation',['booking' => $booking])
            </div>
        </div>
        <!-- /Sticky Actions -->
    </div>
    <x-modal modal="checkOutUser"></x-modal>
@endsection
@push('page_script')
    <script>
        $(document).ready(function(){
            window.dharmasalaBooking.setInitialBookingID("{{$booking->getKey()}}",{disabled : '{{$disabled}}'})
        })
    </script>
@endpush
