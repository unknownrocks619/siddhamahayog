<?php

namespace App\Http\Controllers\Frontend\User;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\StoreProfileRequest;
use App\Http\Requests\Frontend\User\UpdatePersonalRequest;
use App\Http\Requests\Frontend\User\Notifications\SingleNotificationRequest;
use App\Http\Traits\UploadHandler;
use App\Models\Live;
use App\Models\Member;
use App\Models\MemberNotification;
use App\Models\MemberRefers;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    use UploadHandler;
    public function index()
    {
        // get live event
        $enrolledPrograms  = ProgramStudent::where('student_id', auth()->id())->with(['live', "program" => function ($query) {
            return $query->with(["student_admission_fee"]);
        }])->get();
        $openProgram = Program::where('program_type', 'open')->with(['liveProgram' => fn($query) => $query->where('live', true)])->get();
        return view("frontend.user.dashboard", compact("enrolledPrograms", "openProgram"));
    }

    /**
     * @param Member|null $member
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function account(?Member $member = null): \Illuminate\Contracts\View\View
    {
        // check if this user has access to this user info.\
        if ($member ) {
            $hasAccess = user()->myMembers()->where('student_id', $member->getKey())->first();
            if ( ! $hasAccess ) {
                $member = user();
            }
        }

        if ( ! $member ) {
            $member = user();
        }
        return view("frontend.user.account",['member' => $member]);
    }

    public function connections(Request $request)
    {
        if ($request->post()) {
            $referalModal = new MemberRefers();
            $referalModal->fill([
                'member_id' => auth()->id(),
                'full_name' => $request->post('full_name'),
                'phone_number'  => $request->post('phone_number'),
                'email_address' => $request->post('email'),
                'country'   => $request->post('country'),
                'status'    => 'pending'
            ]);

            $referalModal->save();
        }

        return view("frontend.user.connections");
    }
    public function notifications()
    {
        $notifications = MemberNotification::where('member_id', auth()->id())->latest()->cursor();
        return view("frontend.user.notification.notifications", compact("notifications"));
    }

    public function singleNotification(SingleNotificationRequest $request, MemberNotification $notification)
    {
        return view('frontend.user.notification.notification-body', compact('notification'));
    }

    public function markNotification(SingleNotificationRequest $request, MemberNotification $notification)
    {
        $notification->seen = true;
        $notification->save();
    }

    public function storeProfile(StoreProfileRequest $request, ?Member $member = null)
    {
        $this->set_upload_path("website/profile");
        if ( $member ) {
            $hasAccess = user()->myMembers()->where('student_id',$member->getKey())->first();
            if ( ! $hasAccess ) {
                $user = auth()->user();
            } else {
                $user = $member;
            }
        } else {
            $user = auth()->user();
        }

        $uploadImage = Image::uploadImage($request->profileMedia, $user);

        if (empty($uploadImage)) {
            return $this->returnResponse(false, 'Unable to upload profile.', 'reload', [], 200, route('user.account.list'));
        }

        $relationImage = $uploadImage[0]['relation'];
        $relationImage->type = 'profile_picture';
        $relationImage->save();
        return $this->returnResponse(true, 'Profile Updated.', 'reload', [], 200, route('user.account.list'));

        //        $user->profile = $this->upload($request, "profileMedia");
        //
        //        try {
        //            $user->save();
        //        } catch (\Throwable $th) {
        //            //throw $th;
        //            session()->flash("error", "Unable to upload profile.");
        //            return back();
        //        }
        //
        //        session()->flash("success", "Profile Updated.");
        //        return back();
    }

    public function storeDetail(UpdatePersonalRequest $request, ?Member $member=null)
{
    if ( $member ) {
        $isAllowed = user()->myMembers()->where('student_id',$member->getKey())->first();
        if ( ! $isAllowed ) {
            abort( 403);
        }
        $user = $member;
    } else {
        $user = auth()->user();
    }
    $user->first_name = $request->post('first_name');
    $user->middle_name = $request->post('middle_name');
    $user->last_name = $request->post('last_name');

    if ($user->isDirty()) {
        $user->full_name = ucfirst($user->first_name) . ($request->post('middle_name')) ? " " . $request->post('middle_name')  . " " . ucfirst($request->post('last_name')) : " " . ucfirst($request->post('last_name'));
    }

    $user->gender = $request->post('gender');

    if ($user->phone_number && ! $user->is_phone_verified) {
        $user->phone_number = $request->post('phone_number');
    }

    $user->address = ["street_address" => $request->post('address]')];
    $user->city = $request->post('state');
    $user->country = $request->post('country');

    if ( $user->getKey() != user()->getKey()) {

        /** Email */
        if (! $user->email || $request->post('email')) {

            $request->validate([
                'email' => 'required_unless:country,153|email:rfc,dns'
            ],['email.required_unless' => 'Invalid Email Address']);

            /** Check if email is already in use. */
            if( Member::where('email',$request->post('email'))->where('id','!=',$user->getKey())->exists() ) {
                session()->flash('error','Invalid Email Address.');
                return back()->withInput();
            }
            if ($request->post('email') ) {
                $user->fill(['email' => $request->post('email')]);
            }
        }

        if ( ! $user->phone_number ) {

            $request->validate([
                'phone_number' => 'required_if:country,153',
            ],['phone_number.required_if'=> 'Phone number is required']);

            // check if user with this phone number exists.
            if( Member::where('phone_number',$request->post('phone_number'))->where('id','!=',$user->getKey())->exists() ) {
                session()->flash('error','Invalid Phone Number.');
                return back()->withInput();
            }

            if ($request->post('phone_number') ) {
                $user->phone_number = $request->post('phone_number');
            }

        }

    } else {

        if ($user->isDirty('email') ) {
            $request->validate([
                'email' => 'email:rfc,dns'
            ],['email' => 'Invalid Email Address']);

            if (Member::where('email',$request->post('email'))->where('id','!=',$user->getKey())->exists()) {
                session()->flash('error','Invalid Email Address.');
                return back()->withInput();
            }

        }

        if ($user->isDirty('phone_number'))  {
            if (Member::where('phone_number',$request->post('phone_number'))->where('id','!=',$user->getKey())->exists()) {
                session()->flash('error','Invalid Phone Number.');
                return back()->withInput();
            }
        }

    }

    try {
        $user->save();
    } catch (\Throwable $th) {
        //throw $th;
        session()->flash("error", "Unable to update your detail.");
        return back()->withInput();
    }


    session()->flash("success", "Information Updated.");
    return back();
}

    public function removeAdminAccess(Request $request)
    {
        if (!session()->has('adminAccount')) {
            abort(404);
        }
        $user = user();
        Auth::guard('web')->logout();

        Auth::guard('admin')->loginUsingId(session()->get('admin')->getKey());
        session()->flash('success', 'Debug Mode Ended.');
        return redirect()->route('admin.members.show', $user->getKey());
    }

    public function deleteConnection(MemberRefers $connection)
    {

        if ($connection->status != 'pending') {
            session()->flash('error', 'Refer is already in follow up process.');
            return redirect()->back();
        }

        $connection->delete();

        session()->flash('success', 'Deleted Successfully');
        return redirect()->back();
    }
}
