@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dharmashala /</span> Bookings</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header text-danger">Dharmashala Booking</h5>
                <!-- Account -->
                <div class="card-body">
                    <div id="alert alert-info">
                        Dharmashala Booking not available at the moment.
                    </div>
                </div>
                <hr class="my-0" />

                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection