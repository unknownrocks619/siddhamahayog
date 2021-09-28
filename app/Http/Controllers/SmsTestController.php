<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SMS;
class SmsTestController extends Controller
{
    //
    use Sms;

    public function index() {
        $user_detail = \App\Models\userDetail::findOrFail(2);
        $user_login = $user_detail->userlogin;
        dd($this->send_sms_password($user_detail,$user_login));
    }
}
