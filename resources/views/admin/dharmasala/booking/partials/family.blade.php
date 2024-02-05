@php
/** @var \App\Models\Dharmasala\DharmasalaBooking $booking */
@endphp
@if( $booking->getChildBookings->count())
    <h4 class="mt-5 text-danger">Family & Friends Booking Detail.</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Apply Same Room Number & Check In Info</label>
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover ">
                    <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Media</th>
                        <th>Full name</th>
                        <th>Relation</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Phone Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($booking->getChildBookings as $familyBooking)
                        <tr class="enable-edit" onclick="window.dharmasalaBooking.bookingNavigation(this,{{$familyBooking->getKey()}})" data-booking-id="{{$familyBooking->getKey()}}">
                            <td>
                                <span class="text">
                                    {{ ! $familyBooking->room_number ? $booking->room_number : $familyBooking->room_number}}
                                </span>
                            </td>
                            <td>
                                @if($familyBooking->profileImage)
                                    <img src="{{App\Classes\Helpers\Image::getImageAsSize($familyBooking->profileImage->filepath,'m')}}" class="img-fluid w-50" />
                                @else
                                    <img src="{{asset('no-image.png')}}" class="img-fluid w-50" />
                                @endif
                            </td>
                            <td><span class="text">{{$familyBooking->full_name}}</span></td>
                            <td><span class="text">{{$familyBooking->relation_with_parent}}</span></td>
                            <td>
                                <span class="text">
                                    {{$familyBooking->check_in}} {{$familyBooking->check_in_time}}
                                </span>
                            </td>
                            <td>
                                <span class="text">
                                    {{$familyBooking->check_out ?? '-'}} {{$familyBooking->check_out_time}}
                                </span>
                            </td>
                            <td>
                                {{$familyBooking->phone_number}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
