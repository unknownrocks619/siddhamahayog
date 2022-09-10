<?php

namespace App\Http\Controllers\Frontend\Sadhana;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Enroll\SadhanEnrollController;
use App\Http\Controllers\Payment\EsewaController;
use App\Http\Requests\Frontend\User\Sadhana\SadhanaEnrollStoreRequest;
use App\Http\Requests\Frontend\User\Sadhana\SadhanaStoreRequest;
use App\Models\MemberEmergencyMeta;
use App\Models\MemberInfo;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SadhanaController extends Controller
{
    //

    public function index()
    {
        return view("frontend.page.sadhana.index");
        // return view('frontend.page.sadhana');
    }

    public function create(Request $request)
    {
        if (ProgramStudent::where('program_id', 1)->where('student_id', auth()->id())->exists()) {
            session()->flash("success", "You have already subscribed to this program.");
            return redirect()->route('dashboard');
        }
        return view("frontend.page.sadhana.create");
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
            session()->flash("error", "Oops ! Unable to process information.");
            info($th->getMessage(), ["Shadana Regsitration first step"]);
            return back()->withInput();
        }
        session()->flash('success', "Information Updated.");
        return redirect()->route('sadhana.create.history');
    }


    public function createHistory()
    {
        return view("frontend.page.sadhana.create-history");
    }

    public function storeHistory(SadhanaEnrollStoreRequest $request)
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
        $sadhana = Program::with(["active_batch", "active_fees", "active_sections"])->where('status', "active")->where('program_type', "sadhana")->first();
        try {
            $user->meta->save();
            if (!$sadhana || !$sadhana->active_batch  || !$sadhana->active_sections) {
                session()->flash('error', "Unable to enroll at the moment. Please try again later.");
                return back()->withInput();
            }
            $programStudent->program_id = $sadhana->id;
            $programStudent->student_id = auth()->id();
            $programStudent->batch_id = $sadhana->active_batch->id;
            $programStudent->program_section_id = $sadhana->active_sections->id;
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

    public function SadhanaEnrollComplete(Request $request)
    {
        $request->hasValidSignature(true);
        return view("frontend.page.sadhana.complete");
    }

    public function payment_process(Request $request)
    {
        return view('frontend.page.sadhana.payment', ['intent' => $request->user()->createSetupIntent()]);
        return ($request->user()->redirectToBillingPortal());
        $strip_id = auth()->user()->stripe_id;
        $user = Cashier::findBillable($strip_id);
        dd($user->balance());
        // $stripeCustomer = auth()->user()->createAsStripeCustomer();
        // dd($stripeCustomer);
    }

    public function complete_payment(Request $request)
    {
        dd($request->all());
    }

    public function local_payment_process(Request $request, $type = "yearly")
    {
        return view("test");
        $pid = time();
        session()->put('payment.esewa.yearly', ["price" => 500, "item" => "sadhana", "pid" => $pid]);

        $esewa = new EsewaController;
        $submission  = "<form id='esewa_form' method='post' style='display:none' action='{$esewa->get_url()}'>";
        $esewa->set_config(
            ["amt" => 450, "tAmt" => 450, "txAmt" => 0, "pdc" => 0, "psc" => 0, "pid" => time()]
        );
        foreach ($esewa->get_configs() as $key => $value) {
            $submission .= "<input type='hidden' name='{$key}' value='{$value}' />";
        }

        $submission .= "</form>";

        $submission .= "<script type='text/javascript'>";
        $submission .= "document.getElementById('esewa_form').submit();";
        $submission .= "</script>";

        echo $submission;
    }


    public function local_payment_success(Request $request)
    {
        $esewa = new EsewaController;
        $session_data = session()->get("payment.esewa.yearly");

        $esewa->set_config([
            "amt" => 450, //$session_data["price"],
            "pid" => $session_data["pid"],
            "rid" => $request->refId
        ]);

        if (!$this->verify_payment($request)) {
            session()->flash("message", "Error, Unable to process your Payment.");
            return redirect()->route('dashboard');
        }
        // complete remaining part.
        $program = Program::where('program_type', 'sadhana')->where('status', 'active')->first();
        $sadhana_enroll = new SadhanEnrollController;
        $sadhana_enroll->enroll_student($request, $program->id, auth()->id());
    }
}
