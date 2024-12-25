<?php

namespace App\Http\Traits;

use App\Models\Member;

class SMS
{

    public function message()
    {
        $message = "https://us02web.zoom.us/j/81739883948?pwd=UFd1cjdCWmF5NWxhUjJWdi95a1l3QT09";
        $message .= "\n";
        $message .= "Meeting ID: 81739883948";
        $message .= "Password: 999999";
        $message .= "\n";
        $message .= "Time: 2:30 PM";
        $message .= "\n";
        $message .= "Starts From Poush 12";

        return $message;
    }

    public function sendSMS()
    {
        ini_set("max_execution_time", -1);

        $members = Member::select(['phone_number', 'id'])
            ->where('country', 153)
            ->orWhere('country', 'Nepal')
            ->cursor();

        foreach ($members as $member) {
            $sms = [
                'to' => $member->phone_number,
                'message' => $this->message()
            ];

            dd($this->smsAPI($sms));
        }
    }

    public function smsAPI($send_param)
    {
        $auth_token =  "aa640550af64b95f7b68122b24ea10f6a0ef305ff18d0c1c5102facf51d00d76";
        $send_param["auth_token"] = $auth_token;
        $url = "https://sms.aakashsms.com/sms/v3/send/";
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); ///
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Response
        $response = curl_exec($ch);
        curl_close($ch);
        $response_param = json_decode($response);
        return ($response_param->error) ? false : true;
    }

    public static function sparrowMessage($send_param)
    {
        $auth_token =  "aa640550af64b95f7b68122b24ea10f6a0ef305ff18d0c1c5102facf51d00d76";
        $send_param["auth_token"] = $auth_token;
        $url = "https://sms.aakashsms.com/sms/v3/send/";
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); ///
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Response
        $response = curl_exec($ch);
        curl_close($ch);
        $response_param = json_decode($response);
        return ($response_param->error) ? false : true;
    }
}
