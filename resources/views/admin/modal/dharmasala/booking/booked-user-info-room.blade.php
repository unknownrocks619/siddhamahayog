@php
    $room = null;
    $bookedUser = null;
    if ( request()->room ) {
        $room = \App\Models\Dharmasala\DharmasalaBuildingRoom::where('id',request()->room)->with(['totalActiveReserved'])->first();
        $bookedUser = $room->totalActiveReserved;
    }
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel1">Booked User Info</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

    <div class="modal-body">
        <div class="card-datatable table-responsive">
            <table class="table table-hover table-border" id="booked_user_table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Status</th>
                        <th>Check In / Booking Date</th>
                        <th>Check Out Date</th>
                        <th>QR</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookedUser?? []  as $userInfo)
                        <tr>
                            <td>
                                {{$userInfo->full_name}}
                            </td>
                            <td>
                                {{\App\Models\Dharmasala\DharmasalaBooking::STATUS[$userInfo->status]}}
                            </td>
                            <td>
                                {{$userInfo->check_in}}
                            </td>
                            <td>
                                {{$userInfo->check_out}}
                            </td>
                            <td>
                                {!! QrCode::size(50)->generate($userInfo->uuid); !!}
                            </td>
                            <td>
                                @php
                                    $todayCarbon = \Illuminate\Support\Carbon::now();

                                    $checkInCarbon = null;
                                    if ($userInfo->check_in) {
                                        $checkInCarbon = \Illuminate\Support\Carbon::createFromFormat('Y-m-d',$userInfo->check_in);
                                    }

                                    $checkOutCarbon=null;
                                    if ($userInfo->check_out) {
                                        $checkOutCarbon = \Illuminate\Support\Carbon::createFromFormat('Y-m-d',$userInfo->check_out);
                                    }
                                @endphp
                                    @if ( $checkInCarbon?->greaterThanOrEqualTo($todayCarbon) ||  $userInfo->status == \App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN)
                                        <button class="btn btn-danger btn-icon data-confirm"><i class="ti ti-logout ti-sm"></i></button>
                                    @elseif ($checkInCarbon?->greaterThanOrEqualTo($todayCarbon) && $checkOutCarbon?->greaterThanOrEqualTo($todayCarbon) && in_array($userInfo->status,[\App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN,\App\Models\Dharmasala\DharmasalaBooking::BOOKING,\App\Models\Dharmasala\DharmasalaBooking::RESERVED]))
                                        <button class="btn btn-danger btn-icon data-confirm"><i class="ti ti-logout ti-sm"></i></button>
                                    @elseif($todayCarbon?->greaterThanOrEqualTo($checkOutCarbon) )
                                        <button class="btn btn-danger btn-icon data-confirm"><i class="ti ti-logout meti-sm"></i></button>
                                    @endif

                                    @if ( $checkInCarbon?->greaterThanOrEqualTo($todayCarbon) &&  $userInfo->status !== \App\Models\Dharmasala\DharmasalaBooking::CHECKED_IN)
                                        <button class="btn btn-danger">Cancel Reservation</button>
                                    @endif
                                        
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    <script>
        $('#booked_user_table').dataTable();
    </script>
