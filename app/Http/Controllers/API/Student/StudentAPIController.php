<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramStudentAPIResource;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class StudentAPIController extends Controller
{
    //

    public function list_student_by_program(Program $program, $options= []) {
        // only admin is authorized.
        $member_list = ProgramStudent::select(["student_id"])->where('program_id',$program->id)
                                    ->where('active',true)->get()->pluck('student_id');
        $members = Member::select(['id','first_name','middle_name','last_name'])->whereIn('id',$member_list)->get();
        return ["results" => ProgramStudentAPIResource::collection($members)];
            
    }
}
