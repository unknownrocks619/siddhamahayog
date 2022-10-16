@extends("frontend.theme.master")
@section("content")
<div class="sigma_subheader dark-overlay dark-overlay-2" style="background-image: url({{ asset('assets/images/program/vedanta/heading-banner.jpg') }})">

    <div class="container">
        <div class="sigma_subheader-inner" style="align-items: flex-start">
            <div class="sigma_subheader-text">
                <h1 style="color:#db4242">Vedanta Philosophy: <br /> Arthapanchaka<br />(Tatva-Gyan)</h1>
            </div>
        </div>
    </div>
</div>

<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <form action="{{ route('vedanta.store') }}" id="sadhanForm" method="post">
        @csrf
        @google_captcha()
        <div class="container">
            <div class="row sigma_broadcast-video">
                <div class="col-md-12 mx-auto ">
                    <div class="card">
                        <div class="card-body">
                            <x-alert></x-alert>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="first_name">{{ __("sadhana.first_name_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="first_name" class="form-control @error('first_name') border border-danger @enderror" value="{{ old('first_name',auth()->user()->first_name) }}" />
                                        @error("first_name")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_name">{{ __("sadhana.middle_name_label") }}</label>
                                        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name',auth()->user()->middle_name) }}" class="form-control @error('middle_name') border border-danger @enderror" />
                                        @error("middle_name")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last_name">{{ __("sadhana.last_name_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') border border-danger @enderror" value="{{ old('last_name',auth()->user()->last_name) }}">
                                        @error("last_name")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male" @if(old('gender',auth()->user()->gender) == "male") selected @endif>Male</option>
                                            <option value="male" @if(old('gender',auth()->user()->gender) == "female") selected @endif>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_number">Mobile Number
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') border border-danger @enderror" value="{{ old('phone_number',auth()->user()->phone_number) }}" />
                                        @error("phone_number")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="country" id="country" class="form-control countries">
                                            <?php
                                            $countries = \App\Models\Country::get();
                                            foreach ($countries as $country) {
                                                echo "<option value='{$country->id}'";
                                                if (auth()->user()->country == $country->id) {
                                                    echo "selected";
                                                }
                                                echo ">";
                                                echo $country->name .  "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <input type="text" value="{{ old('state',auth()->user()->city) }}" name="state" id="state" class="form-control select2-selection__rendered cities @error('state') border border-danger @enderror" />
                                        @error('state')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-8">
                                    <label for="street_address">Street Address
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <textarea name="street_address" id="street_address" class="form-control @error('street_address') border border-danger @enderror">{{ old('street_address',(auth()->user()->address) ? auth()->user()->address->street_address:null) }}</textarea>
                                    @error('street_address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_of_birth">{{ __("sadhana.date_of_birth_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input value="{{ old('date_of_birth', (auth()->user()->meta) ? auth()->user()->meta->personal->date_of_birth : null) }}" type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') border border-danger @enderror" />
                                        @error("date_of_birth")
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place_of_birth">{{ __("sadhana.place_of_birth_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth',(auth()->user()->meta) ? auth()->user()->meta->personal->place_of_birth : null) }}" class="form-control @error('place_of_birth') border border-danger @enderror">
                                        @error("place_of_birth")
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
                                {{ __("sadhana.personal_information_heading") }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="education">
                                            {{ __("sadhana.highest_education_label") }}
                                        </label>
                                        <?php
                                        $education = (auth()->user()->meta && auth()->user()->meta->education && auth()->user()->meta->education->education) ? auth()->user()->meta->education->education : null;
                                        $profession = (auth()->user()->meta && auth()->user()->meta->education && auth()->user()->meta->education->profession) ? auth()->user()->meta->education->profession : null;
                                        $education_major = (auth()->user()->meta && auth()->user()->meta->education && auth()->user()->meta->education->education_major) ? auth()->user()->meta->education->education_major : null;
                                        ?>
                                        <select name="education" id="education" class="form-control @error('education') border border-danger @enderror">
                                            <option value="primary" @if(old('education',$education)=="primary" ) selected @endif>Primary</option>
                                            <option value="secondary" @if(old('education',$education)=="secondary" ) selected @endif>Secondary (1-20 Class)</option>
                                            <option value="higher_secondary" @if(old('education',$education)=="higher_secondary" ) selected @endif>Higher Secondary (11 - 12 Class)</option>
                                            <option value="bachelor" @if(old('education',$education)=="bachelor" ) selected @endif>Bachelor</option>
                                            <option value="master" @if(old('education',$education)=="master" ) selected @endif>Masters</option>
                                            <option value="phd" @if(old('education',$education)=="phd" ) selected @endif>PhD</option>
                                            <option value="none" @if(old('education',$education)=="none" ) selected @endif>None</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profession">Profession
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="profession" value="{{ old('profession',$profession) }}" id="profession" class="form-control @error('profession') border border-danger @enderror" />
                                        @error("profession")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="field_of_study">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_of_study">
                                            {{ __("sadhana.education_major_label") }}
                                            <small class="text-info">
                                                {{ __("sadhana.education_major_detail") }}
                                            </small>
                                        </label>
                                        <input value="{{ old('field_of_study') }}" type="text" name="field_of_study" id="field_of_study" class="form-control @error('field_of_study') border border-danger @enderror">
                                        @error("field_of_study")
                                        <div class="text-danger">{{$message}}</div>
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
                                {{ __("sadhana.emergency_contact_heading") }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_person">{{ __("sadhana.emergency_contact_person_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="emergency_contact_person" value="{{ old('emergency_contact_person',(auth()->user()->emergency) ? auth()->user()->emergency->contact_person : null) }}" id="contact_person" class="form-control @error('emergency_contact_person') border border-danger @enderror" />
                                        @error('emergency_contact_person')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emergency_phone">{{ __('sadhana.emergency_contact_person_mobile_number_label') }}
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <input type="text" name="emergency_phone" id="emergency_phone" value="{{ old('emergency_phone',(auth()->user()->emergency) ? auth()->user()->emergency->phone_number : null) }}" class="form-control @error('emergency_phone') border border-danger @enderror">
                                        @error("emergency_phone")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emergency_contact_person_relation">{{ __("sadhana.relation_to_emergency_label") }}
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input value="{{ old('emergency_contact_person_relation',(auth()->user()->emergency) ? auth()->user()->emergency->relation : null) }}" type="text" name="emergency_contact_person_relation" id="emergency_contact_person_relation" class="form-control @error('emergency_contact_person_relation') border border-danger @enderror" />
                                        @error("emergency_contact_person_relation")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
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
                                {{ __("Reference Detail") }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="referer_person">
                                            Referer Person
                                        </label>
                                        <input value="{{ old('referer_person') }}" type="text" name="referer_person" id="referer_person" class="form-control @error('referer_person') border border-danger @enderror" />
                                        @error('referer_person')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="referer_relation">
                                            Relation
                                        </label>
                                        <input type="text" name="referer_relation" id="referer_relation" class="form-control @error('referer_relation') border border-danger @enderror" />
                                        @error('referer_relation')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="referer_contact">Referer Mobile Number</label>
                                    <input type="text" name="referer_contact" id="referer_contact" class="form-control @error('referer_contact') border border-danger @enderror" />
                                    @error('referer_contact')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row sigma_broadcast-video my-3">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Continue</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push("page_css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    label {
        color: #000;
    }

    .border-danger {
        border-color: #dc3545 !important
    }
</style>
@endpush

@push("page_script")
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.google.site_key') }}"></script>
<script>
    grecaptcha.ready(function() {
        document.getElementById('sadhanForm').addEventListener("submit", function(event) {
            $(this).children("input").prop('disabled');
            event.preventDefault();
            grecaptcha.execute("{{ config('captcha.google.site_key') }}", {
                    action: 'login'
                })
                .then(function(token) {
                    document.getElementById("recaptcha_token").value = token;
                    document.getElementById('sadhanForm').submit();
                });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".countries").select2({
            placeholder: "Choose Country or Region",
            class: "form-control",
            style: "width:100%"
        });
    })
</script>
@endpush