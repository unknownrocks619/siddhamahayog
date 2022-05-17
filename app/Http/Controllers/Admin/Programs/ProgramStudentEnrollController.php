<?php

namespace App\Http\Controllers\Admin\Programs;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudentEnroll;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ProgramStudentEnrollController extends Controller
{
    //

    public function program_student_enrollement(Request $request, Program $program) {
        $member = Member::find($request->member);
        $enrollment = ProgramStudentEnroll::where('program_id',$program->id)->where('member_id', $member->id)->first();
        $last_payment = ProgramStudentFeeDetail::where('program_id',$program->id)->where('student_id',$member->id)->orderBy("id","DESC")->first();
        return view('admin.programs.fee.partial.student_detail',compact('program','member','enrollment',"last_payment"));
    }

    public function enroll_student_in_program(Request $request,Program $program, Member $member) {
        $request->validate([
            "enroll_date" => "required|date|date_format:Y-m-d",
            "admission" => "required|in:yes,no",
            // "monthly_fee" => "required",
            "scholarshop" => "required|in:yes,no"
        ]);

        $validate_unique = ProgramStudentEnroll::where('program_id',$program->id)->where('member_id',$member->id)->first();

        if ($validate_unique) {
            return response([
                "success" => false,
                "message" => "Student already enrolled in program.",
            ]);
        }

        $enroll_student = new ProgramStudentEnroll;
        $enroll_student->program_id = $program->id;
        $enroll_student->member_id = $member->id;
        $enroll_student->enroll_date = $request->enroll_date;
        $enroll_student->scholarship =( $request->scholarship == 'yes' )? true : false;
        $enroll_student->program_course_fee_id = $program->active_fees->id;

        $student_fee_detail = new ProgramStudentFeeDetail;
        $student_fee = new ProgramStudentFee;

        $student_fee_check = $student_fee->where('program_id',$program->id)->where('student_id',$member->id)->first();
        if (! $student_fee_check ) {
            
            
            $student_fee->program_id = $program->id;
            $student_fee->student_id = $member->id;
            $student_fee->total_amount = $program->active_fees->admission_fee;

            // 
            $student_fee_detail->program_id = $program->id;
            $student_fee_detail->student_id = $member->id;
            $student_fee_detail->amount = $program->active_fees->admission_fee;
            $student_fee_detail->amount_category = "admission_fee";
            $student_fee_detail->verified = true;
            $student_fee_detail->rejected = false;
            $student_fee_detail->remarks = "Admitted to program ". $program->program_name;
            $student_fee_detail->source = "Cash";
            $student_fee_detail->source_detail = "Bank Deposit";
        } else {

            // check if student under same category is already enrolled.
            $check_student_fee = $student_fee_detail->where("program_id",$program->id)
                                                    ->where('student_id',$member->id)
                                                    ->where('amount_category','admission_fee')
                                                    ->exists();
            if ( ! $check_student_fee) {
                // 
                $student_fee_detail->program_id = $program->id;
                $student_fee_detail->student_id = $member->id;
                $student_fee_detail->program_student_fees_id = $student_fee_check->id;
                $student_fee_detail->amount = $program->active_fees->admission_fee;
                $student_fee_detail->amount_category = "admission_fee";
                $student_fee_detail->verified = true;
                $student_fee_detail->rejected = false;
                $student_fee_detail->remarks = "Admitted to program ". $program->program_name;
                $student_fee_detail->source = "Cash";
                $student_fee_detail->source_detail = "Bank Deposit";

                $student_fee_check->total_amount = $student_fee_check->total_amount + $student_fee_detail->amount;
            } 
        }
        
        

        try {
            DB::transaction(function() use ($request,$enroll_student,$student_fee_detail,$student_fee,$student_fee_check) {
                $enroll_student->save();
                $student_payment = null;
                if ( ! $enroll_student->scholarship) {
                    if ( ! $student_fee_check ) {
                        $student_fee->save();
                        $student_fee_detail->program_student_fees_id = $student_fee->id;
                        $student_fee_detail->save();
                        $student_payment = $student_fee;
                    } else {
                        $student_fee_detail->save();
                        $student_fee_check->save();
                        $student_payment = $student_fee_check;

                    }    
                }
                if ($request->monthly_fee) {
                    $add_monthly_fee = new ProgramStudentFeeDetail;
                    // 
                    $add_monthly_fee->program_id = $student_fee_detail->program_id;
                    $add_monthly_fee->student_id = $student_fee_detail->student_id;
                    $add_monthly_fee->amount = $request->monthly_fee;
                    $add_monthly_fee->amount_category = "monthly_fee";
                    $add_monthly_fee->verified = true;
                    $add_monthly_fee->rejected = false;
                    $add_monthly_fee->remarks = "Monthly Fee ";
                    $add_monthly_fee->source = "Cash";
                    $add_monthly_fee->source_detail = "Bank Deposit";
                    $add_monthly_fee->program_student_fees_id = $student_payment->id;
                    $student_payment->total_amount = $student_payment->total_amount + $add_monthly_fee->amount;
                    $add_monthly_fee->save();
                    $student_payment->save();
                }
            });
        } catch (\Throwable $th) {
            return response([
                "success" => false,
                "message" => "Unable to Enroll Member",
                "error" => $th->getMessage()
            ]);
            //throw $th;
        }
        // if ( $check_student_fee ) {
        //     // 

        // }
            
        return response([
            "success" => true,
            "message" => "Member Enrolled.",
            "redirect" => true,
            "ajax" => true,
        ]);
    }


}
