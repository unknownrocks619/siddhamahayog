<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Program\Course\Fee\ProgramCourseFeePaidCheckRequest;
use App\Models\Program;
use App\Models\ProgramStudentFee;
use Illuminate\Http\Request;

class UserProgramFeeController extends Controller
{
    //

    public function index()
    {
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
