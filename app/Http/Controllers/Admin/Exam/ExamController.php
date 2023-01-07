<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramExam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    //
    public function index(Program $program)
    {
        $exams = ProgramExam::where('program_id', $program->getKey())->latest()->get();
        return view('admin.programs.exams.index', compact('program', 'exams'));
    }

    public function store(Request $request, Program $program)
    {
    }
}
