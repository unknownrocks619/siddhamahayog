@if( ! user()->phone_number )
<div class="col-lg-12 mb-4 order-0">
    <div class="card border border-danger">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-danger">Oops :(</h5>
                    <p class="mb-4">
                        Your phone number is missing. Please complete your profile to enjoy uninterrupted service.
                    </p>

                    <a href="{{ route('user.account.list') }}" class="btn btn-sm btn-outline-primary clickable" data-href="{{ route('user.account.list') }}">Update Phone Number</a>
                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img src="{{ asset('profile/phone.gif') }}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                </div>
            </div>
        </div>
    </div>
</div>
@endif