<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Payment\PaymentCreateRequest;
use App\Models\Program;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function create(PaymentCreateRequest $request, Program $program)
    {
        if (!$program->active_fees) {
            session()->flash("error", "Unable to complete your request.");
            return back();
        }
        return view('frontend.partials.' . $request->paymentOpt, compact('program'));
    }
}
