<?php

namespace App\Http\Controllers\Admin\Scholarship;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\ScholarShip;
use Illuminate\Http\Request;

class StudentProgramScholarShipController extends Controller
{
    //

    public function index(Program $program)
    {
        $students = ScholarShip::studentByProgram($program);
        $enrolledStudent = ProgramStudent::where('program_id', $program->getKey())->with(['student'])->get();
        return view('admin.programs.scholarship.index', compact('program', 'students', 'enrolledStudent'));
    }

    public function storeScholarShip(Request $request, Program $program)
    {

        $exists = ScholarShip::where('program_id', $program->getKey())
            ->where('student_id', $request->student)
            ->first();

        if ($exists) {
            session()->flash('error', "Student Already Exists in scholarship list.");
            return back();
        }

        $scholarship = new ScholarShip();
        $scholarship->program_id = $program->getKey();
        $scholarship->student_id = $request->get('student');
        $scholarship->scholar_type = $request->get('scholarship_type');
        $scholarship->active = true;
        $scholarship->remarks = $request->get('remarks');


        try {
            $scholarship->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to save Record: ' . $th->getMessage());
            return back()->withInput();
        }

        session()->flash('success', "New member added in scholarship table.");
        return back();
    }

    public function removeStudent(Program $program, Member $student)
    {

        $scholarship = ScholarShip::where('program_id', $program->getKey())
            ->where('student_id', $student->getKey())
            ->first();

        if ($scholarship) {
            if ($scholarship->delete()) {
                session()->flash('success', 'Student Removed from scholarship Program.');
                return back();
            }
        }
        session()->flash('error', "Unable to remove Student from scholarship.");
        return back();
    }

    
}
