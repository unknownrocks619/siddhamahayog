<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\SibirRecord;
use App\Models\EventFund;
use App\Models\EventFundDetail;
use App\Models\userLogin;
use App\Models\userDetail;
use App\Models\UserNotification;

class CourseController extends Controller
{
    //

    public function index() {
        $courses = Courses::latest()->paginate(10);
        return view("admin.finance.courses.list",compact('courses'));
    }

    public function create() {
        $sibirs = SibirRecord::get();
        return view('admin.finance.courses.add',compact('sibirs'));
    }

    public function store(Request $request) {
        
        $total_amount = (float) $request->admission_fee + (float) $request->full_course_fee;
        $sibir_record = SibirRecord::findOrFail($request->sibir_record);
        $course = new Courses;
        $course->sibir_record_id = $request->sibir_record;
        $course->admission_fee = $request->admission_fee;
        $course->course_fee = $request->full_course_fee;
        $course->is_paid = ($request->full_course_fee) ? true : false;
        $course->is_free = ($request->full_course_fee && $request->admission_fee) ? false : true;
        $course->is_admission_started = true;
        $course->course_title = $sibir_record->sibir_title;
        $course->course_description = $request->course_description;
        $course->course_start_from = $request->course_start_from;
        $course->course_end = $request->course_end_from;
        $course->payment_type = json_encode(["monthly",'annualy','bi-annualy','quartely']);
        $course->is_admission_closed = false;
        $course->total_amount = $total_amount;

        try {
            $course->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Unable to save. Error: " . $th->getMessage());
            return back()->withInput();
        }

        $request->session()->flash('success',"New Course Added.");
        return redirect()->route('courses.admin_course_list');
    }

    public function course_report(Request $request,Courses $course) {
        // fetch course total amount.
        $total_fee = EventFundDetail::where("status", 'verified')
                                                        ->where('source','!=','scholarship')->get()->sum('amount');
        $admission_amount = EventFundDetail::where('admin_remarks','admission fee')->get()->sum('amount');
        $scholarship = EventFundDetail::where('source','scholarship')->get()->sum("amount");
        // $scholarship = EventFund::where('scholarship',true)->get()->sum('fund_amount');
        // $total_amount = $total_amount_with_scholarship - $scholarship;
        // fetch course admission amount
        return view('admin.finance.courses.report',
                compact(
                    'total_fee',
                    'admission_amount','scholarship','course')
            );
    }

    public function generate_report(Request $request, Courses $course) {
        if ( ! isAdmin() ) {
            return 404;
        }
        if ($request->sadhak) {
            // check is email or phone.
            $is_email = filter_var($request->sadhak,FILTER_VALIDATE_EMAIL);
            if ($is_email ) {
                $user_login = userLogin::where("email",$request->sadhak)->first();

                if (! $user_login ) {
                    return "Record Not Found";
                }

                $user_detail = $user_login->userdetail;
            } else {
                $user_detail = userDetail::where("phone_number",$request->sadhak)->first();
            }

            if ( ! $user_detail ) {
                return "User Login ID / Email Doesn't match system database.";
            }
        }

        if ($request->record_type == "transaction") {
            if ( $request->month ) {
                $transactions = EventFundDetail::where("created_at","like",$request->year."-".$request->month.'%');
            } else {
                $transactions = EventFundDetail::where('updated_at','like',$request->year.'%');
            }

            if ($request->sadhak) {
                $transactions->where('user_detail_id',$user_detail->id);
            }
            $transactions->where('sibir_record_id',$course->sibir_record_id);
            $funds = $transactions->with(["user_detail"])->paginate(30);
        }

        if ($request->record_type == "overview") {
            if ( $request->month ) {
                $transactions = EventFund::where("created_at","like",$request->year."-".$request->month.'%');
            } else {
                $transactions = EventFund::where('updated_at','like',$request->year.'%');
            }

            if ($request->sadhak) {
                $transactions->where('user_detail_id',$user_detail->id);
            }
            $funds = $transactions->with(["user_detail"])->paginate(30);

        }

        if ($request->record_type == "overview") {
            if ($request->sadhak) {
                $transactions = EventFund::with(["user_detail"])->where('user_detail_id',$user_detail->id)->paginate(50);
            } else {
                $transactions = EventFund::with(["user_detail"])->where('sibir_record_id',$course->sibir_record_id)->paginate(50);
            }
            $funds = $transactions;
        }
        return view('admin.finance.courses.report_filter',compact('funds'));
        return response(
                [
                    'success'=>true,
                    'message'=>'data loaded', 
                    'data'=>view("admin.finance.courses.report_filter",compact('funds'))
                ]);
    }

    public function edit() {

    }

    public function update() {

    }

    public function unverified_payments() {
        $funds = EventFundDetail::with(["user_detail","sibir"])->where('status','pending')->latest()->get();
        return view("admin.finance.courses.payment_verification",compact("funds"));
    }

    public function add_payment() {
        //available courses.
        $courses = Courses::latest()->get();
        return view("admin.finance.courses.add_payment",compact("courses"));
    }

    public function store_payment(Request $request) {
        if ( ! auth()->check() ) {
            abort(403);
        }
        $request->validate([
            "transaction_medium" => 'required',
            "depository_party" => "required|string",
            "reference_number" => "required",
            // "file" => "required|mimes:png,jpg,jpeg,gif|mimetypes:image/*",
            "amount" => "required|numeric"
        ]);
        $login_id = filter_var($request->login_id,FILTER_VALIDATE_EMAIL);

        $user_detail_id = null;
        $user_login_id = null;
        if ($login_id) {
            $user_login = userLogin::where('email',$request->login_id)->first();
            if ( ! $user_login ) {
                $request->session()->flash("message","User not found.");
                return back()->withInput();
            }
            $user_login_id = $user_login->id;
            $user_detail_id = $user_login->userdetail->id;
        } else {
            $user_detail = userDetail::where('phone_number',$request->login_id)->first();
            if ( ! $user_login ) {
                $request->session()->flash("message","User not found.");
                return back()->withInput();
            }
            $user_detail_id = $user_detail->id;
            $user_login_id = $user_detail->userlogin->id;

        }

        $course = Courses::findOrFail($request->sibir_record);
        $event_detail = SibirRecord::findOrFail($course->sibir_record_id);

        $event_fund = EventFund::where('sibir_record_id',$event_detail->id)
                                    ->where('user_login_id',$user_login_id)
                                    ->first();
        // dd($event_fund);
        if ( ! $event_fund ) {
            $event_fund = new EventFund;
            $event_fund->sibir_record_id = $event_detail->id;
            $event_fund->user_login_id = auth()->id();
            $event_fund->user_detail_id = auth()->user()->user_detail_id;
            $event_fund->fund_amount = $request->amount;
        } else {
            $event_fund->fund_amount = $request->amount + $event_fund->fund_amount;
        }

        // now lets add fund transaction;
        $transaction = new EventFundDetail;
        $transaction->sibir_record_id = $event_detail->id;
        $transaction->user_detail_id = auth()->user()->user_detail_id;
        $transaction->user_login_id = auth()->id();
        $transaction->amount = $request->amount;
        $transaction->source = $request->depository_party;
        $transaction->reference_number = $request->reference_number;
        $transaction->owner_remarks = $request->remarks;
        $transaction->status = "Verified";

        if ($request->hasFile('file') ) {
            $transaction->file = $this->upload($request,'file')->id;
        }

        try {
            //code...
            \DB::transaction(function() use ($transaction, $event_fund) {
                $event_fund->save();
                $transaction->event_fund_id = $event_fund->id;
                $transaction->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Error: ".$th->getMessage());
            return back()->withInput();
        } catch(\Error $er) {
            $request->session()->flash('message',"Failed execute command. Error: " . $er->getMessage());
            return back()->withInput();
        }
        // send notification to user that his / her payment is approved.

        $notification = new UserNotification;
        $notification->notification_to = $user_detail_id;
        $notification->notification_from = 0;
        $notification->notification_type = "Payment Notification";
        $notification->message = "Your payment has been verified.";
        $notification->addressable = "\App\Models\userDetail";
        $notification->seen = false;
        $notification->save();
        // dd("completed")
        $request->session()->flash('success',"Transaction saved.");
        return back();
    }


 }
