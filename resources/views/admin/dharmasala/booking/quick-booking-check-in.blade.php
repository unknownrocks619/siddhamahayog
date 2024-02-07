@extends('layouts.admin.master')
@push('page_title') Dharmasala > Booking List @endpush
@section('main')
    <!-- Responsive Datatable -->
    <div class="card">
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
            <div class="d-none row " id="errorDisplay"  style="min-height: 75vh">
                <div class="col-md-12 bg-danger fs-2 text-center text-white d-flex align-items-center justify-content-center"  style="min-height: 75vh">
                    
                </div>
            </div>
            <div class="row mt-4 d-none" id="booking-status" style="min-height: 75vh">
                <div class="col-md-12 h-75 bg-success text-center d-flex align-items-center justify-content-center"  style="min-height: 75vh">
                    <div>
                        <h1 class="text-white" id="RoomNumber">Your Room Number: 901</h1>
                        <div id="Floor" class="fs-2 text-white">First Floor</div>
                        <div id="Building" class="fs-2 text-white">Ram Niketan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        $(document).ready(function (){
            window.memberSearchFunction();
        });
    </script>
@endpush
