<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\StoreProfileRequest;
use App\Http\Requests\Frontend\User\UpdatePersonalRequest;
use App\Http\Traits\UploadHandler;
use App\Models\Live;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    use UploadHandler;
    public function index()
    {
        // get live event
        $enrolledPrograms  = ProgramStudent::where('student_id', auth()->id())->with(['live', "program"])->get();
        return view("frontend.user.dashboard", compact("enrolledPrograms"));
    }

    public function account()
    {
        return view("frontend.user.account");
    }

    public function connections()
    {
        return view("frontend.user.connections");
    }
    public function notifications()
    {
        return view("frontend.user.notifications");
    }

    public function storeProfile(StoreProfileRequest $request)
    {
        $this->set_upload_path("website/profile");
        $user = auth()->user();
        $user->profile = $this->upload($request, "profileMedia");

        try {
            $user->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to upload profile.");
            return back();
        }

        session()->flash("success", "Profile Updated.");
        return back();
    }

    public function storeDetail(UpdatePersonalRequest $request)
    {
        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;

        if ($user->isDirty()) {
            $user->full_name = $user->first_name . ($request->middle_name) ? " " . $request->middle_name  . " " . $request->last_name : " " . $request->last_name;
        }

        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->address = ["street_address" => $request->address];
        $user->city = $request->state;
        $user->country = $request->country;

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
}
