<?php

namespace App\Http\Controllers\Frontend\Arthapanchawk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\EsewaController;
use App\Http\Requests\Frontend\User\Sadhana\SadhanaEnrollStoreRequest;
use App\Http\Requests\Frontend\User\Sadhana\SadhanaStoreRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\EsewaPreProcess;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use App\Models\MemberInfo;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentEnroll;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ArthapanchawkController extends Controller
{
    use CourseFeeCheck;
    //
    private $_id = 2;

    public function index()
    {
        $user_record = [];

        if (auth()->check() && auth()->user()->role_id == 1) {
            $user = auth()->user();
            $userMeta = $user->meta;
            $emergencyInfo = $user->emergency;
            $user_record = [
                "first_name" => $user->first_name,
                "middle_name" => $user->middle_name,
                "last_name" => $user->last_name,
                'phone_number' => $user->phone_number,
                'gender' => ($user->gemder) ? $user->gender : (($userMeta && $userMeta->persona && isset($userMeta->personal->gender)) ? $userMeta->personal->gender : ''),
                'date_of_birth' => ($user->date_of_birth) ? $user->date_of_birth : (($userMeta && $userMeta->persona && isset($userMeta->personal->date_of_birth)) ? $userMeta->personal->date_of_birth : ''),
                'place_of_birth' => ($userMeta && $userMeta->personal && isset($userMeta->personal->place_of_birth)) ? $userMeta->personal->place_of_birth : '',
                'country' => ($user->country) ?? '153',
                "state" => $user->city ? $user->city  : (($userMeta && $userMeta->persona && isset($userMeta->personal->state)) ? $userMeta->personal->state : ''),
                'street_address' => ($user->address && isset($user->address->street_address)) ? $user->address->street_address : (($userMeta && $userMeta->persona && isset($userMeta->personal->street_address)) ? $userMeta->personal->street_address : ''),
                'education' => ($userMeta && $userMeta->education && isset($userMeta->education->education)) ? $userMeta->education->education : '',
                'education_major' => ($userMeta && $userMeta->education && isset($userMeta->education->education_major)) ? $userMeta->education->education_major : '',
                'profession'  => ($userMeta && $userMeta->education && isset($userMeta->education->profession)) ? $userMeta->education->profession : '',
                'referer_person' => ($userMeta && $userMeta->remarks && isset($userMeta->remarks->referer_person)) ? $userMeta->remarks->referer_person : '',
                'referer_relation' => ($userMeta && $userMeta->remarks && isset($userMeta->remarks->referer_relation)) ? $userMeta->remarks->referer_relation : '',
                "referer_contact"  => ($userMeta && $userMeta->remarks && isset($userMeta->remarks->referer_contact)) ? $userMeta->remarks->referer_contact : '',
                'emmergency_contact_name' => ($emergencyInfo) ? $emergencyInfo->contact_person : "",
                'emmergency_contact_relation' => ($emergencyInfo) ? $emergencyInfo->relation : "",
                'emmergency_contact_number' => ($emergencyInfo) ? $emergencyInfo->phone_number : "",
            ];
            return view("frontend.page.vedanta.index_updated", compact('user_record'));
        }

        return view("frontend.page.vedanta.index", compact('user_record'));
    }

    public function create()
    {
        if (ProgramStudent::where('program_id', $this->_id)->where('student_id', auth()->id())->exists() && auth()->user()->meta && auth()->user()->emergency) {
            session()->flash("success", "You have already subscribed this program.");
            return redirect()->route('dashboard');
        }
        return view("frontend.page.vedanta.create");
    }

    public function store(SadhanaStoreRequest $request)
    {
        $unicode_character = check_unicode_character($request->all());

        if ($unicode_character) {
            if (auth()->user()->role_id == 1) {
                return response(['errors' => $unicode_character, 'message' => "Unicode Characters are not supported."], 422);
            }
            session()->flash('error', "Unicode Not Supported.");
            return back()->withInput()->withErrors($unicode_character);
        }

        if (!auth()->check()) {
            $this->nonAutheticatedUser($request);
        }

        $user = auth()->user();

        // check if emergency contact already exists.
        $emergencyInfo = $user->emergency_contact()->where('phone_number', $request->emergency_phone)->where('member_id', auth()->id())->first();

        $emergency_contact = ($emergencyInfo) ?  $emergencyInfo : new MemberEmergencyMeta();
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
            "education_major" => $request->post('field_of_study'),
            "profession" => $request->profession
        ];

        if ($request->referer_person) {
            $remarks = [
                "referer_person" => $request->referer_person,
                "referer_relation" => $request->referer_relation,
                "referer_contact" => $request->referer_contact
            ];
            $userInfo->remarks = $remarks;
        }
        $user->first_name = $request->post('first_name');
        $user->middle_name = $request->post('middle_name');
        $user->last_name = $request->post('last_name');

        $full_name = $request->post('first_name');

        if ($user->middle_name) {
            $full_name .= " ";
            $full_name .= $request->post('middle_name');
        }

        $full_name .= " ";
        $full_name .= $request->post('last_name');
        $user->full_name = $full_name;
        $user->country = $request->country;
        $user->city = $request->state;
        $user->address = ["street_address" => $request->street_address];
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->post('date_of_birth');
        $userInfo->member_id = ($userInfo->member_id) ? $userInfo->member_id : $user->id;
        $user->gender = $request->post('gender');
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
            session()->flash("error", 'Oops ! Something went wrong.');
            return response(['errors' => [], 'message' => "Error: Please Try Again."]);
        }
        session()->flash('success', "Information Updated.");

        $userMeta = $user->meta;
        $user_record = [
            'midicine_history' => ($userMeta && $userMeta->history && isset($userMeta->history->medicine_history)) ? $userMeta->history->medicine_history : "no",
            'mental_health_history' => ($userMeta && $userMeta->history && isset($userMeta->history->mental_health_history)) ? $userMeta->history->mental_health_history : "no",
            'regular_medicine_history_detail' => ($userMeta && $userMeta->history && isset($userMeta->history->regular_medicine_history_detail)) ? $userMeta->history->regular_medicine_history_detail : null,
            'mental_health_detail_problem' => ($userMeta && $userMeta->history && isset($userMeta->history->mental_health_detail_problem)) ? $userMeta->history->mental_health_detail_problem : null,
        ];

        if (auth()->user()->role_id == 1) {
            return view('frontend.page.vedanta.form-step-two', compact("user_record"));
        }
        return redirect()->route('vedanta.create_two');
    }

    /**
     * 
     */
    private function nonAutheticatedUser(Request $request): \Illuminate\Http\Response
    {
        $user = new Member();

        $user->first_name = $request->post('first_name');
        $user->middle_name = $request->post('middle_name');
        $user->last_name = $request->post('last_name');

        $full_name = $request->post('first_name');

        if ($request->post('middle_name')) {
            $full_name .= " ";
            $full_name .=  $request->post('middle_name');
        }
        $full_name .= " ";
        $full_name .= $request->post('last_name');
        $user->full_name = $full_name;

        $user->source = "portal";
        $user->gender = $request->post('gender');
        $user->country = $request->post('country');
        $user->city = $request->post('state');
        $user->address = ['street_address' => $request->post('street_address')];
        $user->date_of_birth = $request->post('date_of_birth');
        $user->email = $request->post('email');
        $user->password = Hash::make($request->post('password'));
        $user->phone_number = $request->post('phone_number');
        $user->role_id = 7;
        $user->sharing_code = Str::uuid();

        try {
            $user->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(['errors' => [], 'message' => "Error: Please try again later " . $th->getMessage(), "success" => false], 422);
        }
        Auth::login($user);

        return response(['errors' => [], 'message' => "User Record Created", "success" => true], 200);
    }

    public function createTwo()
    {
        if (ProgramStudent::where('program_id', $this->_id)->where('student_id', auth()->id())->exists()  && auth()->user()->meta && auth()->user()->emergency) {
            session()->flash("success", "You have already subscribed this program.");
            return redirect()->route('dashboard');
        }
        return view("frontend.page.vedanta.createTwo");
    }

    public function storeTwo(SadhanaEnrollStoreRequest $request)
    {
        $unicode_character = check_unicode_character($request->all());
        if ($unicode_character) {
            return back()->withInput()->withErrors($unicode_character);
        }
        $user = auth()->user();

        $history = [
            "medicine_history" => $request->regural_medicine_history,
            "mental_health_history" => $request->mental_health_history,
            "regular_medicine_history_detail" => $request->regular_medicine_history_detail,
            "mental_health_detail_problem" => $request->mental_health_detail_problem,
            "practiced_info" => $request->practiced_info,
            "support_in_need" => $request->support_in_need,
            "terms_and_condition" => $request->terms_and_condition,
            "sadhak" => $request->user_sadhak
        ];
        $user->meta->history = $history;
        $programStudent =  new ProgramStudent();
        $vedantaProgram = Program::with(["active_batch", "active_fees", "active_sections"])->where('status', "active")->where('id', $this->_id)->first();
        $complete_url = URL::temporarySignedRoute("vedanta.payment.create", now()->addMinute(10));

        try {
            $user->meta->save();
            $user->save();
            if (!$vedantaProgram || !$vedantaProgram->active_batch  || !$vedantaProgram->active_sections) {
                return response(['errors' => [], 'message' => "Unable to enroll at the moment. Please try again later"], 422);
                session()->flash('error', "Unable to enroll at the moment. Please try again later.");
                return back()->withInput();
            }

            if (ProgramStudent::where('student_id', auth()->id())->where('program_id', $vedantaProgram->id)->exists()) {
                if (!$this->checkFeeDetail($vedantaProgram, "admission_fee")) {
                    session()->flash("success", "Information Updated.");
                    return redirect()->to($complete_url);
                }
                if (auth()->user()->role_id == 1) {
                    $program = Program::find($this->_id);
                    $alreadyEnrolled = true;
                    return view('frontend.page.vedanta.form-step-final', compact('program', 'alreadyEnrolled'));
                }
                session()->flash("success", 'You have already subscribed.');
                return redirect()->route("dashboard");
            }
            $programStudent->program_id = $vedantaProgram->id;
            $programStudent->student_id = auth()->id();
            $programStudent->batch_id = $vedantaProgram->active_batch->id;
            $programStudent->program_section_id = $vedantaProgram->active_sections->id;
            $programStudent->active = true;
            $programStudent->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(['errors' => [], 'message' => $th->getMessage()], 422);
            session()->flash("error", "Oops ! Something went wrong. Please try again.");
            return back()->withInput();
        }

        if (auth()->user()->role_id == 1) {
            if (!ProgramStudent::where('program_id', $this->_id)->where('student_id', user()->id)->exists()) {
                return response(['errors' => [], 'message' => 'Oops ! Something went wrong. Please try again.'], 422);
            }
        }
        if (!ProgramStudent::where('program_id', $this->_id)->where('student_id', user()->id)->exists()) {
            session()->flash('error', "Oops ! Something went wrong. Please Try agian.");
            return back()->withInput();
            // return response(['errors' => [], 'message' => 'Oops ! Something went wrong. Please try again.'], 422);
        }
        $program = Program::find($this->_id);

        if (auth()->user()->role_id == 1) {
            return view('frontend.page.vedanta.form-step-final', compact('program'));
        }
        return redirect()->to($complete_url);
    }

    public function payment()
    {
        // now let's check if data is available in meta.
        if (!auth()->user()->meta || !auth()->user()->emergency) {
            session()->flash("error", "Some of your information is missing. Please fill all the information before proceeding further.");
            return redirect()->route('vedanta.create');
        }

        return view("frontend.page.vedanta.payment", compact("program"));
    }

    public function paymentProcessor(Program $program)
    {
        $url = config('services.esewa.redirect');
        $fee_type = ($program->student_admission_fee) ? 'monthly_fee' : 'admission_fee';
        $pid = (string) Str::uuid();
        $data = [
            'amt' => $program->active_fees->$fee_type,
            'pdc' => 0,
            'psc' => 0,
            'txAmt' => 0,
            'tAmt' => $program->active_fees->$fee_type,
            'pid' => $pid,
            'scd' => config("services.esewa.merchant_code"),
            'su' => route('vedanta.payment.success', $program->id),
            'fu' => route('vedanta.payment.failed', [$program->id, 'pid' => $pid])
        ];
        $esewaController = new EsewaController;
        $esewaController->set_config($data);

        /**
         * Store in Db
         */
        $storeInDb = new EsewaPreProcess();
        $storeInDb->member_id = auth()->id();
        $storeInDb->pid = $data['pid'];
        $storeInDb->amount = $data['amt'];
        $storeInDb->save();

        /**
         * End in Store
         */
        return $esewaController->process_payment_html();
        $output =  "<form method='POST' action='{$url}' id='esewa_form' class='d-none'>";
        foreach ($data as $payment_key => $payment_value) :
            $output .= "<input type='hidden' value='{$payment_value}' name='{$payment_key}' />";
        endforeach;
        $output .= "</form>";

        // autosubmit form
        $output .= "<script type='text/javascript'>";
        $output .= "document.getElementById('esewa_form').submit();";
        $output .= "</script>";

        return $output;
        // $curl = curl_init($url);
        // curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($curl);
        // echo $response;
        // curl_close($curl);
    }

    public function paymentSuccess(Program $program)
    {
        $esewaController = new EsewaController;
        if (!$esewaController->verify_payment()) {
            $storeInDb = EsewaPreProcess::where('pid', request()->get('oid'))->where('member_id', auth()->id())->first();
            if ($storeInDb) {
                $storeInDb->status = "cancelled";
                $storeInDb->save();
            }
            return $this->paymentFailed($program);
        }
        // now formally enroll user in program.
        $notification =  new MemberNotification;
        $notification->member_id = auth()->id();
        $notification->title = "Payment Success ";
        $notification->notification_type = "App\Models\Program";
        $notification->notification_id = $program->id;
        $notification->body = "Congratulation ! Your admissin fee for " . $program->program_name . " was successfully paid.";
        $notification->type = "message";
        $notification->level = "notice";
        $notification->seen = false;

        $enrollUser = null;
        // also enroll the user in course.
        if (!ProgramStudentEnroll::where('program_id', $program->id)->where('member_id', auth()->id())->exists()) {
            $enrollUser = new ProgramStudentEnroll;
            $enrollUser->program_id = $program->id;
            $enrollUser->member_id = auth()->id();
            $enrollUser->enroll_date = date("Y-m-d");
            $enrollUser->program_course_fee_id = $program->active_fees->id;
            $enrollUser->scholarship = false;
        }

        $program_student_fee = ProgramStudentFee::where('program_id', $program->id)
            ->where('student_id', auth()->id())
            ->first();
        $fee_type = ($program->student_admission_fee) ? 'monthly_fee' : 'admission_fee';

        if ($program_student_fee) {
            $program_student_fee->total_amount = $program_student_fee->total_amount + $program->active_fees->$fee_type;
        } else {
            $program_student_fee = new ProgramStudentFee();
            $program_student_fee->program_id = $program->id;
            $program_student_fee->student_id = auth()->id();
            $program_student_fee->total_amount = $program->active_fees->$fee_type;
        }

        // fee detail.
        $program_student_fee_detail = new ProgramStudentFeeDetail();
        $program_student_fee_detail->program_id = $program->id;
        $program_student_fee_detail->student_id = auth()->id();
        $program_student_fee_detail->amount = $program->active_fees->$fee_type;
        $program_student_fee_detail->amount_category = $fee_type;
        $program_student_fee_detail->source = "online";
        $program_student_fee_detail->source_detail = "E-sewa Transaction";
        $program_student_fee_detail->verified = true;
        $program_student_fee_detail->remarks = request()->all();

        try {
            //code...
            DB::transaction(function () use ($program, $program_student_fee_detail, $program_student_fee, $enrollUser, $notification) {
                $notification->save();
                if ($enrollUser) {
                    $enrollUser->save();
                }
                $program_student_fee->save();
                $program_student_fee_detail->program_student_fees_id = $program_student_fee->id;
                $program_student_fee_detail->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Your payment couldn't be verified. Please make sure to create a support ticket for any issue");
            info('Payment make but couldn\'t save in  database. UUID for payment is ' . request()->oid, ["Program payment"]);
            // now formally enroll user in program.
            $notification =  new MemberNotification;
            $notification->member_id = auth()->id();
            $notification->title = "Payment Unverified ";
            $notification->notification_type = "App\Models\Program";
            $notification->notification_id = $program->id;
            $notification->body = "Your payment couldn't be verified. Please create a ticket with the reference id:  " . request()->oid;
            $notification->type = "message";
            $notification->level = "notice";
            $notification->seen = false;
            $notification->save();
            return redirect()->route('dashboard');
        }
        $storeInDb = EsewaPreProcess::where('pid', request()->get('oid'))->where('member_id', auth()->id())->first();
        if ($storeInDb) {
            $storeInDb->status = 'completed';
            $storeInDb->save();
        }
        session()->flash("success", 'Congratulation ! Your payment for ' . $program->program_name . ' has been paid.');
        return redirect()->route('dashboard');
    }

    public function paymentFailed(Program $program)
    {

        $notification =  new MemberNotification;
        $notification->member_id = auth()->id();
        $notification->title = "Payment Failed for " . $program->program_name;
        $notification->body = "Your payment fee for " . $program->program_name . " couldn't be completed. You can still try from your dashboard. If you think there is mistake in your transaction create a support ticket and include your Reference ID Available in esewa transaction.";
        if (request()->get('refId')) {
            $notification->body .= ' Esewa Reference Code : ' . request()->get('refId');
            $notification->body .= ' Esewa Reference Amount: ' . request()->get('amt');
            $notification->title = "Payment Verification Failed";
        }
        $notification->type = "message";
        $notification->level = "notice";
        $notification->seen = false;
        $storeInDb = EsewaPreProcess::where('pid', request()->get('pid'))->where('member_id', auth()->id())->first();
        if ($storeInDb) {
            $storeInDb->status = "cancelled";
            $storeInDb->save();
        }
        try {
            $notification->save();

            if (request()->get('refId') && request()->get('amt')) {
                $program_student_fee = ProgramStudentFee::where('program_id', $program->id)
                    ->where('student_id', auth()->id())
                    ->first();

                $fee_type = ($program->student_admission_fee) ? 'monthly_fee' : 'admission_fee';

                if (!$program_student_fee) {
                    $program_student_fee = new ProgramStudentFee();
                    $program_student_fee->program_id = $program->id;
                    $program_student_fee->student_id = auth()->id();
                    $program_student_fee->total_amount = 0;
                    $program_student_fee->save();
                }


                // fee detail.
                $program_student_fee_detail = new ProgramStudentFeeDetail();
                $program_student_fee_detail->program_id = $program->id;
                $program_student_fee_detail->student_id = auth()->id();
                $program_student_fee_detail->amount = request()->get('amt');
                $program_student_fee_detail->amount_category = $fee_type;
                $program_student_fee_detail->source = "online";
                $program_student_fee_detail->source_detail = "E-sewa Transaction";
                $program_student_fee_detail->verified = false;
                $program_student_fee_detail->remarks = request()->all();
                $program_student_fee_detail->message = "Unable to verify amount with esewa vendor.";
                $program_student_fee_detail->program_student_fees_id = $program_student_fee->id;
                $program_student_fee_detail->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            info("Unable to save record in member notification table. due to " . $th->getMessage(), ["Program Payment"]);
            session()->flash("error", "Your admission fee for " . $program->program_name . " couldn't be completed. Please try again.");
            return redirect()->route('dashboard');
        }


        session()->flash("error", "Your admission fee for " . $program->program_name . " couldn't be completed. Please try again.");
        return redirect()->route('dashboard');
    }
}
