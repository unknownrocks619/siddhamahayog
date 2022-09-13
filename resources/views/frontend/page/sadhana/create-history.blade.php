@extends("frontend.theme.master")
@section("content")
<div class="sigma_subheader dark-overlay dark-overlay-2" style="background-image: url({{ asset('themes/om/assets/img/events/sadhana/sadhana-banner.jpg') }})">

    <div class="container">
        <div class="sigma_subheader-inner" style="align-items: flex-start">
            <div class="sigma_subheader-text">
                <h1 style="color:#db4242">Mahayog Sadhana</h1>
            </div>
        </div>
    </div>
</div>

<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <form action="{{ route('sadhana.store.history') }}" method="post">
        @csrf
        @google_captcha()
        <div class="container">
            <div class="row sigma_broadcast-video my-3">
                <div class="col-md-12 mx-auto">
                    <x-alert></x-alert>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">
                                {{ __("sadhana.sadhana_extra_health_heading") }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="regural_medicine_history" class="mb-4">
                                            {{ __("sadhana.sadhana_medicine_history_label") }}
                                        </label>
                                        <select name="regural_medicine_history" id="regural_medicine_history" class="mt-2 form-control @error('regural_medicine_history') border border-danger @enderror">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mental_health_history">{{ __("sadhana.sadhana_medicine_mental_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="mental_health_history" id="mental_health_history" class="form-control @error('mental_health_history') border border-danger @enderror">
                                            <option value="no" @if(old('mental_health_history')=="no" ) selected @endif>No</option>
                                            <option value="yes" @if(old('mental_health_history')=="yes" ) selected @endif>Yes</option>
                                        </select>
                                        @error("mental_health_history")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row  mt-2 d-none" id="regular_health_detail">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="label-control">
                                            {{ __('sadhana.sadhana_medicine_history_detail_label') }}
                                        </label>
                                        <textarea class="form-control @error('regular_medicine_history_detail') border border-danger @enderror" id="regular_medicine_history_detail" name="regular_medicine_history_detail" class="regular_medicine_history_detail">{{old('regular_medicine_history_detail')}}</textarea>
                                        @error('regular_medicine_history_detail')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none mt-2" id="mental_health_hisotry_detail">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="label-control">
                                            {{ __('sadhana.sadhana_medicine_mental_detail_label') }}
                                        </label>
                                        <textarea class="form-control @error('mental_health_detail_problem') border border-danger @enderror" name="mental_health_detail_problem" id="mental_health_detail_problem" class="mental_health_detail_problem">{{old('mental_health_detail_problem')}}</textarea>
                                        @error('mental_health_detail_problem')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row sigma_broadcast-video my-3">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">
                                {{ __("sadhana.sadhana_extra_info_heading") }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_person">{{ __("sadhana.sadhana_practiced_history_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="practiced_info" id="practiced_info" class="form-control @error('practiced_info') border border-danger @enderror">
                                            <option value="no" @if(old('practiced_info')=="no" ) selected @endif>No</option>
                                            <option value="yes" @if(old('practiced_info')=="yes" ) selected @endif>Yes</option>
                                        </select>
                                        @error("practiced_info")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="support_in_need">{{ __('sadhana.support_ashram_in_need') }}
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <select name="support_in_need" id="support_in_need" class="form-control @error('support_in_need') border border-danger @enderror">
                                            <option value="yes" @if(old('support_in_need')=="yes" ) selected @endif>Yes</option>
                                            <option value="no" @if(old('support_in_need')=="no" ) selected @endif>No</option>
                                        </select>
                                        @error("support_in_need")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row sigma_broadcast-video my-3">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <h3 for="terms_and_condition">
                                    {{ __("sadhana.sadhan_terms_and_condition_heading") }}
                                    <sup class="text-danger">*</sup>
                                </h3>
                            </div>
                            <p>{{ __("sadhana.sadhan_terms_and_condition") }}</p>
                            <div class="d-flex align-items-center ms-4">
                                <input type="radio" id="terms_and_condition" name="terms_and_condition" value="1" class="border border-danger">
                                <label for="terms_and_condition" class="mb-0">{{ __("sadhana.sadhan_terms_and_condition_label") }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-outline-primary enroll-sadhana disabled" disabled=true>Join Sadhana</button>
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
    $(document).ready(function() {
        $("#regural_medicine_history").change(function() {
            if ($(this).val() == "yes") {
                $("#regular_health_detail").fadeIn("fast", function() {
                    $(this).removeClass("d-none")
                    $(this).find("textarea").prop("required", true);
                })
            } else {
                $("#regular_health_detail").fadeOut('medium', function() {
                    $(this).addClass("d-none")

                    $(this).find('textarea').prop("required", false)
                })
            }
        })

        $("#mental_health_history").change(function() {
            if ($(this).val() == "yes") {
                console.log("mental health " + $(this).val());
                $("#mental_health_hisotry_detail").fadeIn("fast", function() {
                    $(this).removeClass("d-none")
                    $(this).find("textarea").prop("required", true);
                })
            } else {
                $("#mental_health_hisotry_detail").fadeOut("fast", function() {
                    $(this).addClass("d-none")
                    $(this).find("textarea").prop("required", false);
                })
            }
        })
    })

    $("input#terms_and_condition").change(function() {
        if ($(this).val() == 1) {
            $("button.enroll-sadhana").prop('disabled', false).removeClass('disabled btn btn-outline-primary').addClass("btn btn-primary")
        }
    })

    $(document).click("button.enroll-sadhana", function(event) {
        if ($(this).hasClass("disabled")) {
            alert("Please accept terms and condition before getting enrolled in program.");
            return false;
        }
    })
</script>
@endpush