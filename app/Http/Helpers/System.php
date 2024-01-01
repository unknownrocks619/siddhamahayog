<?php

use App\Models\Member;
use App\Models\Role;
use App\Models\ZoomAccount;
use Illuminate\Support\Str;

if (!function_exists("default_currency")) {

    function default_currency($number, $prefix = "NRs", $suffig = null)
    {
        $number = str_replace(',', '', $number);
        return $prefix . " " . number_format($number, 2) . $suffig;
    }
}

if (!function_exists("create_zoom_meeting")) {

    function create_zoom_meeting(ZoomAccount $zoom_account, $meeting_name = "Siddhamahayog", $domain = 'siddhamahayog.org', $cohost = "")
    {
        $zoomMeeting = new \App\Classes\Zoom\ZoomMeeting\ZoomMeeting();
        if ( env('APP_ENV') == 'local' || env('APP_DEBUT') == true) {
            $meeting_name = $meeting_name . ' Debug Mode';
        }
        return ($zoomMeeting->setname($meeting_name)->set_account($zoom_account->account_username)->create());

    }
}

if (!function_exists('meeting_details')) {

    function zoom_meeting_details($meeting_id = 81217648146)
    {
        $zoomRegistration = new \App\Classes\Zoom\ZoomMeeting\ZoomRegistration();
        return $zoomRegistration->setMeeting($meeting_id)->meeting();
//        // $signature = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InBVQmhpSkRqVFJXaG9XQWVuamttTFEiLCJleHAiOjE2NzIzODA5MDAsImlhdCI6MTYzMTIwMDQ4NH0.33IM6DmA8fs-BGTf7khr5O9euOsHqY3WxQbgcWZq1S8";
//
//        $curl_url = "https://api.zoom.us/v2/meetings/$meeting_id";
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => $curl_url,
//            CURLOPT_RETURNTRANSFER => true,
//            // CURLOPT_POSTFIELDS => json_encode($settings),
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                // "authorization: Bearer {$signature}",
//                "content-type: application/json"
//            ),
//        ));
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//        curl_close($curl);
//        if ($err) {
//            return false;
//        }
//        return ($response);
    }
}

if (!function_exists("register_participants")) {
    function register_participants(ZoomAccount $zoomAccount, $meeting_id, $settings, $domain = 'siddhamahayog.org')
    {
        $zoomRegistration = new \App\Classes\Zoom\ZoomMeeting\ZoomRegistration();
        return ($zoomRegistration->setRegistrationConfigs($settings)->setMeeting($meeting_id)->register_participants());
    }
}

function check_unicode_character($character, $exclude = null)
{
    if (is_string($character)) {
        return (mb_detect_encoding($character, "auto") == "UTF-8") ? $character : false;
    }

    $unicodes = [];
    foreach ($character as $key => $value) {

        if ($key == $exclude) {
            continue;
        }
        if (is_array($value)) {
            // return $this->check_unicode_character($value);
        } else {
            if (mb_detect_encoding($value, "auto") == "UTF-8") {
                // echo (mb_detect_encoding($value, "auto") == "UTF-8") ?  $value . " is encoding" : $value  . "  is not encoding";
                // echo "<br />";
                $unicodes[$key] = "Invalid characters.";
            }
        }
    }
    return $unicodes;
}


function widgets_view($widgets)
{
}


function getUserCountry()
{
    $white_ip = [
        '::1',
        '127.0.0.1'
    ];

    $userIp = request()->getClientIp();

    if (in_array($userIp, $white_ip)) {
        return "NP";
    }

    if (session()->has('userIp')) {
        return session()->get('userIp')->$userIp->isocode;
    }


    // ------------------------------
    // SETTINGS
    // ------------------------------

    $API_Key = env('PROXYCHECK_API'); // Supply your API key between the quotes if you have one
    $VPN = env("PROXYCHECK_VPN", false); // Change this to 1 if you wish to perform VPN Checks on your visitors
    $TLS = env("PROXYCHECK_TLS", false); // Change this to 1 to enable transport security, TLS is much slower though!
    $TAG = 0;

    // ------------------------------
    // END OF SETTINGS
    // ------------------------------
    $Custom_Tag = "";
    // Setup the correct querying string for the transport security selected.
    if ($TLS == 1) {
        $Transport_Type_String = "https://";
    } else {
        $Transport_Type_String = "http://";
    }


    // However you can supply your own descriptive tag or disable tagging altogether above.
    if ($TAG == 1 && $Custom_Tag == "") {
        $Post_Field = "tag=" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    } else if ($TAG == 1 && $Custom_Tag != "") {
        $Post_Field = "tag=" . $Custom_Tag;
    } else {
        $Post_Field = "";
    }

    $http_build_query = [
        'key' => env("PROXYCHECK_API"),
        'vpn' => env("PROXYCHECK_VPN", false),
        'asn' => env("PROXYCHECK_ASN", true),
        'risk' => env('PROXYCHECK_RISK', 33)
    ];
    $ch = curl_init($Transport_Type_String . 'proxycheck.io/v2/' . $userIp . '?' . http_build_query($http_build_query));

    $curl_options = [
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $Post_Field,
        CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($ch, $curl_options);
    $proxy_JSON_result = curl_exec($ch);
    $result = json_decode($proxy_JSON_result);
    session()->put('userIp', $result);
    return $result->$userIp->isocode;
}


function getUserLocation()
{
    $userIp = request()->ip();

    // ------------------------------
    // SETTINGS
    // ------------------------------

    $API_Key = env('PROXYCHECK_API'); // Supply your API key between the quotes if you have one
    $VPN = env("PROXYCHECK_VPN", false); // Change this to 1 if you wish to perform VPN Checks on your visitors
    $TLS = env("PROXYCHECK_TLS", false); // Change this to 1 to enable transport security, TLS is much slower though!
    $TAG = 0;

    // ------------------------------
    // END OF SETTINGS
    // ------------------------------
    $Custom_Tag = "";
    // Setup the correct querying string for the transport security selected.
    if ($TLS == 1) {
        $Transport_Type_String = "https://";
    } else {
        $Transport_Type_String = "http://";
    }


    // However you can supply your own descriptive tag or disable tagging altogether above.
    if ($TAG == 1 && $Custom_Tag == "") {
        $Post_Field = "tag=" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    } else if ($TAG == 1 && $Custom_Tag != "") {
        $Post_Field = "tag=" . $Custom_Tag;
    } else {
        $Post_Field = "";
    }

    $http_build_query = [
        'key' => env("PROXYCHECK_API"),
        'vpn' => env("PROXYCHECK_VPN", false),
        'asn' => env("PROXYCHECK_ASN", true),
        'risk' => env('PROXYCHECK_RISK', 33)
    ];
    $ch = curl_init($Transport_Type_String . 'proxycheck.io/v2/' . $userIp . '?' . http_build_query($http_build_query));

    $curl_options = [
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $Post_Field,
        CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($ch, $curl_options);
    $proxy_JSON_result = curl_exec($ch);
    $result = json_decode($proxy_JSON_result);
    return $result;
}
