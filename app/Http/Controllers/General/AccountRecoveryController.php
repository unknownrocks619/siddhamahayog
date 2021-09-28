<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userLogin;
use App\Models\userDetail;
use App\Models\PasswordRecovery;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Traits\Sms;
class AccountRecoveryController extends Controller
{
    //
    use Sms;
    public function index() {
        return view("auth.forgot");
    }

    public function send_password_reset_link(Request $request) {

        $request->validate([
            "username" => "required|string"
        ]);

        // now lets see what kind of username did we receive
        $email = filter_var($request->username,FILTER_VALIDATE_EMAIL);
        $res_message = "If there an account with provided detail, an email address with reset link will be sent.";
        if ($email) {
            $login_detail = userLogin::where('email',$email)
                                        ->where('account_status','Active')
                                        ->first();
            if ( ! $login_detail ) {
                $request->session()->flash('success',$res_message);
                return back();
            }
            $check_previous_record = PasswordRecovery::where('user_login_id',$user_login->id)
            ->where('status',true)
            ->first();
            if ($check_previous_record) {
                $check_previous_record->status = false;
                $check_previous_record->save();
            }
            $account_recovery = new PasswordRecovery;
            $recover_key = \Str::random(32);
            $account_recovery->key = $recover_key;
            $account_recovery->user_login_id = $login_detail->id;
            $account_recovery->status = true;
            $account_recovery->save();
            // lets generate temp url

            $link = URL::temporarySignedRoute('public_verify_password_link',
                        now()->addMinutes(120),["key"=>encrypt($recover_key)]);
            return redirect()->to($link);
            // now lets send password this user.
            $message = view("auth.forgot-password-email-template",compact("link"));
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <noreply@siddhamahayog.org>' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            mail($login_detail->email,'Account Recovery',$message,$headers);
            $request->session()->session('success',$res_message);
            return back();
        }

        // now lets check if phone is from nepal or not.
        $user_detail = userDetail::where("phone_number",$request->username)->first();
        
        if ( ! $user_detail) {
            $request->session()->flash('success',$res_message);
            return back();
        }

        if ($user_detail->country == 153 || $user_detail->country == "Nepal") {



            // lets send them a message.
            $user_login = userLogin::where('user_detail_id',$user_detail->id)->first();

            // check if user have already issued sms today.
            $check_previous_record = PasswordRecovery::where('user_login_id',$user_login->id)
                                                        ->where('status',true)
                                                        ->first();
            if ( $check_previous_record &&  $check_previous_record->created_at->isToday() ) {
                $request->session()->flash("message","Only one SMS a day. Please use email address if your are having issue with SMS service.");
                return back();
            } elseif ($check_previous_record && ! $check_previous_record->created_at->isToday() ){
                $check_previous_record->status = false;
                $check_previous_record->save();
            }
            $passcode = $this->send_reset_password($user_detail,$user_login);
            // lets send sms
            // $passcode = true;
            if ( $passcode ) {
                $request->session()->flash('Check your registered phone number for reset code. Your Code will expire in 5 minute');
                $link = URL::temporarySignedRoute('public_reset_password_form',
                        now()->addMinutes(5),["key"=>encrypt($passcode->key)]);
                return redirect()->to($link);
            } else {
                $request->session()->flash('message',"Something went wrong while trying to send you a rest code.");
                return back();
            }
        }
        $message = "Sorry, We coludn't reset your password at the moment.";
        $request->session()->flash('message',$message);
        return back();
    }

    public function verify_password_link(Request $request) {
        // dd(decrypt($request->key)); 
        if (! $request->hasValidSignature() ) {
            abort(401);
        }
        $validate = PasswordRecovery::where('key',decrypt($request->key))
                                        ->where('status',true)
                                        ->first();
        return view("auth.change-password",compact('validate'));
    }

    public function save_change_password(Request $request) {

        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
        if ( ! $request->key ) {
            $request->session()->flash("message","Misleading information deted.");
            return back();
        }

        // lets search avaibility.
        $validate = PasswordRecovery::where('key',$request->key)
                                        ->where('status',true)
                                        ->first();
        if ( ! $validate ) {
            $request->session()->flash("message","Invalid Request.");
            return back();
        }

        // lets fetch user login information.
        $user_login = userLogin::find($validate->user_login_id);

        if ( ! $user_login ) {
            $request->session()->flash("message","Invalid Link or User Information Missing.");
            return back();
        }

        // now lets change password and redirect user to login page.
        $user_login->password = Hash::make($request->password);

        try {
            $validate->status = false;
            $validate->save();
            $user_login->save();
        } catch (\Throwable $th) {
            $request->session()->flash('message','Oops, Something went wrong. Please try again.');
            return back();
        }

        $request->session()->flash('success',"Password changed. Please login using your changed password.");
        return redirect()->route("public_user_login");
    }

    public function verify_password_reset_covery(Request $request) {
        
        if (! $request->hasValidSignature() ) {
            abort(401);
        }

        $validate = PasswordRecovery::where('key',decrypt($request->key))
                                    // ->where('status',true)
                                    ->first();
        return view("auth.reset-code",compact('validate'));
    }

    public function confirm_reset_password(Request $request) {

        $request->validate([
            'reset_code' => "required|min:6|string",
            'password' => "required|confirmed|min:6"
        ]);
        // if ( ! $request->key ) {
        //     $request->session()->flash("message","Misleading information deted.");
        //     return back();
        // }

         // lets search avaibility.
         $validate = PasswordRecovery::where('key',$request->reset_code)
                                        ->where('status',true)
                                        ->first();
        if ( ! $validate ) {
            $request->session()->flash("message","Invalid Request.");
            return back();
        }
        $date = \Carbon\Carbon::parse($validate->created_at);
        // dd($date)
        if ( $validate &&  ! $validate->created_at->isToday() ) {
            $request->session()->flash('message',"Your code is invalid.");
            return back();
        }
        // lets fetch user login information.
        $user_login = userLogin::find($validate->user_login_id);

        if ( ! $user_login ) {
            $request->session()->flash("message","Invalid Link or User Information Missing.");
            return back();
        }

        // now lets change password and redirect user to login page.
        $user_login->password = Hash::make($request->password);

        try {
            $validate->status = false;
            $validate->save();
            $user_login->save();
        } catch (\Throwable $th) {
            $request->session()->flash('message','Oops, Something went wrong. Please try again.');
            return back();
        }

        $request->session()->flash('success',"Password changed. Please login using your changed password.");
        return redirect()->route("public_user_login");
    }
}
