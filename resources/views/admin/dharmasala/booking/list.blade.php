@extends('layouts.admin.master')
@push('page_title') Dharmasala > Booking List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Dharmasala/</span> Booking List
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 text-end">
            <a class="btn btn-primary me-1 waves-effect waves-light collapsed"
                    href="{{route('admin.members.create',['dharmasala'=>true])}}"
                    >
                <i class="fas fa-plus me-1"></i>Add New Booking
            </a>

            <div class="collapse" id="addBooking">
                <div class="card">
                    <div class="card-body text-start">
                        @include('admin.modal.dharmasala.booking.book-user')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">All Program  </h5>
        <div class="card-body">

            <div class="col-lg-12 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Dharmasala Quick Booking</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="search" placeholder="Booking ID" name="bookingID" id="quickCheckIn" class="form-control fs-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none row " id="errorDisplay">
                            <div class="col-md-12 bg-danger fs-2 text-center text-white d-flex align-items-center justify-content-center">

                            </div>
                        </div>
                        <div class="row mt-4 d-none" id="booking-status">
                            <div class="col-md-12 h-75 bg-success text-center d-flex align-items-center justify-content-center">
                                <div>
                                    <h1 class="text-white" id="RoomNumber">Your Room Number: 901</h1>
                                    <div id="Floor" class="fs-2 text-white">First Floor</div>
                                    <div id="Building" class="fs-2 text-white">Ram Niketan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <h6><i class="fas fa-filter"></i> Filter By: </h6>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="filter" id="filter" class="form-control">
                            <option value="" selected>Select Option</option>
                            @foreach (\App\Models\Dharmasala\DharmasalaBooking::STATUS as $key => $value)
                                <option value="{{$key}}" @if($key == $filter) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if ( ! empty ($sort) )
                    <div class="col-md-2">
                        <a href="{{route('admin.dharmasala.booking.list')}}" class="btn btn-warning">
                            <i class="fas fa-filter me-1"></i>
                            Clear Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="bookingTable">
                <thead>
                <tr>
                    <th>Guest name</th>
                    {{-- <th>Phone Number</th>
                    <th>Email</th> --}}
                    <th>Room Number</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Booking Status</th>
                    <th>Code</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>Guest name</th>
                        {{-- <th>Phone Number</th>
                        <th>Email</th> --}}
                        <th>Room Number</th>
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        <th>Booking Status</th>
                        <th>QR Code</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="checkOut"></x-modal>
    <x-modal modal="checkIn"></x-modal>
@endsection

@push('page_script')
    <script>
        $(document).ready(function (){
            window.memberSearchFunction();
        });

        $(document).on('click','.btn-remove-user', function (event) {
            event.preventDefault();
            let _getMemberID = $(this).attr('data-member');
            $(this).closest('.selected-user').remove();

            // also remove from input
            $('#selected-result-input').find('.selected_member_'+_getMemberID).remove();
        });

        $('#filter').change(function() {
            let _href = "{{route('admin.dharmasala.booking.list')}}";
            _href += "/"+ $(this).find(':selected').val() + "?" + "{{http_build_query($sort)}}";
            window.location.href = _href;
        })

        $('#bookingTable').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            aaSorting: [],
            ajax: '{{url()->full()}}',
            columns: [
                {
                    data : 'full_name',
                    name: 'full_name'
                },
                // {
                //     data : 'phone_number',
                //     name : "phone_number"
                // },
                // {
                //   data : 'email',
                //   name : 'email'
                // },
                {
                    data: 'room_number',
                    name: 'room_number'
                },
                {
                    data: "check_in",
                    name: "check_in"
                },
                {
                    data: "check_out",
                    name: "check_out"
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data : 'qr',
                    name : 'qr'
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false
                }
            ]
        });
    </script>
@endpush
