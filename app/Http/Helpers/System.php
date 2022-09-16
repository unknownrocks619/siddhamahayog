<?php

use App\Models\Member;
use App\Models\ZoomAccount;
use Illuminate\Support\Str;

if (!function_exists("default_currency")) {

    function default_currency($number, $prefix = "NRs", $suffig = null)
    {
        return $prefix . " " . number_format($number, 2) . $suffig;
    }
}

if (!function_exists("create_zoom_meeting")) {

    function create_zoom_meeting(ZoomAccount $zoom_account, $meeting_name = "Siddhamahayog, Test Case 01")
    {
        $token = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InBVQmhpSkRqVFJXaG9XQWVuamttTFEiLCJleHAiOjE2NzIzODA5MDAsImlhdCI6MTYzMTIwMDQ4NH0.33IM6DmA8fs-BGTf7khr5O9euOsHqY3WxQbgcWZq1S8";
        $username = "zoom@siddhamahayogacademy.org";

        $configurations = [
            "type" => 2,
            "topic" => $meeting_name,
            "start_time" => date("Y-m-dT15:30:00"),
            "timezone" => "Asia/Kathmandu",
            "duration" => 300,
            // "recurrence" => [
            //     'type' => '1',
            //     'weekly_days' => '1,2,3,4,5,6,7',
            //     // "repeat_interval" => 90,
            //     "end_date_time" => "2022-12-30T12:00:00Z"
            // ],
            "settings" => [
                "approval_type" => 1,
                "allow_multiple_devices" => 0,
                "show_share_button" => 0,
                "registrants_confirmation_email" => false,
                "auto_recording" => "cloud",
                "mute_upon_entry" => true,
                "participant_video" => true,
                "private_meeting" => true,
                "focus_mode" => true,
                "registration_type" => 1,
                "watermark" => true,
                // "meeting_authentication" => true,
                "authentication_name" => "Signed-in users in my account"
            ],
            "language_interpretation" => [
                "show_share_button" => 0,
                "allow_multiple_devices" => 0,
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/{$username}/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($configurations),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$token}",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return false;
        }
        $zoom_response = json_decode($response);
        return $zoom_response;
    }
}

if (!function_exists('meeting_details')) {

    function zoom_meeting_details($meeting_id = 81217648146)
    {
        $signature = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InBVQmhpSkRqVFJXaG9XQWVuamttTFEiLCJleHAiOjE2NzIzODA5MDAsImlhdCI6MTYzMTIwMDQ4NH0.33IM6DmA8fs-BGTf7khr5O9euOsHqY3WxQbgcWZq1S8";

        $curl_url = "https://api.zoom.us/v2/meetings/$meeting_id";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curl_url,
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_POSTFIELDS => json_encode($settings),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$signature}",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return false;
        }
        return ($response);
    }
}

if (!function_exists("register_participants")) {
    function register_participants(ZoomAccount $zoomAccount, $meeting_id)
    {
        $last_name = (user()->middle_name) ?  " " . Str::ucfirst(Str::lower(Str::of(user()->middle_name)->trim())) . " " .  Str::ucfirst(Str::lower(Str::of(user()->last_name)->trim())) : " " . Str::ucfirst(Str::lower(Str::of(user()->last_name)->trim()));
        $settings = [
            "first_name" => Str::ucfirst(Str::lower(Str::of(user()->first_name)->trim())),
            "last_name" => $last_name,
            "email" => time() . user()->email,
            "auto_approve" => true
        ];
        $signature = $zoomAccount->api_token;

        $curl_url = "https://api.zoom.us/v2/meetings/{$meeting_id}/registrants";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curl_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($settings),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$signature}",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        // if ($err) {
        //     return false;
        // }
        return ($response);
    }
}
