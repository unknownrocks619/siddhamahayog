<?php

namespace App\Traits;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\SmsTracker;
use App\Models\userDetail;
use App\Models\userLogin;
use App\Models\PasswordRecovery;
/**
 * 
 */
trait Sms
{

    public function send_reset_password(userDetail $userDetail, userLogin $userLogin) {
        $random_text = rand_booking_number();
        $request_query = [
            'to' => $userDetail->phone_number,
            'text' => "Your new password is: {$random_text}"
        ];

        // $userLogin->password = Hash::make($random_text);
        if ($this->send_sms($request_query) ) {
            // $userLogin->save();
            $password_token = new PasswordRecovery;
            $password_token->key = $random_text;
            $password_token->status = true;
            $password_token->user_login_id = $userLogin->id;
            $password_token->save();

            return $password_token;
        }
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send_sms_password(userDetail $userDetail, userLogin $userLogin)
    {   
        // now let's make sure we send generate appropirate password and than make changes to db.
        $random_text = \Str::random(6);
                // get user phone number
                $request_query = [
                    'to' => $userDetail->phone_number,
                    'text'=>"सद्गुरदेवबाट प्रदत्त वेदान्त दर्शन साधनामा स्वागत छ।\nसहभागी हुने लिंक\n https://sadhak.siddhamahayog.org \n ID:{$userDetail->phone_number}\n पासवर्ड: {$random_text}\n समस्या परेमा संपर्क गर्ने नं 9852066009"
                ];
        $userLogin->password = Hash::make($random_text);
        // return $this->send_sms($request_query);
        if ($this->send_sms($request_query) ) {
            $userLogin->save();
        }
    }


    private function send_sms($send_param) {
        $auth_token =  "aa640550af64b95f7b68122b24ea10f6a0ef305ff18d0c1c5102facf51d00d76";
        $send_param["auth_token"] = $auth_token;
        $url = "https://sms.aakashsms.com/sms/v3/send/";
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); ///
        curl_setopt($ch, CURLOPT_POSTFIELDS,$send_param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // Response
        $response = curl_exec($ch);
        curl_close($ch);
        $response_param = json_decode($response);
        return ($response_param->error) ? false : true;
    }
   
}
