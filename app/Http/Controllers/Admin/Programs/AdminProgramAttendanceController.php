<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramStudentAttendance;
use Illuminate\Http\Request;

class AdminProgramAttendanceController extends Controller
{
    //

    public function index(Request $request, Program $program)
    {
        $program->load(["students" => fn ($query) => $query->with(['student'])]);
        return view('admin.programs.attendance.list', compact("program"));
    }

    public function filterResult(Request $request, Program $program)
    {
        $program->load(["students" => function ($query) {
            $query->with(["attendances", 'section', "student"]);
        }]);
    }
}
