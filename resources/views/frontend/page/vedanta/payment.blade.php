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
    <form action="{{ route('dashboard') }}" method="get">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="regural_medicine_history" class="mb-4">
                                            Payment Method
                                        </label>
                                        <select name="regural_medicine_history" id="regural_medicine_history" class="mt-2 form-control @error('regural_medicine_history') border border-danger @enderror">
                                            <!-- <option value="esewa">E-Sewa</option> -->
                                            <option value="later" selected>Pay Later</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_amount">Payment Amount
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <input type="text" value="NRs. {{ number_format($program->active_fees->admission_fee,2,'.',',') }}" name="amount" id="amount" disabled class="form-control disabled" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row card-footer">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Go to Dashboard</button>
                </div>
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