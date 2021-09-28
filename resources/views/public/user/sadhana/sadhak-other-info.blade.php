@extends("layouts.guest")

@section("style")

    <style>

        /*page styling*/
        .bs-callout {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #eee;
            border-image: none;
            border-radius: 3px;
            border-style: solid;
            border-width: 1px 1px 1px 5px;
            margin-bottom: 5px;
            padding: 20px;
        }
        .bs-callout:last-child {
            margin-bottom: 0px;
        }
        .bs-callout h4,
        .bs-callout h5 {
            margin-bottom: 10px;
            margin-top: 0;
            font-weight: 600;
        }

        .bs-callout-danger {
            border-left-color: #d9534f;
        }

        .bs-callout-danger h4,
        .bs-callout-danger h5{
            color: #d9534f;
        }

        .bs-callout-primary {
            border-left-color: #09a2ea;
        }

        .bs-callout-primary h4,
        .bs-callout-primary h5{
            color: #09a2ea;
        }

        .header-title {
            color: #fff;
        }
        .title-thin {
            font-weight: 300;
        }
        .service-item {
            margin-bottom: 30px;
        }

        blockquote
        {
            font-size: 80% !important;
            page-break-inside: avoid;
            border: 3px solid #fff;
            width: 80%;
            -webkit-box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
            -mox-box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
            -ms-box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
                box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
            
            padding: 10px 20px;
            margin: 0 0 20px;
            font-size: 17.5px;
            border-left: none;
        }
        .funkyradio div {
            clear: both;
            overflow: hidden;
            }

            .funkyradio label {
            width: 100%;
            border-radius: 3px;
            border: 1px solid #D1D3D4;
            font-weight: normal;
            }

            .funkyradio input[type="radio"]:empty,
            .funkyradio input[type="checkbox"]:empty {
            display: none;
            }

            .funkyradio input[type="radio"]:empty ~ label,
            .funkyradio input[type="checkbox"]:empty ~ label {
            position: relative;
            line-height: 2.5em;
            text-indent: 3.25em;
            margin-top: 2em;
            cursor: pointer;
            -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                    user-select: none;
            }

            .funkyradio input[type="radio"]:empty ~ label:before,
            .funkyradio input[type="checkbox"]:empty ~ label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #D1D3D4;
            border-radius: 3px 0 0 3px;
            }

            .funkyradio input[type="radio"]:hover:not(:checked) ~ label,
            .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
            color: #888;
            }

            .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
            .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
            content: '\2714';
            text-indent: .9em;
            color: #C2C2C2;
            }

            .funkyradio input[type="radio"]:checked ~ label,
            .funkyradio input[type="checkbox"]:checked ~ label {
            color: #777;
            }

            .funkyradio input[type="radio"]:checked ~ label:before,
            .funkyradio input[type="checkbox"]:checked ~ label:before {
            content: '\2714';
            text-indent: .9em;
            color: #333;
            background-color: #ccc;
            }

            .funkyradio input[type="radio"]:focus ~ label:before,
            .funkyradio input[type="checkbox"]:focus ~ label:before {
            box-shadow: 0 0 0 3px #999;
            }

            .funkyradio-default input[type="radio"]:checked ~ label:before,
            .funkyradio-default input[type="checkbox"]:checked ~ label:before {
            color: #333;
            background-color: #ccc;
            }

            .funkyradio-primary input[type="radio"]:checked ~ label:before,
            .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #337ab7;
            }

            .funkyradio-success input[type="radio"]:checked ~ label:before,
            .funkyradio-success input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #5cb85c;
            }

            .funkyradio-danger input[type="radio"]:checked ~ label:before,
            .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #d9534f;
            }

            .funkyradio-warning input[type="radio"]:checked ~ label:before,
            .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #f0ad4e;
            }

            .funkyradio-info input[type="radio"]:checked ~ label:before,
            .funkyradio-info input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #5bc0de;
            }


    </style>
    
@endsection
@section("content")
        <x-alert></x-alert>
        <div class='row'>   
            <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-12 col-lg-offset-2 col-lg-12">
                @php
                    $param = Request::query();
                    array_unshift($param,$user->id);
                @endphp
                <form method="post" action="{{ $signature }}">
                    @csrf
                    <div class="card card-default">
                        <div class="bs-callout @error('is_alone') bs-callout-danger @else bs-callout-primary @enderror" >
                            <h4 class=''>{{ __('sadhak_registration.do_you_have_any_relative_staying_with_you_in_this_camp')}}</h4>
                            <p>
                                    {{ __('sadhak_registration.do_you_have_any_relative_staying_with_your_in_this_camp_description') }}
                            </p>

                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="is_alone" @if(old('is_alone') == 'yes') checked @endif value="yes" id="is_alone_yes" />
                                            <label for="is_alone_yes">{{ __('sadhak_registration.yes_i_am_alone') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="is_alone" @if(old('is_alone') == "no" )  checked @endif value="no" id="is_alone_no" />
                                            <label for="is_alone_no">{{ __('sadhak_registration.no_i_am_not_alone') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row not_alone mt-4 py-2' @if(old("is_alone") == 'no') style="display:block" @else style="display:none" @endif>
                                <h4>{{ __('sadhak_registration.your_anser') }} : {{ __('sadhak_registration.no_i_am_not_alone') }}</h4>
                                <div class="row">
                                    <div class='col-md-6'>
                                        <label class='control-label @error("relative_name") text-danger @enderror'>{{ __('sadhak_registration.full_name') }}</label>
                                        <input type="text" value="{{ old('relative_name') }}" name='relative_name' class='form-control' />
                                    </div>
                                    <div class='col-md-6'>
                                        <label class='control-label @error("relative_relation") text-danger  @enderror'>{{ __('sadhak_registration.relation') }}</label>
                                        <input type="text" value="{{ old('relative_relation') }}" name='relative_relation' class='form-control' />
                                    </div>
                                    <div class='col-md-6'>
                                        <label class='control-label @error("relative_relation_contact") text-danger  @enderror'>{{ __('sadhak_registration.contact_number') }}</label>
                                        <input type="text" value="{{ old('relative_relation_contact') }}" name='relative_relation_contact' class='form-control' />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bs-callout @error('first_visit') bs-callout-danger @else bs-callout-primary  @enderror" >
                            <h4 class=''>{{ __('sadhak_registration.have_you_previously_stayed_in_siddha_mahayog_dhyan_sibir')}}</h4>
                            <p>
                                    {{ __('sadhak_registration.have_you_previously_stayed_in_siddha_mahayog_dhyan_sibir_description') }}
                            </p>

                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="first_visit" @if(old('first_visit') == 'yes') checked @endif value="yes" id="first_visit_yes" />
                                            <label for="first_visit_yes">{{ __('sadhak_registration.yes') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="first_visit" @if(old('first_visit') == "no" )  checked @endif value="no" id="first_visit_no" />
                                            <label for="first_visit_no">{{ __('sadhak_registration.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='bs-callout @error("physical_difficulties") bs-callout-danger @else bs-callout-primary @enderror'>
                            <h4> {{ __('sadhak_registration.do_you_have_any_physical_difficulties') }}</h4>
                            <p>{{ __('sadhak_registration.physical_difficulties_description_detail') }}</p>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="physical_difficulties" @if(old('physical_difficulties') == 'yes') checked @endif value="yes" id="physical_difficulties_yes" />
                                            <label for="physical_difficulties_yes">{{ __('sadhak_registration.yes') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="physical_difficulties" @if(old('physical_difficulties') == "no" )  checked @endif value="no" id="physical_difficulties_no" />
                                            <label for="physical_difficulties_no">{{ __('sadhak_registration.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row mt-4 physical_difficulties py-4' style="display:@if(old('physical_difficulties') == 'yes') block @else none @endif">
                                <h4>{{ __('sadhak_registration.your_anser') }} : {{ __('sadhak_registration.yes') }}</h4>
                                <p>{{ __('sadhak_registration.mental_health_description') }}</p>
                                <div class='col-md-12'>
                                    <label class='control-label @error("health_problem_description") text-danger @enderror'>
                                    {{__('sadhak_registration.mental_health_description_label')}}
                                    </label>
                                    <textarea class="form-control" name="health_problem_description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class='bs-callout @error("mental_health") bs-callout-danger @else bs-callout-primary @enderror'>
                            <h4> {{ __('sadhak_registration.do_you_have_any_mental') }}</h4>
                            <p>{{ __('sadhak_registration.mental_health_description_paragraph') }}</p>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="mental_health" @if(old('user_registration') == 'yes') checked @endif value="yes" id="mental_health_yes" />
                                            <label for="mental_health_yes">{{ __('sadhak_registration.yes') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="mental_health" @if(old('user_registration') == "no" )  checked @endif value="no" id="mental_health_no" />
                                            <label for="mental_health_no">{{ __('sadhak_registration.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row mental_health mt-4  py-4' style="display:@if(old('mental_health') == 'yes') block @else none @endif">
                                <h4>{{ __('sadhak_registration.your_anser') }} : {{ __('sadhak_registration.yes') }}</h4>
                                <p>{{ __('sadhak_registration.mental_health_description') }}</p>
                                <div class='col-md-12'>
                                    <label class='control-label @error("mental_problem_description") text-danger @enderror'>
                                       {{__('sadhak_registration.mental_health_description_label')}}
                                    </label>
                                    <textarea class="form-control" name="mental_problem_description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class='bs-callout @error("practiced_before") bs-callout-danger @else bs-callout-primary @enderror'>
                            <h4> {{ __('sadhak_registration.have_you_practiced_any_meditation_technique') }}</h4>
                            <p>{{ __('sadhak_registration.meditation_technique_description') }}</p>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="practiced_before" @if(old('practiced_before') == 'yes') checked @endif value="yes" id="registration_first" />
                                            <label for="registration_first">{{ __('sadhak_registration.yes') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="practiced_before" @if(old('practiced_before') == "no" )  checked @endif value="no" id="already_register" />
                                            <label for="already_register">{{ __('sadhak_registration.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='bs-callout bs-callout-primary'>
                            <h4> {{ __('sadhak_registration.how_did_you_hear_about_us') }}</h4>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <input type="text" class='form-control' name="our_ads_source" />
                                </div>
                            </div>
                        </div>

                        <div class='bs-callout bs-callout-primary'>
                            <h4> {{ __('sadhak_registration.will_you_provide_your_service_to_ashram_incase') }}</h4>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <div class="funkyradio">
                                                <div class="funkyradio-success">
                                                    <input type="radio" name="support_yes" @if(old('support_yes') == 'yes') checked @endif value="yes" id="support_yes" />
                                                    <label for="support_yes">{{ __('sadhak_registration.yes') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class="funkyradio">
                                                <div class="funkyradio-success">
                                                    <input type="radio" name="support_yes" @if(old('support_yes') == "no" )  checked @endif value="no" id="support_no" />
                                                    <label for="support_no">{{ __('sadhak_registration.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='bs-callout @error("terms_and_condition") bs-callout-danger @else bs-callout-primary @enderror'>
                            <h4>{{ __('sadhak_registration.terms_and_condition') }}</h4>
                            <p>
                                {{ __('sadhak_registration.terms_and_condition_text') }}
                            </p>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class='control-label'>
                                    <input type="checkbox" value="1" required name="terms_and_condition" />
                                        {{ __('sadhak_registration.agree_terms_and_condition') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class='card card-footer'>
                        <button type="submit" class='btn btn-primary'>{{ __('sadhak_registration.submit_application') }}</button>
                    </div>
                </form>
            </div>
        </div>
@endsection

@section("footer_script")
    <script type="text/javascript">
        $("input[name='is_alone']").change(function(){
            if (this.value == "no") {
                $('.not_alone').fadeIn('medium',function (){
                    $(this).addClass('bg-warning');
                })
            } else {
                $('.not_alone').fadeOut('fast',function (){
                    $(this).removeClass('bg-warning');
                });
            }
        })

        $("input[name='physical_difficulties']").change(function() {
            if(this.value == 'yes'){
                $('.physical_difficulties').fadeIn('medium',function (){
                    $(this).addClass('bg-warning');
                })
            } else {
                $('.physical_difficulties').fadeOut('fast',function(){
                    $(this).removeClass('bg-warning')
                })
            }
        })
        $("input[name='mental_health']").change(function() {
            if(this.value == 'yes'){
                $('.mental_health').fadeIn('medium',function (){
                    $(this).addClass('bg-warning');
                })
            } else {
                $('.mental_health').fadeOut('fast',function(){
                    $(this).removeClass('bg-warning')
                })
            }
        })
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
@endsection