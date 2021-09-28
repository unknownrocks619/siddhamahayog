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
    <div class='row'>
        <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-12 col-lg-offset-2 col-lg-12">
            <form method="post" action="{{ route('sadhak-entry-record',$user->id) }}">
                @csrf
                <div class="card card-default">
                    <div class="bs-callout @error('start_date') bs-callout-danger @else bs-callout-primary @enderror sibir_info_row" >
                        <h4 class=''>{{ __('sadhak_registration.sibir_info')}}</h4>
                        <p>
                            @forelse ($records as $sibir_record)
                            @empty
                                {{ __('sadhak_registration.sibir_info_description') }}
                            @endforelse
                        </p>
                        <p class='float-center'>
                            <!-- <a href='#' onClick="addField()" class='text-primary'>Add Field</a> |  -->
                            <!-- <a href='' class='text-danger'>Remove Field</a> -->

                        </p>
                        <div class='row date_field'>
                            <div class='col-md-6'>
                                <label class='control-label'>
                                    {{ __('sadhak_registration.start_date')}}
                                    <!-- <small style="font-size:9px">( FORMAT: YYYY-MM-DD )</small> -->
                                </label>
                                <input type="date" name='start_date[]' class='form-control' value="" />
                            </div>
                            <div class='col-md-6'>
                                <label class='control-label'>{{ __('sadhak_registration.end_date') }}</label>
                                <input type="date" name='end_date[]' class='form-control' value="" />
                            </div>
                        </div>
                        <div class='row mt-4'>
                            <div class='col-md-6'>
                                <label class='control-label'>
                                    {{ __('sadhak_registration.start_date') }}
                                    <!-- <small style="font-size:9px">( FORMAT: YYYY-MM-DD )</small> -->
                                </label>
                                <input type="date" name='start_date[]' class='form-control' value="" />
                            </div>
                            <div class='col-md-6'>
                                <label class='control-label'>{{ __('sadhak_registration.end_date') }}</label>
                                <input type="date" name='end_date[]' class='form-control' value="" />
                            </div>
                        </div>
                        
                    </div>
                    

                    <div class='bs-callout @error("daily_practice") bs-callout-danger @else bs-callout-primary @enderror'>
                        <h4>{{ __('sadhak_registration.continue_practise') }}</h4>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class="funkyradio">
                                    <div class="funkyradio-success">
                                        <input type="radio" name="daily_practice" @if(old('daily_practice') == 'yes') checked @endif value="yes" id="daily_practice_yes" />
                                        <label for="daily_practice_yes">{{ __('sadhak_registration.yes') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="funkyradio">
                                    <div class="funkyradio-success">
                                        <input type="radio" name="daily_practice" @if(old('daily_practice') == "no" )  checked @endif value="no" id="daily_practice_no" />
                                        <label for="daily_practice_no">{{ __('sadhak_registration.no') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class='row mt-4 practise_session py-4' style="@if(old('daily_time')) display:block; @else display:none @endif @error('daily_time') display:block;color:red @enderror">
                            <h4>{{ __('sadhak_registration.your_anser') }} : {{ __('sadhak_registration.yes') }}</h4>
                            <p>{{ __('sadhak_registration.how_long') }}.</p>
                            <div class='col-md-12'>
                                <!-- <label class='control-label'>
                                    How much hour do you dedicate
                                </label> -->
                                <input type="text" value="{{ old('daily_time') }}" name="daily_time" placeholder="HH, E.g: 10" class='form-control' />
                            </div>
                        </div>
                    </div>


                    <div class='bs-callout @error("engaged_other")  bs-callout-danger @else bs-callout-primary @enderror'>
                        <h4>{{ __('sadhak_registration.are_you_engaged_in_other_sadhana_sibir_after_your_session_in_siddhamahayoga') }}</h4>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class="funkyradio">
                                    <div class="funkyradio-success">
                                        <input type="radio" name="engaged_other" @if(old('engaged_other') == 'yes') checked @endif value="yes" id="engaged_other_yes" />
                                        <label for="engaged_other_yes">{{ __('sadhak_registration.yes') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="funkyradio">
                                    <div class="funkyradio-success">
                                        <input type="radio" name="engaged_other" @if(old('engaged_other') == "no" )  checked @endif value="no" id="engaged_other_no" />
                                        <label for="engaged_other_no">{{ __('sadhak_registration.no') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bs-callout @error('center')  bs-callout-danger @else bs-callout-primary @enderror">
                        <h4 class=''>{{ __('sadhak_registration_front.your_nearest_center') }}</h4>
                        <p>{{ __('sadhak_registration_front.please_select_your_nearest_or_your_most_convenient_center_for_sadhana') }}</p>
                        <div class='row'>
                            <div class='col-md-8'>
                                <select class='form-control' name='center'>
                                    @php
                                        $all_centeres = App\Models\Center::get();
                                        foreach ($all_centeres as $center){
                                            echo "<option ";
                                                if($center->id == old('center') ) {
                                                    echo " selected ";
                                                }
                                            echo " value='{$center->id}'>{$center->name}</option>";
                                        }
                                    @endphp
                                    <option value='0'>Sewa Pit</option>
                                </select>
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
        $("input[name='daily_practice']").change(function(){
            if (this.value == "yes") {
                $('.practise_session').fadeIn('medium',function (){
                    $(this).addClass('bg-warning');
                })
            } else {
                $('.practise_session').fadeOut('fast',function (){
                    $(this).removeClass('bg-warning');
                });
            }
        })

    </script>
@endsection
