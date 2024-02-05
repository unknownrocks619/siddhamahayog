@php /** @var  \App\Models\Dharmasala\DharmasalaBooking $booking */@endphp
@php
    $error = false;
@endphp

<div class="card" id="confirmationDetail">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                @include('admin.dharmasala.booking.partials.title',['booking' => $booking])

                <div class="row g-3 m-3">
                    @if( ! $booking->room_number)
                        @php
                            $error = true;
                        @endphp
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                Room Has not been assigned to this User. Please Assign Room
                            </div>
                        </div>
                    @endif

                    @if ( ! $booking->profile || (! $booking->id_parent && ! $booking->id_card) )
                        @php
                            $error = true;
                        @endphp

                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ ! $booking->profile ? 'Live Photo, ' : ''}}
                                {{ ! $booking->id_card ? ' ID Card ' : ''}}
                                is Missing. Please upload or scan the required document.
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12">
                        @if($booking->status === \App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN)
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <button  class="btn btn-primary ajax-modal" data-action="{{route('admin.modal.display',['view' => 'dharmasala.booking.check-out','booking'=>$booking->getKey(),'type'=>'single'])}}" data-bs-toggle="modal" data-bs-target="#checkOutUser">
                                        Check-out
                                    </button>
                                    <button  class="btn btn-danger ajax-modal" data-action="{{route('admin.modal.display',['view' => 'dharmasala.booking.check-out','booking'=>$booking->getKey(),'type'=>'group'])}}" data-bs-toggle="modal" data-bs-target="#checkOutUser">
                                        Group Check Out
                                    </button>

                                </div>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-border">
                                <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Live Photo</th>
                                    <th>Full Name</th>
                                    <th>Room Number</th>
                                    <th>Check In Time</th>
                                    <th>Check Out Time</th>
                                    <th>ID Card</th>
                                    <th>Total People</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr @if($booking->status === \App\Models\Dharmasala\DharmasalaBooking::PROCESSING) onclick="window.dharmasalaBooking.bookingNavigation(this,{{$booking->getKey()}})" @endif>
                                    <td>{{$booking->room_number}}</td>
                                    <td>
                                        @if($booking->profileImage)
                                            <img src="{{App\Classes\Helpers\Image::getImageAsSize($booking->profileImage->filepath,'m')}}" class="img-fluid " />
                                        @else
                                            <img src="{{asset('no-image.png')}}" class="img-fluid" />
                                        @endif
                                    </td>
                                    <td>{{$booking->full_name}}</td>
                                    <td>{{$booking->room_number}}</td>
                                    <td>{{$booking->check_in}} - {{ $booking->check_in_time }}</td>
                                    <td>{{$booking->check_out ?? 'Not Set' }}</td>
                                    <td>
                                        @if($booking->idCardImage)
                                            <img src="{{App\Classes\Helpers\Image::getImageAsSize($booking->idCardImage->filepath,'m')}}" class="img-fluid w-100" />
                                        @else
                                            <img src="{{asset('no-image.png')}}" class="img-fluid w-100" />
                                        @endif
                                    </td>
                                    <td> {{$booking->getChildBookings->count() + 1 }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if( $booking->id_parent)
                        <div class="col-md-12 mt-3 d-flex align-items-center">
                            <h5 class="mb-0">View Through Primary Contact</h5>
                            <a class="fs-4 mx-3" href="">{{$booking->parentBooking?->full_name}}</a>
                        </div>
                    @endif
                </div>
                @include('admin.dharmasala.booking.partials.family',['booking' => $booking])
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                @if ($booking->status === \App\Models\Dharmasala\DharmasalaBooking::PROCESSING)
                    <button type="button" onclick="window.dharmasalaBooking.confirmBooking(this,'{{$booking->getKey()}}',{callback : 'reload',params:{},'update-children': true})" class="btn btn-primary {{$error ? 'disabled' : ''}}" {{$error ? 'disabled' : ''}}>
                        Confirm Booking
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
