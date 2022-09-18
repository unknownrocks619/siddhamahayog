<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;

class UserProgramPaymentController extends Controller
{
    //

    public function index()
    {
        $paymentHistories = ProgramStudentFee::where("student_id", user()->id)->with(["transactions" => function ($query) {
            return $query->latest();
        }, "program"])->get();
        // $transactions = ProgramStudentFeeDetail::where('student_id', user()->id)->with(["program", "student_fee"])->latest()->get();
        return view("frontend.user.program.payments.index", compact("paymentHistories"));
    }
}
