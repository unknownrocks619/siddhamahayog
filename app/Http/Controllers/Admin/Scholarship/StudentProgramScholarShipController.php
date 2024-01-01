<?php

namespace App\Http\Controllers\Admin\Scholarship;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class StudentProgramScholarShipController extends Controller
{
    //

    public function index(Program $program)
    {
        $students = Scholarship::studentByProgram($program);
        $enrolledStudent = ProgramStudent::where('program_id', $program->getKey())->with(['student'])->get();
        return view('admin.programs.scholarship.index', compact('program', 'students', 'enrolledStudent'));
    }

    public function storeScholarShip(Request $request, Program $program)
    {
        $request->validate([
           'student'    => 'required',
           'scholarship_type'   => 'required',
        ]);

        $exists = Scholarship::where('program_id', $program->getKey())
            ->where('student_id', $request->post('student'))
            ->first();

        if ($exists) {
            return $this->returnResponse(false,'Student Already Exists in scholarship',null,[],200,url()->previous());
        }

        $scholarship = new Scholarship();
        $scholarship->fill([
            'program_id' => $program->getKey(),
            'student_id' => $request->post('student'),
            'scholar_type' => $request->post('scholarship_type'),
            'active' => true,
            'remarks' => $request->post('remarks'),
        ]);

        try {
            $scholarship->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Unable to Save Record.',null,['error' => $th->getMessage()],200,url()->previous());
        }

        return $this->returnResponse(true,'Member added to scholarship table.','reload',[],200,url()->previous());

    }

    public function removeStudent(Program $program, Member $student)
    {

        $scholarship = Scholarship::where('program_id', $program->getKey())
            ->where('student_id', $student->getKey())
            ->first();

        if ($scholarship) {
            if ($scholarship->delete()) {
                return $this->returnResponse(true,'Student Removed From scholarship program.','reload');
            }
        }
        return $this->returnResponse(false,'Unable to remove student from scholarship.');
    }
}
