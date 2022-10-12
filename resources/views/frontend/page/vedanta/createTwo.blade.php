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
    <form action="{{ route('vedanta.store_two') }}" method="post">
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
                            <h3 class="text-center">
                                Membership Info
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="are_you_sadhak">Are you a sadhak ?
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="user_sadhak" id="user_sadhak" class="form-control @error('user_sadhak') border border-danger @enderror">
                                            <option value="no" @if(old('user_sadhak')=="no" ) selected @endif>No</option>
                                            <option value="yes" @if(old('user_sadhak')=="yes" ) selected @endif>Yes</option>
                                        </select>
                                        @error("user_sadhak")
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
                            <p class="fs-4 text-dark">{{ __("sadhana.sadhan_terms_and_condition") }}</p>
                            <div class="form-group">
                                <h5>
                                    {{ __("sadhana.sadhana_rules_regulation_title") }}
                                </h5>
                                <ol class="fs-4 text-dark">
                                    <li>
                                        १. पहिलो चरणको साधनामा प्रवेश गर्न कम्तीमा १ वर्षसम्म कम से कम ३ सय घण्टा नियमित रूपमा आवद्ध हुनुपर्नेछ ।
                                    </li>
                                    <li>
                                        २. दैनिक १ घण्टाको दरले आफूलाई जसले बनायो, जसको प्रति तपाईं आस्था राख्नुहुन्छ उसको नाममा आफ्नो लागि जे जस्तो अवस्थामा भए पनि अन्य केही कार्य नगरी छुट्याउनुपर्दछ ।

                                    </li>
                                    <li>
                                        ३. साधना कक्षा सुरु हुने समय भन्दा १० मिनेट अगाडि उपलब्ध गराइएको क्ष्म् र एब्क्क्ध्इच्म् राखेर सत्सङ्ग पोटलमा प्रवेश गरी सक्नु पर्नेछ ।

                                    </li>
                                    <li>
                                        ४. साधनामा बस्दा पहेँलो वा सेतो रङको नेपाली पोसाक लगाएर आफ्नो आसनमा बस्नु पर्दछ । पहेँलो, सेतो, गेहेरु अथवा ऊनीको राडी आसनको लागि उत्तम मानिन्छ ।

                                    </li>
                                    <li>
                                        ५. साधनामा बस्दा साधकले अनिवार्य रूपमा उध्र्वपूण्ड्र तिलक लगाएर बस्नु पर्नेछ । साथै आफूलाई साधनामा बस्दा चाहिने सामानहरू (जपमाला, आचमनी, पञ्चपात्र, जल र आसन) कक्षा सुरु हुनुभन्दा पूर्व नै व्यवस्थित गरेर बस्नु पर्दछ ।
                                    </li>
                                    <li>
                                        ६. साधना तथा सत्सङ्ग अवधिभरि एकाग्र भई सद्गुरुदेवबाट निर्देशित उपदेशहरू ध्यान पूर्वक ग्रहण गर्दै चिन्तन गर्नु साधकका लागि अत्यन्त महत्वपूर्ण हुन्छ ।

                                    </li>
                                    <li>
                                        ७. साधनामा बस्दा आँफूमा उत्पन्न जिज्ञासाहरूलाई टिपोट गरेर राख्नुपर्दछ र जिज्ञासाका लागि छुटयाइएको “जिज्ञासा समाधान सेसनमा” राख्नुपर्दछ ।

                                    </li>
                                    <li>
                                        ८. प्रत्येक विषय वस्तुको परीक्षा साधकले अनिवार्य रूपमा दिनु पर्ने हुन्छ जसका लागि साधकले आफूलाई नियमित अभ्यास गर्दै तयार राख्नु पर्दछ ।

                                    </li>
                                    <li>
                                        ९. जब जब सद्गुरुदेवसँग प्रत्यक्ष जिज्ञासा राख्ने अवसर मिल्दछ तब तब आफू अत्यन्त मर्यादित भइ विनम्रताका साथ प्रस्तुत हुनु पर्दछ । मर्यादा र अनुशासनका लागि पनि परीक्षामा अङ्ग छुटयाइने भएकाले उल्लेखित विषयमा साधकले सतर्कता अपनाउनु पर्नेछ ।

                                    </li>
                                    <li>
                                        १०. यो अत्यन्त दुर्लभ जीवन उपयोगी साधना कक्षा भएकाले यसको दुर्लभता र महत्वलाई उच्च मनोवलका साथ अध्ययन गर्नु पर्दछ ।

                                    </li>
                                    <li>
                                        ११. प्रत्येक कक्षामा साधकको उपस्थिति अनिवार्य रहेको छ । कुनै विशेष कारणवश कक्षामा अनुपस्थिति जनाउनु पर्दा एक दिन अगावै <em>PORTAL</em> मा <em>LOGIN</em> गरेर <em>EVENT</em> भित्र गएर <em>ABSENT FORM</em> मा कारण सहित उल्लेख गर्नुपर्नेछ ।
                                    </li>
                                    <li>
                                        १२.अष्टमी, संक्रान्ति, प्रतिपदा, पूर्णिमा, औँसी र विशेष पर्वमा कक्षा सञ्चालन हुने छैन ।

                                    </li>
                                    <li>
                                        १३. साधना समागममा बस्दा अनिवार्य रूपमा आफ्नो भिडियो खोलेर आफ्नो अनुहार प्रस्ट रूपमा देखिने गरी बस्नु पर्नेछ । यदि त्यसो नगरेको खण्डमा सो दिनका लागि साधकले समागबाट बञ्चित हुनु पर्नेछ ।
                                    </li>
                                    <li>
                                        १४. विषयवस्तुको <em>OFFLINE VIDEO</em> सोहि विषय वस्तुको परीक्षा पश्चात् हटाइने छ । वेदान्त कार्यलयको आचार संहिता विपरित कसैले सोे भिडियोको दुरुपयोग गरेको खण्डमा नियम बमोजिमको सजाय भोग्नु पर्दछ ।
                                    </li>
                                    <li>
                                        १५. समस्याका हेतु उपलब्ध गराइएको हट लाइन नम्बर ९८५२०६६००९ बिहान १० बजेदेखि बेलुका ५ बजेसम्म मात्र चालु रहने छ । सो समय भन्दा अघिपछि हजुरहरूले आफ्नो समस्या राखिहाल्नु परेमा उपलब्ध नम्बरमा <em>WHATSAPP</em> र मेसेज द्वारा राख्न सक्नुहुनेछ।
                                    </li>
                                </ol>
                            </div>
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
                    <button type="submit" class="btn btn-primary disabled enroll-sadhana">Continue</button>
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