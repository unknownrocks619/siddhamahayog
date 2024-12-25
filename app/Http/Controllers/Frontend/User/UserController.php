<?php

namespace App\Http\Controllers\Frontend\User;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UserStoreRequest;
use App\Models\Member;
use App\Models\Program;
use App\Models\Reference;
use App\Models\UserTrainingCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Psr\Container\NotFoundExceptionInterface;

class UserController extends Controller
{
    //

    public function store(UserStoreRequest $request) {}


    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface|NotFoundExceptionInterface
     */
    public function facebook(): RedirectResponse
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
        $member->setAttribute('email', $fb_user->email);
        $member->password =  Hash::make(Str::random());
        $member->role_id = 7;
        $member->is_email_verified = true;


        $reference = new Reference;
        if (session()->has("_refU")) {
            $reference->referenced_by = session()->get('_refU')["id"];
        } elseif (request()->sharing_code) {
            $r_member = Member::where('sharing_code', request()->sharing_code)->first();

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

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface|NotFoundExceptionInterface
     */
    public function google(): RedirectResponse
    {
        $google_usr = Socialite::driver("google")->user();
        $user_exists = Member::where('email', $google_usr->user["email"])->first();
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
        $member->setAttribute('email', $google_usr->user["email"]);
        $member->password =  Hash::make(Str::random());
        $member->role_id = 7;


        $reference = new Reference;
        if (session()->has("_refU")) {
            $reference->referenced_by = session()->get('_refU')["id"];
        } elseif (request()->sharing_code) {
            $r_member = Member::where('sharing_code', request()->sharing_code)->first();

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


    public function myMembers(Request $request, string $view = 'my-members', ?UserTrainingCourse $teacherCourse = null)
    {

        if (! in_array($view, ['my-members', 'members-list'])) {
            $view = 'my-members';
        }

        if ($view == 'members-list' && ! $teacherCourse?->getKey()) {
            abort(404);
        }

        if ($request->post() && $request->ajax()) {
            $sadhanaSession = $request->all();
            $sadhanaSession['training_type'] = 'Sadhana';
            $sadhanaSession['training_location'] = $sadhanaSession['training_location'] ?? '';
            if (! $sadhanaSession['training_location']) {

                $sadhanaSession['training_location'] = user()->address?->street_address ?? '-';

                if ($sadhanaSession['training_location'] != '-') {
                    $sadhanaSession['training_location'] = $sadhanaSession['training_location'] . ',' . user()->city;
                } else {
                    $sadhanaSession['training_location'] = user()->city;
                }
            }
            $sadhanaSession['group_name'] = $sadhanaSession['session_name'];
            $sadhanaSession['status'] = $sadhanaSession['session_status'];
            $sadhanaSession['event_id'] = Program::where('program_type', 'sadhana')->first()?->getKey();
            $sadhanaSession['training_type'] = 'Sadhana';
            $newSessionRequest = new Request($sadhanaSession, $sadhanaSession);
            return (new UserTeacherController())->teacherSession($newSessionRequest, user());
        }

        return view('frontend.user.members.' . $view, [
            // 'members' => user()?->myMembers()->get(),
            'sessions'   => user()?->mySession()->get(),
            'members' => $teacherCourse?->enrolledUsers()->get()
        ]);
    }
}
