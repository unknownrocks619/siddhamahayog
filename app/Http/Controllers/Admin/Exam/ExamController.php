<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramExam;
use App\Models\ProgramExamQuestion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    //
    public function index(Program $program)
    {
        $exams = ProgramExam::where('program_id', $program->getKey())->with('questions')->latest()->get();
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

    public function storeQuestions(Request $request, Program $program, ProgramExam $exam)
    {
        $examQuestion = new ProgramExamQuestion;
        $examQuestion->program_id = $program->getKey();
        $examQuestion->program_exam_id = $exam->getKey();
        $examQuestion->question_title = $request->question;
        $examQuestion->marks = $request->marks;
        $examQuestion->description = $request->description;
        $examQuestion->question_type = $request->question_type;

        if ($request->question_type == 'objective') {
            $objectiveAnswer = [];
            $options = [];
            foreach ($request->subjective_answer as $key => $value) {
                $objectiveAnswer['answers'][] = ['option' => $value, 'answer' => $request->solution[$key]];
                $options[] = $value;
            }
            $objectiveAnswer['options'] = $options;
            $examQuestion->question_detail = $objectiveAnswer;
        }

        if ($request->question_type == 'boolean') {
            $boolean = [
                'answer' => $request->boolean_answer
            ];

            $examQuestion->question_detail = $boolean;
        }

        try {
            $examQuestion->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(['error' => $th->getMessage(), 'message' => 'Unable to save question', 'status' => false], 403);
        }
        $exam->load('questions');
        return view('admin.programs.exams.question.lister', compact('exam', 'program'));
    }

    public function deleteQuestion(Request $request, Program $program, ProgramExamQuestion $question)
    {
        $question->delete();
    }

    public function editForm()
    {
        return view('admin.programs.exams.question.edit');
    }


    public function editPrimaryQuestion(Program $program, ProgramExam $exam)
    {
        return view('admin.programs.exams.question.edit-primary-question', compact('program', 'exam'));
    }

    public function edit(Program $program, ProgramExam $exam)
    {
        $exam->load('questions');
        return view('admin.programs.exams.edit', compact('program', 'exam'));
    }


    public function editQuestion(Program $program, ProgramExamQuestion $question)
    {
        return view('admin.programs.exams.question.edit', compact('question', 'program'));
    }

    public function updateQuestion(Request $request, Program $program, ProgramExamQuestion $question)
    {
        $question->question_title = $request->question;
        $question->marks = $request->marks;
        $question->description = $request->description;
        $question->question_type = $request->question_type;

        if ($request->question_type == 'objective') {
            $objectiveAnswer = [];
            $options = [];

            foreach ($request->subjective_answer as $key => $value) {
                $objectiveAnswer['answers'][] = ['option' => $value, 'answer' => $request->solution[$key]];
                $options[] = $value;
            }

            $objectiveAnswer['options'] = $options;
            $question->question_detail = $objectiveAnswer;
        }

        if ($request->question_type == 'boolean') {
            $boolean = [
                'answer' => $request->boolean_answer
            ];

            $question->question_detail = $boolean;
        }

        try {
            $question->save();
        } catch (Exception $ex) {
            return response(['status' => false, 'message' => 'Unable to update question.', 'error' => $ex->getMessage()]);
        }

        return view('admin.programs.exams.question.lister', ['exam' => $question->questionModel, 'program' => $program]);
    }

    public function updatePrimaryQuestion(Request $request, Program $program, ProgramExam $exam)
    {
        $request->validate(
            [
                'exam_title' => 'required',
                'timer' => 'boolean',
                'start_date' => 'required_if:timer,1',
                'end_date' => 'required_if:timer,1',
                'active' => 'required|boolean'
            ]
        );

        $exam->title = $request->post('exam_title');
        $exam->slug = Str::slug($request->exam_title);
        $exam->description = $request->post('description');
        $exam->enable_time = $request->post('timer');
        $exam->start_date = $request->post('start_date');
        $exam->end_date = $request->post('end_date');
        $exam->program_id = $program->getKey();
        $exam->active = $request->active;

        try {
            $exam->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to save. Error: ' . $th->getMessage());
            return redirect()->route('admin.exam.list', [$program->getKey()]);
        }

        session()->flash("success", 'Questin Paper Detail Updated.');
        return redirect()->route('admin.exam.list', [$program->getKey()]);
    }

    public function deletePrimaryQuestion(Program $program, ProgramExam $exam)
    {
        try {
            DB::transaction(function () use ($exam) {
                if ($exam->questions) {
                    $exam->questions()->delete();
                }
                $exam->delete();
            });
            session()->flash('success', 'Question Paper deleted.');
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to remove question paper: ' . $th->getMessage());
        }

        return back();
    }
}
