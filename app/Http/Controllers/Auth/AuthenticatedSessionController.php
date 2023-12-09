<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Events\EventController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\GuestAccess;
use App\Models\Live;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Providers\RouteServiceProvider;
use App\Rules\GoogleCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Event;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('frontend.page.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route("dashboard");
        // return redirect()->route('vedanta.index');
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function createKey()
    {
        return view('frontend.page.auth.access-key');
    }

    public function storeKey(Request $request)
    {
        $request->validate(
            [
                "access_code" => 'required|uuid',
                // "recaptcha_token" => ["required", new GoogleCaptcha()]
            ]
        );

        // now check access_code.

        $guestAccess = GuestAccess::where('access_code', $request->access_code)->first();
        if (!$guestAccess) {

            return back()->withErrors(['access_code' => "Invalid or Access Code Already Used."]);
        }
        // check if it was already used.
        if ($guestAccess->used) {

            // if (!session()->has('vip_access')) {
            //     return back()->withErrors(['access' => 'Invalid or Access Code Already Used.']);
            // }

            // if (!$guestAccess->access_detail) {
            //     return back()->withErrors(['access' => "Invalid or Access Code Already Used."]);
            // }
            // return redirect()->to($guestAccess->access_detail->url);
        }

        $guestAccess->used = true;
        $settings = [
            "first_name" => trim($guestAccess->first_name), // . "(#)",
            "last_name" => trim($guestAccess->last_name),
            "email" => "T_" . time()  . "_" . strtolower($guestAccess->first_name) . "@siddhamahayog.org",
            "auto_approve" => true
        ];

        $live = Live::where('meeting_id', $guestAccess->meeting_id)
            ->where('program_id', $guestAccess->program_id)
            ->first();
        if (!$live || !$live->live) {
            return back()->withErrors(['access' => "Invalid or Access Code Already Used."]);
        }

        $registrationDetailResponse = register_participants($live->zoomAccount, $guestAccess->meeting_id, $settings);
        if (isset($registrationDetailResponse['code'])) {
            session()->flash('error', "Unable to join session. " . $registrationDetailResponse->message);
            return back();
        }

        $remarks = [
            'url' => $registrationDetailResponse['join_url'],
            $meta = [
                "zoom" => $registrationDetailResponse, //,
                "ip" => request()->ip(),
                "browser" => request()->header("User-Agent"),
                'additional_info' => [getUserLocation()]
            ],
        ];
        $guestAccess->access_detail = $remarks;

        if ($guestAccess->save()) {
            session()->put('vip_access', true);
            return redirect()->to($registrationDetailResponse['join_url']);
        }

        return back()->withErrors(['access_code', 'Unable to join session Please try again or contact support.']);
    }

    public function joinUsingExternal(Request $request) {

        if (! $request->get('user') || ! $request->get('program') ) {
            abort(404);
        }

        $userID =(int) $request->get('user');
        $programID = (int) $request->get('program');

        // validate usr first.
        $user = Member::where('id',$userID)->firstOrFail();

        // check if program is active
        $program = Program::where('id',$programID)
                            ->where('program_type','open')
                            ->where('status','active')
                            ->firstOrFail();
        // check if this user is registered in event.
        $programUser = ProgramStudent::where('program_id', $program->getKey())
                                        ->where('student_id',$user->getKey())
                                        ->firstOrFail();

        // now check if program is live.
        $live = Live::where('program_id',$program->getKey())
                        ->where('live',true)
                        ->latest()
                        ->firstOrFail();

        $settings = [
            "first_name" => trim($user->first_name), // . "(#)",
            "last_name" => trim($user->last_name),
            "email" => "T_" . time()  . "_" . strtolower($user->first_name) . "@siddhamahayog.org",
            "auto_approve" => true
        ];


        $openEvent = new EventController();
        $attendance = $openEvent->checkAndUpdateAttendance($program, $live, false,null,$user);
        $lock = $openEvent->isLiveLock($live);

        if ($lock) {
            return $lock;
        }

        return ($openEvent->markAttendance($program, $live,false,$user));
    }
}
