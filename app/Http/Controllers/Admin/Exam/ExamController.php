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
        $request->validate(
            [
                'exam_title' => 'required',
                'timer' => 'boolean',
                'start_date' => 'required_if:timer,1',
                'end_date' => 'required_if:timer,1'
            ]
        );

        $examTerm = new ProgramExam();
        $examTerm->title = $request->post('exam_title');
        $examTerm->enable_time = $request->post('timer');
        $examTerm->start_date = $request->post('start_date');
        $examTerm->end_term = $request->post('end_date');
        $examTerm->active = false;
    }

    public function edit(Program $program, ProgramExam $exam)
    {
        return view('admin.programs.exams.index', compact('program', 'exam'));
    }
}
