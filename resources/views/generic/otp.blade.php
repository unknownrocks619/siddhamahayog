<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="otp">OTP Code <sup>*</sup></label>
            <input type="text" onchange="window.registration.setAttribute(this)" name="otp" id="otp"
                class="form-control" />
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="alert alert-info">
            @if ($type == 'phone')
                Please enter Six Digit OTP code Sent to you mobile for verification.
            @else
                Please check your email for Six Digit OTP code. Sometime email may land on different folders please
                check all your folders including JUNK, SPAM, Promotion etc.
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 d-flex justify-content-between otp-verification-wrapper">
        <a href="{{ route('user.resend-otp') }}" class="new-verification-code-request"
            onclick="event.preventDefault(); window.registration.resendOTP(this)">Didn't Receive OTP ? Request
            New One</a>
        <button class="btn btn-primary">
            Verify OTP
        </button>
    </div>
</div>
