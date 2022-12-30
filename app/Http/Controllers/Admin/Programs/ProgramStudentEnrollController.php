<?php

namespace App\Http\Controllers\Admin\Programs;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramStudentAPIResource;
use App\Models\Batch;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentEnroll;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use ProgramBatch;
use DataTables;


class ProgramStudentEnrollController extends Controller
{
    //

    public function program_student_enrollement(Request $request, Program $program, Member $member)
    {
        $member = Member::find($request->member);
        $enrollment = ProgramStudentEnroll::where('program_id', $program->id)->where('member_id', $member->id)->first();
        $last_payment = ProgramStudentFeeDetail::where('program_id', $program->id)->where('student_id', $request->member)->orderBy("id", "DESC")->first();
        return view('admin.programs.fee.partial.student_detail', compact('program', 'member', 'enrollment', "last_payment"));
    }

    public function enroll_student_in_program(Request $request, Program $program, Member $member)
    {
        $request->validate([
            "enroll_date" => "required|date|date_format:Y-m-d",
            "admission" => "required|in:yes,no",
            // "monthly_fee" => "required",
            "scholarshop" => "required|in:yes,no"
        ]);

        $validate_unique = ProgramStudentEnroll::where('program_id', $program->id)->where('member_id', $member->id)->first();

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
        $enroll_student->scholarship = ($request->scholarship == 'yes') ? true : false;
        $enroll_student->program_course_fee_id = $program->active_fees->id;

        $student_fee_detail = new ProgramStudentFeeDetail;
        $student_fee = new ProgramStudentFee;

        $student_fee_check = $student_fee->where('program_id', $program->id)->where('student_id', $member->id)->first();
        if (!$student_fee_check) {


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
            $student_fee_detail->remarks = "Admitted to program " . $program->program_name;
            $student_fee_detail->source = "Cash";
            $student_fee_detail->source_detail = "Bank Deposit";
        } else {

            // check if student under same category is already enrolled.
            $check_student_fee = $student_fee_detail->where("program_id", $program->id)
                ->where('student_id', $member->id)
                ->where('amount_category', 'admission_fee')
                ->exists();
            if (!$check_student_fee) {
                // 
                $student_fee_detail->program_id = $program->id;
                $student_fee_detail->student_id = $member->id;
                $student_fee_detail->program_student_fees_id = $student_fee_check->id;
                $student_fee_detail->amount = $program->active_fees->admission_fee;
                $student_fee_detail->amount_category = "admission_fee";
                $student_fee_detail->verified = true;
                $student_fee_detail->rejected = false;
                $student_fee_detail->remarks = "Admitted to program " . $program->program_name;
                $student_fee_detail->source = "Cash";
                $student_fee_detail->source_detail = "Bank Deposit";

                $student_fee_check->total_amount = $student_fee_check->total_amount + $student_fee_detail->amount;
            }
        }



        try {
            DB::transaction(function () use ($request, $enroll_student, $student_fee_detail, $student_fee, $student_fee_check) {
                $enroll_student->save();
                $student_payment = null;
                if (!$enroll_student->scholarship) {
                    if (!$student_fee_check) {
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

    public function storeMemberInProgram(Request $request, Member $member)
    {
        $request->validate([
            "program_name" => "required",
            'batch' =>  "required",
            'section' => "required"
        ]);

        if (ProgramStudent::where('program_id', $request->post('program_name'))->where('student_id', $member->id)->exists()) {
            session()->flash('error', "User already in program.");
            return redirect()->route('admin.members.show', $member->id);
        }

        $programStudent = new ProgramStudent;

        $programStudent->program_id = $request->post('program_name');
        $programStudent->program_section_id = $request->post('section');
        $programStudent->batch_id = $request->post('batch');
        $programStudent->student_id = $member->id;
        $programStudent->active = true;

        try {
            $programStudent->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to enroll user. Error: ' . $th->getMessage());
            return redirect()->route('admin.members.show', [$member->id]);
        }
        session()->flash('success', "User Enrollment was success.");
        return redirect()->route('admin.members.show', [$member->id]);
    }


    public function RemoveEnrolledUser(ProgramStudent $programStudent)
    {
        // 
        if (ProgramStudentFee::where('program_id', $programStudent->program_id)->where('student_id', $programStudent->student_id)->exists()) {
            session()->flash('error', "Can not remove from the program. Member have active transaction history.");
            return back();
        }
        try {
            //code...
            $programStudent->delete();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to remove user program. Error: ' . $th->getMessage());
            return back();
        }

        session()->flash('success', 'Member removed from program.');
        return back();
    }

    public function enrollmentDetail(ProgramStudent $programStudent)
    {
        return view('admin.programs.modal.add_role_number', compact('programStudent'));
    }

    public function storeEnrollmentDetail(Request $request, ProgramStudent $programStudent)
    {
        $request->validate([
            'roll_number' => "required"
        ]);
        $exists = ProgramStudent::where('roll_number', $request->roll_number)->first();

        if ($exists && $exists->getKey() != $programStudent->getKey()) {
            return response([
                'errors' => ['roll_number' => ["Roll Number already exists."]],
                'message' => 'Roll Number already exists.'
            ], 422);
        }
        $programStudent->roll_number = $request->roll_number;
        $programStudent->save();

        return response([
            'errors' => [],
            'message' => "Roll Number Saved."
        ]);
    }

    public function studentList(Program $program)
    {
        $programStudent = ProgramStudent::where('program_id', $program->getKey())->get();
        $members = Member::wherIn('id', array_keys($programStudent->groupBy('student_id')->toArray()))->get();
        $datatable = DataTables::of($members->student)
            ->addIndexColumn()
            ->addColumn('full_name', function ($row) {
                $full_name = htmlspecialchars($row->first_name);

                if ($row->middle_name) {
                    $full_name .= " ";
                    $full_name .= $row->middle_name;
                }
                $full_name .= " ";
                $full_name .= $row->last_name;
                return $full_name;
            })
            ->addColumn('login_source', function ($row) {
                return strtolower(strip_tags($row->email));
            })
            ->addColumn('country', function ($row) {
                // return $row->countries->country_name;
                return ($row->countries) ? htmlspecialchars(strip_tags($row->countries->name)) : "NaN";
            })
            ->addColumn('phone', function ($row) {
                $phone = "";
                if ($row->phone_number) {
                    $phone .= "Mo: " . htmlspecialchars(strip_tags($row->phone_number));
                } else {
                    $phone .= "NaN";
                }
                if ($row->emergency) {
                    $phone .= "<br />";
                    $phone .= "Emergency Contact: " . htmlspecialchars(strip_tags($row->emergency->phone_number));
                    $phone .= "<br />";
                    $phone .= "Emergency Person: " . htmlspecialchars(strip_tags($row->emergency->contact_person));
                }
                return $phone;
            })
            ->addColumn('program_involved', function ($row) {

                if (!$row->member_detail->count()) {
                    return "NaN";
                }
                $program_involved = "";
                foreach ($row->member_detail as $programs) {
                    $program_involved .= "<span class='bg-danger text-white px-2 mx-1'>" . $programs->program->program_name . "</span>";
                }
                return $program_involved;
            })
            ->addColumn('registered_date', function ($row) {
                return $row->created_at;
            })
            ->addColumn('action', function ($row) {
                $action = "<a href='" . route('admin.members.show', $row->id) . "'>View Detail</a>";
                return $action;
            })
            ->rawColumns(["country", "phone", "program_involved", "action"])
            ->make(true);
        return $datatable;
    }
}
