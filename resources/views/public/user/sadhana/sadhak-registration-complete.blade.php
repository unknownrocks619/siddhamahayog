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
            <x-alert></x-alert>
            <div class='card'>
                <div class='card-header'>
                    <h4 class='text-center'>{{ __('sadhak_registration.thank_you') }}</h4>
                </div>
                <div class='card-body'>
                    <p class='text-center'>{{ __('sadhak_registration.thank_you_text') }}</p>
                </div>
                <div class='card-footer'>
                    <p>
                        <a class='text-info' href="{{ route('sadhana-registration-one') }}">
                            {{ __('sadhak_registration.start_over') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
