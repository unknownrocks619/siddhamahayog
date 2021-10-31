<?php 

use App\Models\Role;
use App\Models\Countries;
use App\Models\City;
use App\Models\Uploader;

if ( ! function_exists('isAdmin') ) {

    function isAdmin() {
        return (getRole() == "Admin" || getRole() == "Super Admin") ? true : false;
    }
}

if ( ! function_exists('isCenter') ) {

    function isCenter() {
        return (getRole() == "Center") ? true : false;
    }
}

if ( ! function_exists('getRole') ) {

    function getRole(){
        try {
            return Role::findOrFail(Session::get("roles"))->role_name;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }

    }
}

if ( ! function_exists('address') ) {

    function address ($address,$access="both") {
        $return_address = null;
        if ($access == "both") {

            if (is_array($address) ) {
                $address_model = Countries::where('id',$address[0])->first();
                $city = City::select('name')->where('id',(int)$address[1])->first();

            } else {
                $explode = explode(",",$address);

                $address_model = Countries::where('id',$explode[0])->first();
                $city = City::select('name')->where('id',(int)$address[1])->first((int)$explode[1]);
            }
            if ( ! $city ) {
                // $return_address = $address_model->name . " , " .$address[1];                
            } else {
                // $return_address = $address_model->name;
            }
            $return_address = ($address_model) ? $address_model->name. ", " : "";
            $return_address .= ( $city ) ? $city->name : "";
            // $return_address = $address_model->name . " , " . ($city) ? $city->name : "";  
            // $return_address = $address_model->name . " , " .$address[1];
            
            // . ", " . ( ! empty($city) && isset($city->name)) ? $city->name : "";

        } elseif ($access == "city") {
            $city = City::where("id",$address)->first();
            $return_address = ($city) ?  $city->name : "";
        } elseif ($access == "country") {
            $country = Countries::where('id',$address)->first();
            $return_address = ($country) ?  $country->name : "";
        }

        return $return_address;
    }
}

if ( ! function_exists('video_asset') ) {

    function video_asset( $file_id )
    {

        $file = Uploader::find($file_id);

        if ($file != NULL )
        {
            //
            return app('url')->asset($file->path);
        }
        return null;
    }
}


if ( ! function_exists('audio_asset') ) {

    function audio_asset( $file_id )
    {
        $file = Uploader::find($file_id);

        if ($file != NULL )
        {
            //
            return app('url')->asset($file->path);
        }
        return null;
    }
}

if ( ! function_exists('question_image') ) {

    function question_image( $file_id )
    {
        $file = Uploader::find($file_id);

        if ($file != NULL )
        {
            //
            return app('url')->asset($file->path);
        }
        return null;
    }
}


if ( ! function_exists('profile_asset') ) {

    function profile_asset( $file_id )
    {

        $file = Uploader::find($file_id);

        if ($file != NULL )
        {
            //
            return app('url')->asset($file->path);
        }
        return null;
    }
}



if ( ! function_exists('transaction_asset') ) {

    function transaction_asset( $file_id )
    {

        $file = Uploader::find($file_id);
        if ($file != NULL )
        {
            //
            return app('url')->asset($file->path);
        }
        return null;
    }
}


if (! function_exists ("rand_booking_number") ) {

    function rand_booking_number() {
        $number = mt_rand(100000,999999);

        if ( \App\Models\Booking::where('booking_code',$number)->exists()) {
            return rand_booking_number();
        }
        return $number;

    }
}


if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

if (!function_exists('isActive')) {
    function isActive(string $route, $output = "active")
    {
        return (Route::currentRouteName() == $route) ? $output : null ;
    }
}

if ( ! function_exists ("zoom_registration_link") ) {

    function zoom_registration_link($user_data,$meeting_id,$signature) {

        if(strtolower($user_data["first_name"]) == "prakash" && strtolower($user_data["last_name"]) == "gauli") {
            $user_data["first_name"] = "Ram";
            $user_data["last_name"] = "Das";
        } elseif (strtolower($user_data["first_name"]) == "binod" && strtolower($user_data["last_name"]) == "giri") {
            $user_data["first_name"] = "Ram";
            $user_data["last_name"] = "Das (B)";
        } elseif (strtolower($user_data["first_name"]) == "banshidhar" && strtolower($user_data["last_name"]) == "sharma") {
            $user_data["first_name"] = "Ram";
            $user_data["last_name"] = "Das (D)";
        } elseif (strtolower($user_data["first_name"]) == "prashant" && strtolower($user_data["last_name"]) == "adhikari") {
            $user_data["first_name"] = "Ram";
            $user_data["last_name"] = "Das (C)";
        } elseif(strtolower($user_data["first_name"]) == "shipa" && strtolower($user_data["last_name"]) == "neupane") {
            $user_data["first_name"] = "Ram";
            $user_data["last_name"] = "Das (E)";
        } elseif(strtolower($user_data["first_name"]) == "ananda" && strtolower($user_data["last_name"]) == "priya") {
            $user_data["first_name"] = "Ram";
            $user_data["last_name"] = "Das (F)";
        }
        $curl_url = "https://api.zoom.us/v2/meetings/".$meeting_id."/registrants";        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $curl_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($user_data),
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
        if ( $err ) {
            return false;
        }
        return json_decode($response);
    }
}


if ( ! function_exists("meeting_exists") ) {

    function meeting_exists($meeting_id,$signature) 
    {
        $curl_url = "https://api.zoom.us/v2/meetings/".$meeting_id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $curl_url,
        CURLOPT_RETURNTRANSFER => true,
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
        if ( $err ) {
            return false;
        }
        return json_decode($response);

    }
}


if ( ! function_exists ("create_zoom_meeting") ) {

    function create_zoom_meeting(String $username, String $token,Array $configurations) {
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
            if ( $err ) {
                return false;
            }
            $zoom_response = json_decode($response);
            return $zoom_response;
    }
}

if ( ! function_exists ("zoom_revoke_user") ) {

    function zoom_revoke_user(Intger $meeting_id, Array $configurations, String $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/meetings/{$meeting_id}/registrants/status",
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
            if ( $err ) {
                return false;
            }
            $zoom_response = json_decode($response);
            return $zoom_response;
    }

}
?>