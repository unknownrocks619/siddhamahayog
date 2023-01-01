<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramExam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramExamController extends Controller
{
    //
    public function index(Program $program)
    {
        $exams = ProgramExam::where('program_id', $program->getKey())->get();
        return view('admin.programs.exams.index', compact('program', 'exams'));
    }

    public function store(Request $request, Program $program)
    {
        $request->validate([
            'exam_title' => "required",
            "description" => "required",
            "start_date" => 'required|date'
        ]);

        $slug = Str::slug($request->exam_title, "-");

        // check if exam exist.
        if (ProgramExam::where('slug', $slug)->exists()) {
            return response(['errors' => [], 'message' => 'Exam Already Exists.'], 406);
        }

        $exam = new ProgramExam();
        $exam->program_id = $program->getKey();
        $exam->title = $request->post('exam_title');
        $exam->slug = $slug;
        $exam->description = $request->post('description');
        $exam->start_date = $request->post('date_date');
        $exam->end_date = $request->post('end_date');

        try {
            $exam->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(['errors' => [], 'message' => "Error: " . $th->getMessage()], 406);
        }

        return response(['url' => route('admin.program.exam.question.create', [$program->getKey(), $exam->getKey()])], 302);
    }

    public function createQuestions(Program $program, ProgramExam $exam)
    {
        return view('admin.programs.exams.questions.add', compact('program', 'exam'));
    }
}
