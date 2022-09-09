<?php

namespace App\Http\Controllers\Frontend\Enroll;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentEnroll;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SadhanEnrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        //
    }

    public function enroll_student(Request $request, Program $program, Member $member)
    {
        $program_student = new ProgramStudent;
        $program_student->program_id = $program->id;
        $program_student->student_id = $member->id;
        $program_student->program_section_id = $program->active_sections->id;
        $program_student->batch_id = $program->active_batch->id;
        $program_student->active = true;



        $program_enroll = new ProgramStudentEnroll;
        $program_enroll->program_id = $program->id;
        $program_enroll->member_id = $member->id;
        $program_enroll->enroll_date = date("Y-m-d");
        $program_enroll->program_course_fee_id = $program->active_fees->id;
        $program_enroll->scholarship = false;

        /**
         * Fee Structure
         */

        $student_fee = new ProgramStudentFee;
        $student_fee->program_id - $program->id;
        $student_fee->student_id = $member->id;
        $student_fee->total_amount = $request->amt;
        /**
         * Fee Structure Detail
         */
        $student_fee_structure = new ProgramStudentFeeDetail;
        $student_fee_structure->program_id = $program->id;
        $student_fee_structure->student_id = $member->id;
        $student_fee_structure->amount = $request->amt;
        $student_fee_structure->amount_category = "Sadhana Subscription: " . $request->sub_type;
        $student_fee_structure->source = $request->source;
        $student_fee_structure->source_detail = $request->party;
        $student_fee_structure->verified = true;
        $student_fee_structure->rejected = false;
        $student_fee_structure->remarks = "Sadhana Package Subscribed";

        try {
            DB::transaction(function () use ($program_student, $program_enroll, $student_fee, $student_fee_structure) {
                $program_student->save();
                $program_enroll->save();
                $student_fee->save();
                $student_fee_structure->program_student_fees_id = $student_fee->id;
                $student_fee_structure->save();
            });
        } catch (\Throwable $th) {
            //throw $th;

        }
    }
}
