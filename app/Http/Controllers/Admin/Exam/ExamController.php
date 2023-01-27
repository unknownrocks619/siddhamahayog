<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramExam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $examTerm->slug = Str::slug($request->exam_title);
        $examTerm->description = $request->post('description');
        $examTerm->enable_time = $request->post('timer');
        $examTerm->start_date = $request->post('start_date');
        $examTerm->end_date = $request->post('end_date');
        $examTerm->program_id = $program->getKey();
        $examTerm->active = false;

        try {
            $examTerm->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to save. Error: ' . $th->getMessage());
            return back();
        }
        return redirect()->route('admin.exam.edit', [$program->getKey(), $examTerm->getKey()]);
    }

    public function edit(Program $program, ProgramExam $exam)
    {
        return view('admin.programs.exams.edit', compact('program', 'exam'));
    }
}
