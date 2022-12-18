    <form id="vendantaRegistration" action="{{ route('vedanta.store_two') }}" method="post">
        @csrf
        <div class="row mt-3">
            <div class="col-md-12 d-flex justify-content-center">
                <h2 class="theme-text fw-bold">हिमालयन सिद्घमहायोग - वेदान्त दर्शन</h2>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-7 border-end border-theme">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="theme-text">
                            Health Background
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regural_medicine_history" class="mb-4">
                                Are you currently taking any regular medicine ?
                            </label>
                            <select name="regural_medicine_history" id="regural_medicine_history" class="mt-2 form-control detail">
                                <option value="no" @if($user_record['midicine_history']=='no' ) selected @endif>No</option>
                                <option value="yes" @if($user_record['midicine_history']=='yes' ) selected @endif>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mental_health_history">Are you currently taking any regular medicine for mental health issues or have taken such medicine in past ?
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="mental_health_history" id="mental_health_history" class="form-control detail">
                                <option value="no" @if($user_record['mental_health_history']=='no' ) selected @endif>No</option>
                                <option value="yes" @if($user_record['mental_health_history']=='yes' ) selected @endif>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 @if($user_record['mental_health_history']=='no' && $user_record['midicine_history'] =='no') d-none @endif" id="health_detail">
                    <div class=" col-md-6 mt-2">
                        <div class="form-group">
                            <label for="label-control">
                                Please describe your health problem in detail.
                            </label>
                            <textarea style="resize:none" class="form-control @if($user_record['midicine_history'] =='no') d-none  @endif detailBox" id="regural_medicine_history_detail" name="regular_medicine_history_detail" @if($user_record['midicine_history']=='yes' ) required @endif>{{ $user_record['regular_medicine_history_detail'] }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                            <label for="label-control">
                                Please describe your mental health problem in detail.
                            </label>
                            <textarea style="resize:none" class="form-control @if($user_record['mental_health_history'] =='no') d-none  @endif detailBox " name="mental_health_detail_problem" id="mental_health_history_detail" @if($user_record['mental_health_history']=='yes' ) required @endif>{{ $user_record['mental_health_detail_problem']}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="contact_person">Have you practiced any meditation techniques, cure technique or any other technique ?
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="practiced_info" id="practiced_info" class="form-control ">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="support_in_need">Would you be willing to provide support to the ashram, if requested?
                                <sup class="text-danger">
                                    *
                                </sup>
                            </label>
                            <select name="support_in_need" id="support_in_need" class="form-control ">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 mt-3">
                        <h4 class="theme-text">
                            Terms & Condition. *
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p class="text-dark">
                            I solemnly swear that I will maintain the sanctity of being a sadhak (disciple) of His Divine Grace Jagadguru Ramanandacharya Swami RamKrishna Acharya Maharaj Ji (Mahayogi Siddhababa). I know the process of being a disciple and being initiated into Siddha Mahayog Sadhana can happen only with Jagatguru Mahayogi Siddhababa's Grace and I am only a tool in this sacred tradition. It is the rarest blessing that I will engrave in my heart, honor and cherish. I will never misuse Jagatguru Mahayogi Siddhababa’s name or organization(s) for my personal gain. I commit myself sincerely and loyally. I claim responsibility for any consequences that may arise if I do not properly follow the instructions given about this sadhana.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class=" d-flex justify-content-start align-items-center">
                                <input type="checkbox" id="terms_and_condition" name="terms_and_condition" value="1" class="border border-danger text-danger" style="height:30px; width:30px;">
                                <label for="terms_and_condition" class="mb-0 ms-2 fs-4 text-danger pt-0 mt-0">{{ __("sadhana.sadhan_terms_and_condition_label") }}</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5 ps-2">

                <div class="col-md-12">
                    <h4 class="theme-text">
                        साधना तथा वेदान्त दर्शन कक्षा नियमावलीहरूः
                    </h4>
                </div>

                <div class="col-md-12 my-2">
                    <ol class="text-dark list-group" style="list-style: none !important;">
                        <li class="mb-1">
                            १. पहिलो चरणको साधनामा प्रवेश गर्न कम्तीमा १ वर्षसम्म कम से कम ३ सय घण्टा नियमित रूपमा आवद्ध हुनुपर्नेछ ।
                        </li>
                        <li class="mb-1">
                            २. दैनिक १ घण्टाको दरले आफूलाई जसले बनायो, जसको प्रति तपाईं आस्था राख्नुहुन्छ उसको नाममा आफ्नो लागि जे जस्तो अवस्थामा भए पनि अन्य केही कार्य नगरी छुट्याउनुपर्दछ ।

                        </li>
                        <li class="mb-1">
                            ३. साधना कक्षा सुरु हुने समय भन्दा १० मिनेट अगाडि उपलब्ध गराइएको क्ष्म् र एब्क्क्ध्इच्म् राखेर सत्सङ्ग पोटलमा प्रवेश गरी सक्नु पर्नेछ ।

                        </li>
                        <li class="mb-1">
                            ४. साधनामा बस्दा पहेँलो वा सेतो रङको नेपाली पोसाक लगाएर आफ्नो आसनमा बस्नु पर्दछ । पहेँलो, सेतो, गेहेरु अथवा ऊनीको राडी आसनको लागि उत्तम मानिन्छ ।

                        </li>
                        <li class="mb-1">
                            ५. साधनामा बस्दा साधकले अनिवार्य रूपमा उध्र्वपूण्ड्र तिलक लगाएर बस्नु पर्नेछ । साथै आफूलाई साधनामा बस्दा चाहिने सामानहरू (जपमाला, आचमनी, पञ्चपात्र, जल र आसन) कक्षा सुरु हुनुभन्दा पूर्व नै व्यवस्थित गरेर बस्नु पर्दछ ।
                        </li>
                        <li class="mb-1">
                            ६. साधना तथा सत्सङ्ग अवधिभरि एकाग्र भई सद्गुरुदेवबाट निर्देशित उपदेशहरू ध्यान पूर्वक ग्रहण गर्दै चिन्तन गर्नु साधकका लागि अत्यन्त महत्वपूर्ण हुन्छ ।

                        </li>
                        <li class="mb-1">
                            ७. साधनामा बस्दा आँफूमा उत्पन्न जिज्ञासाहरूलाई टिपोट गरेर राख्नुपर्दछ र जिज्ञासाका लागि छुटयाइएको “जिज्ञासा समाधान सेसनमा” राख्नुपर्दछ ।

                        </li>
                        <li class="mb-1">
                            ८. प्रत्येक विषय वस्तुको परीक्षा साधकले अनिवार्य रूपमा दिनु पर्ने हुन्छ जसका लागि साधकले आफूलाई नियमित अभ्यास गर्दै तयार राख्नु पर्दछ ।

                        </li>
                        <li class="mb-1">
                            ९. जब जब सद्गुरुदेवसँग प्रत्यक्ष जिज्ञासा राख्ने अवसर मिल्दछ तब तब आफू अत्यन्त मर्यादित भइ विनम्रताका साथ प्रस्तुत हुनु पर्दछ । मर्यादा र अनुशासनका लागि पनि परीक्षामा अङ्ग छुटयाइने भएकाले उल्लेखित विषयमा साधकले सतर्कता अपनाउनु पर्नेछ ।

                        </li>
                        <li class="mb-1">
                            १०. यो अत्यन्त दुर्लभ जीवन उपयोगी साधना कक्षा भएकाले यसको दुर्लभता र महत्वलाई उच्च मनोवलका साथ अध्ययन गर्नु पर्दछ ।

                        </li>
                        <li class="mb-1">
                            ११. प्रत्येक कक्षामा साधकको उपस्थिति अनिवार्य रहेको छ । कुनै विशेष कारणवश कक्षामा अनुपस्थिति जनाउनु पर्दा एक दिन अगावै <em>PORTAL</em> मा <em>LOGIN</em> गरेर <em>EVENT</em> भित्र गएर <em>ABSENT FORM</em> मा कारण सहित उल्लेख गर्नुपर्नेछ ।
                        </li>
                        <li class="mb-1">
                            १२.अष्टमी, संक्रान्ति, प्रतिपदा, पूर्णिमा, औँसी र विशेष पर्वमा कक्षा सञ्चालन हुने छैन ।

                        </li>
                        <li class="mb-1">
                            १३. साधना समागममा बस्दा अनिवार्य रूपमा आफ्नो भिडियो खोलेर आफ्नो अनुहार प्रस्ट रूपमा देखिने गरी बस्नु पर्नेछ । यदि त्यसो नगरेको खण्डमा सो दिनका लागि साधकले समागबाट बञ्चित हुनु पर्नेछ ।
                        </li>
                        <li class="mb-1">
                            १४. विषयवस्तुको <em>OFFLINE VIDEO</em> सोहि विषय वस्तुको परीक्षा पश्चात् हटाइने छ । वेदान्त कार्यलयको आचार संहिता विपरित कसैले सोे भिडियोको दुरुपयोग गरेको खण्डमा नियम बमोजिमको सजाय भोग्नु पर्दछ ।
                        </li>
                        <li class="mb-1">
                            १५. समस्याका हेतु उपलब्ध गराइएको हट लाइन नम्बर ९८५२०६६००९ बिहान १० बजेदेखि बेलुका ५ बजेसम्म मात्र चालु रहने छ । सो समय भन्दा अघिपछि हजुरहरूले आफ्नो समस्या राखिहाल्नु परेमा उपलब्ध नम्बरमा <em>WHATSAPP</em> र मेसेज द्वारा राख्न सक्नुहुनेछ।
                        </li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger px-5 w-100 fs-3">
                            Next
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script>
        $("select").change(function(event) {
            healthToggle();
            descriptionBox = $('form').find($("#" + $(this).attr("id") + "_detail"));
            if ($(this).val() == "yes") {
                $(descriptionBox).closest('div.form-group').removeClass('d-none');
                if ($(descriptionBox).length) {
                    $(descriptionBox[0]).fadeIn('medium', function() {
                        $(this).removeClass('d-none');
                        $(this).attr('required', true);
                    })
                }
                return;
            }
            $(descriptionBox).closest('div.form-group').addClass('d-none');
            $(descriptionBox).removeAttr('required').addClass('d-none');
        });

        function healthToggle() {

            let selectElement = $(".detail");
            console.log('all Element', selectElement);
            let hide = false;
            $.each(selectElement, function(index, element) {

                if ($(element).val() == "yes") {
                    $("#health_detail").removeClass('d-none');
                    hide = true;
                    return;
                }
            });
            console.log("Hide: ", hide);
            if (!hide) {
                $("#health_detail").addClass('d-none');
            } else {
                $("#health_detail").removeClass('d-none');
            }
        }

        $('form#vendantaRegistration').submit(function(event) {
            event.preventDefault();
            return formSubmit(this);
        })
    </script>