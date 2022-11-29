<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Payment\PaymentCreateRequest;
use App\Http\Requests\Frontend\Program\CourseFee\StripeAdmissionFeeRequest;
use App\Models\CurrencyExchange;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //

    public function create(PaymentCreateRequest $request, Program $program)
    {
        if (!$program->active_fees) {
            session()->flash("error", "Unable to complete your request.");
            return back();
        }
        $intent = null;
        if ($request->paymentOpt == "stripe") {
            if (user()->role_id  != 1) {
                abort(404);
            }
            $intent = user()->createSetupIntent();
            $allow_access = (getUserCountry() != 'NP') ? true : false;
        } else {
            $allow_access = getUserCountry() == "NP" ?? false;
        }
        return view('frontend.partials.' . $request->paymentOpt, compact('program', 'intent', 'allow_access'));
    }

    public function stripeAdmissionFeeControllerr(StripeAdmissionFeeRequest $request, Program $program)
    {
        try {
            //code...
            user()->createOrGetStripeCustomer();
            user()->updateDefaultPaymentMethod($request->post('payment_method'));
            user()->charge($request->post('amount') * 100, $request->post('payment_method'));
        } catch (\Throwable $th) {
            session()->flash('error', 'Unable to complete your payment. If your amount is deducted from the account please create support ticket with your transaction statement detail Or you can try again.');
            return back()->withInput();
        }

        // exchange Rate.
        $rate = CurrencyExchange::getExchangeRateByDate(date("Y-m-d"));
        $convert_rate = $rate->exchange_data->buy * 100;
        // store in database with very good remaks.
        $transaction_detail = new ProgramStudentFeeDetail();
        $transaction_detail->program_id = $program->id;
        $transaction_detail->student_id = user()->id;
        $transaction_detail->amount = $convert_rate;
        $transaction_detail->amount_category = "admission_fee";
        $transaction_detail->source = "card";
        $transaction_detail->remarks = [
            'rate' => $rate,
            'paid_currency' => "USD",
            'paid_amount' => '100',
        ];
        $transaction_detail->source = "Stripe Transaction";
        $transaction_detail->verified = true;
        $transaction_detail->rejected = false;
        $transaction_detail->message = "Transaction completed by stripe payment";

        // check if overview is available.
        $programStudentFee = ProgramStudentFee::where('student_id', user()->id)->where('program_id', $program->id)->first();

        if (!$programStudentFee) {
            $programStudentFee = new ProgramStudentFee();
            $programStudentFee->program_id = $program->id;
            $programStudentFee->student_id = user()->id;
        }

        $programStudentFee->total_amount = $programStudentFee->total_amount + $convert_rate;

        try {
            DB::transaction(function () use ($programStudentFee, $transaction_detail) {
                $programStudentFee->save();

                $transaction_detail->program_student_fees_id = $programStudentFee->id;
                $transaction_detail->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            session()->flash('error', 'Oops ! Something went wrong while processing your request. If amount is deducated from your card create a support ticket with your bank statement.');
            return back()->withInput();
        }


        $notification =  new MemberNotification();
        $notification->member_id = auth()->id();
        $notification->title = "Payment Success ";
        $notification->notification_type = "App\Models\Program";
        $notification->notification_id = $program->id;
        $notification->body = "Congratulation ! Your admissin fee for " . $program->program_name . " was successfully paid.";
        $notification->type = "message";
        $notification->level = "notice";
        $notification->seen = false;
        $notification->save();

        session()->flash('success', "Congratulation ! Your payment for ' . $program->program_name . ' has been paid.");
        return redirect()->route('user.account.programs.courses.fee.list', $program->id);
    }
}
