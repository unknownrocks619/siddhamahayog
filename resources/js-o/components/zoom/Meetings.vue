<template>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="row" v-if="errors.length">
            <div class="col-md-12 alert alert-danger">
                <p >
                    Please correct the following error(s)
                    <ul>
                        <li v-for="(error,index) in errors" :key="index">
                            {{ error }}
                        </li>
                    </ul>
                </p>
            </div>
        </div>
        <form @submit="submitForm " action="" method="post">
            <div class="card">
                <div class="header">
                    <h2><strong>Create</strong> New Meeting </h2>
                    <ul class="header-dropdown">
                        <li class="remove">
                            <button type="button" class="btn btn-danger btn-sm boxs-close"><i class="zmdi zmdi-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="account_name">Meeting Title
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <input type="text" v-model="meeting_name" class="form-control" name="meeting_name" id="meeting_title" require value="" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Meeting Type
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <select v-model="meeting_type" name="meeting_type" id="meeting_type" class='form-control' required>
                                    <option value="scheduled" selected>Scheduled</option>
                                    <option value="instant">Instant</option>
                                    <option value="reoccuring">Re-Occuring</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="account_username">
                                    Enable Meeting Lock
                                    <sup class="text-danger">
                                        *
                                    </sup>
                                </b>
                                <div class="radio">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input v-model="meeting_lock" checked type="radio" name="meeting_lock" id="meeting_lock_yes" value="yes">
                                            <label for="meeting_lock_yes" class='text-success'>
                                                Yes, Lock Meeting
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" v-model="meeting_lock" name="meeting_lock" id="meeting_lock_no" value="no">
                                            <label for="meeting_lock_no" class='text-danger'>
                                                No, Don't Lock Meeting
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="meeting_lock == 'yes'" class="col-lg-6 col-md-6 col-sm-12 m-b-20" id="meeting_lock_settings" >
                            <div class="form-group">
                                <b for="category">
                                    Lock After
                                    <sup class="text-danger">
                                        *
                                    </sup>
                                    <small>Interval of Time in Minute</small>
                                </b>
                                <input type="int" v-model="meeting_interval" class='form-control' name='lock_meeting_internval_time' />
                            </div>
                        </div>
                    </div>

                    <div v-if="meeting_type == 'scheduled'" class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="api_token">
                                    Scheduled Date
                                    <sup class="text-danger">*</sup>
                                </b>
                                <input v-model="scheduled_date" class='form-control' type="date" name="scheduled_date" id="meeting_schedule_date">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="api_token">
                                    Scheduled Time
                                    <sup class="text-danger">*</sup>
                                </b>
                                <input v-model="scheduled_time" class='form-control' type="time" name="scheduled_time" id="meeting_schedule_time">
                            </div>
                        </div>
                    </div>

                    <div v-if="meeting_type == 'reoccuring'" class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>
                                    Select Day to reoccuring
                                    <sup class="text-danger">*</sup>
                                </b>
                                <select v-model="meeting_reoccuring_day" name='reoccuring' class="form-control">
                                    <option value="all">All Week</option>
                                    <option value="sunday">Sunday</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="api_token">
                                    Create Meeting Timing
                                    <sup class="text-danger">*</sup>
                                </b>
                                <input v-model="meeting_reoccuring_time" type="time" class="form-control" name="reoccuring_meeting_timing" />
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Select Timezone
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <select v-model="timezone" class="form-control  z-index show-tick"  data-live-search="true" name="timezone" >
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
                                    <option value="Asia/Kathmandu" selected>Kathmandu</option>
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Enable Cron Job</b>
                                <select name="cron_job" v-model="cron_job" id="cron_job" class="form-control">
                                    <option value="yes" selected>Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Country / Zone / Section Lock</b>
                                <select v-if="country_lock" class='form-control' name='country_lock'>
                                    <option value="no" selected>No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer clearfix mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class='btn btn-primary btn-block'>Create Zoom Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
// import Form from ''
export default {
    data : function (){
        return {

            // form: new Form({
            //     meeting_name : '',
            //     meeting_type : "scheduled",
            //     meeting_lock : "yes",
            //     meeting_interval : "",
            //     scheduled_time : "",
            //     scheduled_date : "",
            //     timezone : "UTC +5:45 Nepal",
            //     meeting_reoccuring_time : "",
            //     meeting_reoccuring_day : "",
            //     cron_job : 'yes',
            //     country_lock : 'no',
            // }),

            meeting_name : '',
            meeting_type : "scheduled",
            meeting_lock : "yes",
            meeting_interval : "",
            scheduled_time : "",
            scheduled_date : "",
            timezone : "UTC +5:45 Nepal",
            meeting_reoccuring_time : "",
            meeting_reoccuring_day : "",
            cron_job : 'yes',
            country_lock : 'no',
            errors : []
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods : {
        validateForm : function () {
            this.errors = [];
            // console.log(this.form.meeting_type);
            // return false;
            if (this.meeting_name == "" ) {
                this.errors.push("You must provide meeting name.");
            }

            if (this.meeting_lock == "yes" && this.meeting_interval == "") {
                this.errors.push("Please provide meeting lock time relavent to start time.");
            }
            console.log(this.scheduled_date);
            if (this.meeting_type == "scheduled" && (this.scheduled_date == "" || this.scheduled_time) ) {
                this.errors.push("Please Provide schduled time and date for scheduled meeting type.");
            }
            

            if (this.meeting_type == 'reoccuring' && (this.meeting_reoccuring_day == "" || this.meeting_reoccuring_time == "")){
                this.errors.push("Provide re-occuring day or re-occuring time for your meeting.");
            }
            
            return (this.errors.length) ? false : true;
        },

        submitForm : function (event) {

            if ( ! this.validateForm() ) {
                event.preventDefault();
                return window.scrollTo(0,0);
            }

            // console.log()
            
        }
    }
}

</script>
