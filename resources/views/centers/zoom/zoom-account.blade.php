@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('events.admin_view_zone_settings') }}" class='btn btn-primary'>
                        Back
                    </a>
                </div>
                <x-alert></x-alert>
                <form method="post" action="{{ route('events.admin_store_zoom_setting') }}">
                    @csrf
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='label-control'>Select Country</label>
                                <select name='country' class='form-control'>
                                    @foreach (\App\Models\Countries::get() as $country)
                                        <option value='{{ $country->id }}'> {{ $country->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>Event</label>
                                <select name="sibir" class='form-control'>
                                    @foreach (\App\Models\SibirRecord::get() as $sibir)
                                        <option value="{{ $sibir->id }}"> {{ $sibir->sibir_title }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>Zoom Username</label>
                                <input type="text" class='form-control' name="zoom_username" />
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>Account Password</label>
                                <input type="password" name="password" class='form-control' />
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>
                                    Meeting Date & Time
                                </label>
                                <input type="datetime-local" class='form-control' name='date_time' />
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>
                                    Set Timezone
                                </label>
                                <select class='form-control' name="timezone">
                                    <option value="Pacific/Midway">Midway Island, Samoa</option>
                                    <option value="Pacific/Pago_Pago">Pago Pago</option>
                                    <option value="Pacific/Honolulu">Hawaii</option>
                                    <option value="America/Anchorage">Alaska</option>
                                    <option value="America/Vancouver">Vancouver</option>
                                    <option value="America/Los_Angeles">Pacific Time (US and Canada)</option>
                                    <option value="America/Tijuana">Tijuana</option>
                                    <option value="America/Edmonton">Edmonton</option>
                                    <option value="America/Denver">Mountain Time (US and Canada)</option>
                                    <option value="America/Phoenix">Arizona</option>
                                    <option value="America/Mazatlan">Mazatlan</option>
                                    <option value="America/Winnipeg">Winnipeg</option>
                                    <option value="America/Regina">Saskatchewan</option>
                                    <option value="America/Chicago">Central Time (US and Canada)</option>
                                    <option value="America/Mexico_City">Mexico City</option>
                                    <option value="America/Guatemala">Guatemala</option>
                                    <option value="America/El_Salvador">El Salvador</option>
                                    <option value="America/Managua">Managua</option>
                                    <option value="America/Costa_Rica">Costa Rica</option>
                                    <option value="America/Montreal">Montreal</option>
                                    <option value="America/New_York">Eastern Time (US and Canada)</option>
                                    <option value="America/Indianapolis">Indiana (East)</option>
                                    <option value="America/Panama">Panama</option>
                                    <option value="America/Bogota">Bogota</option>
                                    <option value="America/Lima">Lima</option>
                                    <option value="America/Halifax">Halifax</option>
                                    <!-- <option value="America/Halifax">Puerto Rico</option> -->
                                    <option value="America/Puerto_Rico">Puerto Rico</option>
                                    <option value="America/Caracas">Caracas</option>
                                    <option value="America/Santiago">Santiago</option>
                                    <option value="America/St_Johns">Newfoundland and Labrador</option>
                                    <option value="America/Montevideo">Montevideo</option>
                                    <option value="America/Araguaina">Brasilia</option>
                                    <option value="America/Argentina/Buenos_Aires">Buenos Aires, Georgetown</option>
                                    <option value="America/Godthab">Greenland</option>
                                    <option value="America/Sao_Paulo">Sao Paulo</option>
                                    <option value="Atlantic/Azores">Azores</option>
                                    <option value="Canada/Atlantic">Atlantic Time (Canada)</option>
                                    <option value="Atlantic/Cape_Verde">Cape Verde Islands</option>
                                    <option value="UTC">Universal Time UTC</option>
                                    <option value="Etc/Greenwich">Greenwich Mean Time</option>
                                    <option value="Europe/Belgrade">Belgrade, Bratislava, Ljubljana</option>
                                    <option value="CET">Sarajevo, Skopje, Zagreb</option>
                                    <option value="Atlantic/Reykjavik">Reykjavik</option>
                                    <option value="Europe/Dublin">Dublin</option>
                                    <option value="Europe/London">London</option>
                                    <option value="Europe/Lisbon">Lisbon</option>
                                    <option value="Africa/Casablanca">Casablanca</option>
                                    <option value="Africa/Nouakchott">Nouakchott</option>
                                    <option value="Europe/Oslo">Oslo</option>
                                    <option value="Europe/Copenhagen">Copenhagen</option>
                                    <option value="Europe/Brussels">Brussels</option>
                                    <option value="Europe/Berlin">Amsterdam, Berlin, Rome, Stockholm, Vienna</option>
                                    <option value="Europe/Helsinki">Helsinki</option>
                                    <option value="Europe/Amsterdam">Amsterdam</option>
                                    <option value="Europe/Rome">Rome</option>
                                    <option value="Europe/Stockholm">Stockholm</option>
                                    <option value="Europe/Vienna">Vienna</option>
                                    <option value="Europe/Luxembourg">Luxembourg</option>
                                    <option value="Europe/Paris">Paris</option>
                                    <option value="Europe/Zurich">Zurich</option>
                                    <option value="Europe/Madrid">Madrid</option>
                                    <option value="Europe/Bangui">West Central Africa</option>
                                    <option value="Europe/Algiers">Algiers</option>
                                    <option value="Europe/Tunis">Tunis</option>
                                    <option value="Europe/Harare">Harare, Pretoria</option>
                                    <option value="Europe/Nairobi">Nairobi</option>
                                    <option value="Europe/Warsaw">Warsaw</option>
                                    <option value="Europe/Prague">Prague Bratislava</option>
                                    <option value="Europe/Budapest">Budapest</option>
                                    <option value="Europe/Sofia">Sofia</option>
                                    <option value="Europe/Istanbul">Istanbul</option>
                                    <option value="Europe/Bucharest">Bucharest</option>
                                    <option value="Asia/Nicosia">Nicosia</option>
                                    <option value="Asia/Beirut">Beirut</option>
                                    <option value="Asia/Damascus">Damascus</option>
                                    <option value="Asia/Jerusalem">Jerusalem</option>
                                    <option value="Asia/Amman">Amman</option>
                                    <option value="Africa/Tripoli">Tripoli</option>
                                    <option value="Africa/Cairo">Cairo</option>
                                    <option value="Asia/Johannesburg">Johannesburg</option>
                                    <option value="Asia/Moscow">Moscow</option>
                                    <option value="Asia/Baghdad">Baghdad</option>
                                    <option value="Asia/Kuwait">Kuwait</option>
                                    <option value="Asia/Riyadh">Riyadh</option>
                                    <option value="Asia/Bahrain">Bahrain</option>
                                    <option value="Asia/Qatar">Qatar</option>
                                    <option value="Asia/Aden">Aden</option>
                                    <option value="Asia/Tehran">Tehran</option>
                                    <option value="Africa/Khartoum">Khartoum</option>
                                    <option value="Africa/Djibouti">Djibouti</option>
                                    <option value="Africa/Mogadishu">Mogadishu</option>
                                    <option value="Asia/Dubai">Dubai</option>
                                    <option value="Asia/Muscat">Muscat</option>
                                    <option value="Asia/Baku">Baku, Tbilisi, Yerevan</option>
                                    <option value="Asia/Kabul">Kabul</option>
                                    <option value="Asia/Yekaterinburg">Yekaterinburg</option>
                                    <option value="Asia/Tashkent">Islamabad, Karachi, Tashkent</option>
                                    <option value="Asia/Calcutta">India</option>
                                    <option value="Asia/Kathmandu">Kathmandu</option>
                                    <option value="Asia/Novosibirsk">Novosibirsk</option>
                                    <option value="Asia/Almaty">Almaty</option>
                                    <option value="Asia/Dacca">Dacca</option>
                                    <option value="Asia/Krasnoyarsk">Krasnoyarsk</option>
                                    <option value="Asia/Dhaka">Astana, Dhaka</option>
                                    <option value="Asia/Bangkok">Bangkok</option>
                                    <option value="Asia/Saigon">Vietnam</option>
                                    <option value="Asia/Jakarta">Jakarta</option>
                                    <option value="Asia/Irkutsk">Irkutsk, Ulaanbaatar</option>
                                    <option value="Asia/Shanghai">Beijing, Shanghai</option>
                                    <option value="Asia/Hong_Kong">Hong Kong</option>
                                    <option value="Asia/Taipei">Taipei</option>
                                    <option value="Asia/Kuala_Lumpur">Kuala Lumpur</option>
                                    <option value="Asia/Singapore">Singapore</option>
                                    <option value="Asia/Perth">Perth</option>
                                    <option value="Asia/Yakutsk">Yakutsk</option>
                                    <option value="Asia/Seoul">Seoul</option>
                                    <option value="Asia/Tokyo">Osaka, Sapporo, Tokyo</option>
                                    <option value="Australia/Darwin">Darwin</option>
                                    <option value="Australia/Adelaide">Adelaide</option>
                                    <option value="Asia/Vladivostok">Vladivostok</option>
                                    <option value="Pacific/Port_Moresby">Guam, Port Moresby</option>
                                    <option value="Australia/Sydney">Sydney</option>
                                    <option value="Australia/Brisbane">Brisbane</option>
                                    <option value="Australia/Hobart">Hobart</option>
                                    <option value="Asia/Magadan">Magadan</option>
                                    <option value="SST">Solomon Islands</option>
                                    <option value="Pacific/Noumea">New Caledonia</option>
                                    <option value="Asia/Kamchatka">Kamchatka</option>
                                    <option value="Pacific/Fiji">Fiji Islands, Marshall Islands</option>
                                    <option value="Pacific/Auckland">Auckland, Wellington</option>
                                    <option value="Asia/Kolkata">Mumbai, Kolkata, New Delhi</option>
                                    <option value="Europe/Kiev">Kiev</option>
                                    <option value="America/Tegucigalpa">Tegucigalpa</option>
                                    <option value="Pacific/Apia">Independent State of Samoa</option>
                                </select>
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-12'>
                                <label class='label-control'>JWT TOKEN</label>
                                <textarea class='form-control' name="jwt_token"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class='card-footer'>
                        <button type="submit" class='btn btn-info'>Save Accout Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-8">
            <div class="card">
                <!-- Card flex-->
            </div>
        </div>
    </div>
</section>
@endSection()