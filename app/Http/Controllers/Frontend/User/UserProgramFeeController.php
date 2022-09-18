<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Program\Course\Fee\ProgramCourseFeePaidCheckRequest;
use App\Http\Requests\Frontend\Program\Course\Fee\ProgramListTransactionsRequest as FeeProgramListTransactionsRequest;
use App\Http\Requests\Frontend\Program\CourseFee\ProgramListTransactionsRequest;
use App\Models\Program;
use App\Models\ProgramStudentFee;
use Illuminate\Http\Request;

class UserProgramFeeController extends Controller
{
    //

    public function index(FeeProgramListTransactionsRequest $request, Program $program)
    {
        $paymentHistories = ProgramStudentFee::where("student_id", user()->id)->where('program_id', $program->id)->with(["transactions" => function ($query) {
            return $query->latest();
        }])->first();
        // $transactions = ProgramStudentFeeDetail::where('student_id', user()->id)->with(["program", "student_fee"])->latest()->get();
        return view("frontend.user.program.payments.index", compact("paymentHistories", "program"));
    }

    public function ajaxQuery(ProgramCourseFeePaidCheckRequest $request, Program $program = null)
    {
        if ($program) {
            $fees = ProgramStudentFee::where("program_id", $program->id)->where("student_id", user()->id)->first();
        } else {
            $fees = ProgramStudentFee::where('student_id', user()->id)->first();
        }
    }
}
