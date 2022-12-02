@extends("frontend.theme.master")
@section("content")
<div class="sigma_subheader dark-overlay dark-overlay-2" style="background-image: url({{ asset('themes/om/assets/img/events/sadhana/sadhana-banner.jpg') }})">

    <div class="container">
        <div class="sigma_subheader-inner" style="align-items: flex-start">
            <div class="sigma_subheader-text">
                <h1 style="color:#db4242">vedanta Philosophy - Payment </h1>
            </div>
        </div>
    </div>
</div>

<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    @if(site_settings('online_payment') || user()->role_id == 1)
    <form action="{{ route('user.account.programs.payment.create.form',[$program->id]) }}" method="get">
        @else
        <form action="{{ route('dashboard',[$program->id]) }}" method="get">
            @endif
            <div class="container">
                <div class="row sigma_broadcast-video my-3">
                    <div class="col-md-12 mx-auto">
                        <x-alert></x-alert>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">
                                    Admission Fee Collection
                                </h3>
                                <div class="row">
                                    @if(getUserCountry() != 'NP')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="AdmissionFee">Admission Fee</label>
                                            <input type="text" name="admission_fee" id="admission_fee" value="USD 199" class="form-control" />
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="AdmissionFee">Admission Fee</label>
                                            <input type="text" name="admission_fee" value="NRs 9000" id="admission_fee" class="form-control" />
                                            <sup class="text-info">Above price is applicable only for people living in Nepal.</sup>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @if(getUserCountry() == 'NP')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="paymentOpt" class="mb-4">
                                                Select Payment Method
                                            </label>
                                            <select name="paymentOpt" id="paymentOpt" class="mt-2 form-control @error('regural_medicine_history') border border-danger @enderror">
                                                <option value="esewa">E-Sewa</option>
                                                <option value="voucher">Voucher</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            For More Information<br />
                                            Please Contact Your nearest <code>`Mahayogi Siddhababa Spiritual Academy`</code> center.
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row card-footer d-flex justify-content-between">
                    <div class="col-md-3 text-right">
                        <a href="{{ route('dashboard') }}" class="text-muted">- Pay Later, Go To Dashboard</a>
                    </div>
                    @if((site_settings('online_payment') || user()->role_id == 1) && getUserCountry() == "NP")
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            Confirm Payment Method
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </form>
</div>
@endsection

@push("page_css")
<style type="text/css">
    input[type="radio"]+label:before {
        border-radius: 50%;
        color: red;
        border: 2px solid !important;
    }
</style>
@endpush
@push("page_script")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    var paymentMode = $("#regural_medicine_history").val();

    function paymentType() {

    }
</script>
@endpush