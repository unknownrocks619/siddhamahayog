<?php

namespace App\Http\Controllers\Frontend\User;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UserStoreRequest;
use App\Models\Member;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function store(UserStoreRequest $request)
    {
    }

    public function facebook()
    {
        $fb_user = Socialite::driver("facebook")->user();
        // check if user exists.

        $user_exists = Member::where('email', $fb_user->email)->first();

        if ($user_exists) {
            Auth::login($user_exists);
            return redirect()->intended();
        }

        $full_name = explode(" ", $fb_user->name);
        $member = new Member;
        $member->full_name = $fb_user->name;
        $member->first_name = $full_name[0];
        $member->middle_name = isset($full_name[2]) ? $full_name[1] : null;
        $member->last_name = isset($full_name[2]) ? $full_name[2] : $full_name[1];

        $member->source = "facebook";
        $member->external_source_id = $fb_user->id;
        $member->profileUrl = ["avatar" => $fb_user->avatar];
        $member->email = $fb_user->email;
        $member->password =  Hash::make(Str::random());
        $member->role_id = 7;
        $member->is_email_verified = true;


        $reference = new Reference;
        if (session()->has("_refU")) {
            $reference->referenced_by = session()->get('_refU')["id"];
        } else {
            $r_member = Member::where('sharing_code', request()->sharing_code);

            if ($r_member) {
                $reference->referenced_by = $r_member->id;
            }
        }

        try {
            $member->save();
            $reference->referenced_to = $member->id;
            if ($reference->referenced_by) {
                $reference->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to connect. Something went wrong.");
            return redirect()->route('login');
        }

        Auth::login($member);
        return redirect()->intended();
    }

    public function google()
    {
        $google_usr = Socialite::driver("google")->user();
        $user_exists = Member::where('email', $google_usr->user["email"])->first();
        dd($user_exists);
        if ($user_exists) {
            Auth::login($user_exists);

            return redirect()->intended();
        }

        $member = new Member;
        $member->full_name = $google_usr->user["name"];
        $member->first_name = $google_usr->user["given_name"];
        $member->last_name =  (isset($google_usr->user["family_name"]) && $google_usr->user["family_name"]) ? $google_usr->user["family_name"] : "Not Available";

        $member->source = "google";
        $member->external_source_id = $google_usr->user["sub"];
        $member->profileUrl = ["avatar" => $google_usr->user["picture"]];
        $member->is_email_verified = true;
        $member->email = $google_usr->user["email"];
        $member->password =  Hash::make(Str::random());
        $member->role_id = 7;



        $reference = new Reference;
        if (session()->has("_refU")) {
            $reference->referenced_by = session()->get('_refU')["id"];
        } else {
            $r_member = Member::where('sharing_code', request()->sharing_code);

            if ($r_member) {
                $reference->referenced_by = $r_member->id;
            }
        }
        try {
            $reference->referenced_to = $member->id;
            if ($reference->referenced_by) {
                $reference->save();
            }
            $member->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to connect. Something went wrong.");
            return redirect()->route('login');
        }

        Auth::login($member);

        return redirect()->intended();
    }
}
