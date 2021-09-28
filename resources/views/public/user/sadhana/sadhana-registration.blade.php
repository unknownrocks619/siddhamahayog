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
            border-left-color: #0d6efd!important;
        }

        .bs-callout-primary h4,
        .bs-callout-primary h5{
            color: #0d6efd!important;
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

            .loader {
                position: absolute;
                left: 50%;
                top: 50%;
                z-index: 1;
                width: 120px;
                height: 120px;
                margin: -76px 0 0 -76px;
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #3498db;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
                background: radial-gradient(#d83737,#9a9e5b)
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            }
    </style>


    @if(App::currentLocale() == "np")
        <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.min.css') }}" crossorigin="anonymous" />
    @endif

@endsection

@section("content")
    <div class='container'>
        
        <div class='row'>
            <x-alert></x-alert>
            <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-12 col-lg-offset-2 col-lg-12">
                <form method="post" action="{{ route('post-sadhana-registration-one') }}">
                @csrf
                    <div class="card card-default">
                        <div class="bs-callout @error('user_registration') bs-callout-danger @else bs-callout-primary @enderror" >
                            <h4 class=''>{{ __('sadhak_registration_front.is_this_your_first_time_taking_sadhana') }}</h4>
                            <p>
                                {{ __('sadhak_registration_front.is_this_your_first_time_taking_sadhana_description') }}
                                @error("user_registration")
                                    <blockquote class='alert alert-danger'>
                                    <b>Note: </b>
                                    {{ $message }}
                                    </blockquote>                                    
                                @enderror
                            </p>

                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="user_registration" @if(old('user_registration') == 'yes') checked @endif value="yes" id="registration_first" />
                                            <label for="registration_first">{{ __('sadhak_registration_front.yes_this_is_my_first_time') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="user_registration" @if(old('user_registration') == "no" )  checked @endif value="no" id="already_register" />
                                            <label for="already_register">{{ __('sadhak_registration_front.no_this_is_no_my_first_time') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='card card-default card-loaded' id='user_selection'>
                        @if(old("user_registration") == "no")
                            @include("partials.sadhana.old-registration-email-field")
                        @elseif(old('user_registration') == "yes")
                            @include("partials.sadhana.new-registration-contd-form")
                       @endif
                    </div>

                   
                </form>
            </div>
        </div>
    </div>
@endsection

@section("footer_script")
    @if(App::currentLocale() == 'np')
        <!-- this should go after your </body> -->
        <script src="{{ asset('js/nepali.datepicker.min.js') }}" crossorigin="anonymous"></script>
    @endif
    <script type="text/javascript">

        $("input[name='user_registration']").change(function(){
            $(".card-loaded").load("{{ route('sadhana-registar-type-selection',['sadhana','sadhana-registar-type']) }}?input="+this.value);
        })
       
       $(document).ajaxStart(function(){
            
            var newElem = "<div class='loader'></div>";
            $("body").prepend(newElem);
       });
       $(document).ajaxStop(function(){
           $(".loader").remove();
       })
       
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if(old('user_registration') == "yes")
        <script type="text/javascript">
            $(document).ready(function(){
                $(".countries").select2({
                    placeholder: "Choose Country or Region"
                });

                $('.countries').change(function(){
                    var country_id = this.value;
                    $(".cities").empty();
                    $(".cities").select2({
                        placeholder : "Select your city",
                        ajax: {
                            url :'{{ route("cities-list") }}/?country='+this.value,
                            dataType :'json',
                        }
                    })
                })
            })
        </script>
    @endif

    @if(old('country'))
    <script type="text/javascript">
        $(document).ready(function() {
            $(".countries").val('{{ old("country") }}');
            $(".countries").trigger('change');
        });
    </script>
@endif

@if(old('city'))
    <script type="text/javascript">
        $(document).ready(function(){
            $('.cities').val('{{ old("city") }}');
            $(".cities").trigger('change');

        })
    </script>
@endif
   
@endsection