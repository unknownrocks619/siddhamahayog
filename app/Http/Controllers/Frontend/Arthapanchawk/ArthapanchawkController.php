<?php

namespace App\Http\Controllers\Frontend\Arthapanchawk;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Sadhana\SadhanaEnrollStoreRequest;
use App\Http\Requests\Frontend\User\Sadhana\SadhanaStoreRequest;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class ArthapanchawkController extends Controller
{
    //
    private $_id = 2;

    public function index()
    {
        return view("frontend.page.vedanta.index");
    }

    public function create()
    {
        if (ProgramStudent::where('program_id', $this->_id)->where('student_id', auth()->id())->exists()) {
            session()->flash("success", "You have already subscribed this program.");
            return back();
        }
        return view("frontend.page.vedanta.create");
    }

    public function store(SadhanaStoreRequest $request)
    {
        $user = auth()->user();
        // check if emergency contact already exists.
        $emergencyInfo = $user->emergency_contact()->where('phone_number', $request->emergency_phone)->where('member_id', auth()->id())->first();

        $emergency_contact = ($emergencyInfo) ?  $emergencyInfo : new MemberEmergencyMeta;
        $emergency_contact->member_id = auth()->id();
        $emergency_contact->contact_person = $request->emergency_contact_person;
        $emergency_contact->relation = $request->emergency_contact_person_relation;
        $emergency_contact->phone_number = $request->emergency_phone;
        // user meta info.
        $userInfo =  (auth()->user()->meta) ? MemberInfo::where("member_id", auth()->user()->id)->first() :  new MemberInfo;
        $personal = [
            "date_of_birth" => $request->date_of_birth,
            "place_of_birth" => $request->place_of_birth,
            "street_address" => $request->street_address,
            "state" => $request->state,
            "gender" => $request->gender
        ];

        $education = [
            "education" => $request->education,
            "education_major" => $request->education_major,
            "profession" => $request->profession
        ];

        $user->country = $request->country;
        $user->city = $request->state;
        $user->address = ["street_address" => $request->street_address];

        $userInfo->member_id = ($userInfo->member_id) ? $userInfo->member_id : $user->id;
        $userInfo->personal = $personal;
        $userInfo->education = $education;

        try {
            DB::transaction(function () use ($user, $userInfo, $emergency_contact) {
                if ($user->isDirty()) {
                    $user->save();
                }
                // $user->emergency_contact()->delete();
                $userInfo->save();
                if ($emergency_contact->isDirty()) {
                    $emergency_contact->save();
                }
            });
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withInput();
        }
        session()->flash('success', "Information Updated.");
        return redirect()->route('vedanta.create_two');
    }

    public function createTwo()
    {
        return view("frontend.page.vedanta.createTwo");
    }

    public function storeTwo(SadhanaEnrollStoreRequest $request)
    {
        $user = auth()->user();

        $history = [
            "medicine_history" => $request->regural_medicine_history,
            "mental_health_history" => $request->mental_health_history,
            "regular_medicine_history_detail" => $request->regular_medicine_history_detail,
            "mental_health_detail_problem" => $request->mental_health_detail_problem,
            "practiced_info" => $request->practiced_info,
            "support_in_need" => $request->support_in_need,
            "terms_and_condition" => $request->terms_and_condition
        ];
        $user->meta->history = $history;
        $programStudent = new ProgramStudent();
        $vedantaProgram = Program::with(["active_batch", "active_fees", "active_sections"])->where('status', "active")->where('id', $this->_id)->first();

        try {
            $user->meta->save();
            if (!$vedantaProgram || !$vedantaProgram->active_batch  || !$vedantaProgram->active_sections) {
                session()->flash('error', "Unable to enroll at the moment. Please try again later.");
                return back()->withInput();
            }
            $programStudent->program_id = $vedantaProgram->id;
            $programStudent->student_id = auth()->id();
            $programStudent->batch_id = $vedantaProgram->active_batch->id;
            $programStudent->program_section_id = $vedantaProgram->active_sections->id;
            $programStudent->active = true;
            $programStudent->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Oops ! Something went wrong. Please try again.");
            return back()->withInput();
        }

        session()->flash("success", "Thank-you for your registration,Please wait.. while we redirect to your dashboard.");
        $complete_url = URL::temporarySignedRoute("sadhana.process.complete", now()->addMinute(2));
        return redirect()->to($complete_url);
    }

    public function enroll()
    {
    }
}
