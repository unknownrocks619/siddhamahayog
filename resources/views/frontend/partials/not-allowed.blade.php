<div class="card mb-4">
    <!-- Payment information detail -->
    <div class="card-body">
        <div class="row d-flex justify-content-between">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <button class="btn btn-sm btn-danger clickable" data-href="{{ route('user.account.programs.program.index') }}">
                    <i class="bx bx-window-close">
                    </i>
                    Close Payment
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h5 class="text-danger">
                    Oops ! Something is not right.
                </h5>
                <p class="text-danger">
                    Selected method is not supported in your country or region. Please use available alternate method
                    of payment.
                </p>
                <div class="alert alert-info">
                    For More Information: <br />
                    Please contact Your nearest <code>`Mahayogi Siddhababa Spiritual Academy`</code> center.
                </div>
            </div>

            <div class="col-md-8 border-top mt-3 pt-3">
                @if(getUserCountry() == "NP")
                <a href="{{ route('user.account.programs.payment.create.form',[$program->id,'paymentOpt'=>'esewa']) }}" class="btn btn-outline-success">E-Sewa payment</a>
                <a href="{{ route('user.account.programs.payment.create.form',[$program->id,'paymentOpt'=>'voucher']) }}" class="btn btn-primary">Voucher Upload</a>
                <a href="{{ route('user.account.programs.payment.create.form',[$program->id,'paymentOpt'=>'stripe']) }}" class="btn btn-outline-primary">Pay by Card</a>
                @else
                <a href="#{{-- route('user.account.programs.payment.create.form',[$program->id,'paymentOpt'=>'stripe']) --}}" class="btn btn-outline-primary disabled">Pay by Card</a>
                @endif
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <!-- /Payment information detail -->
</div>