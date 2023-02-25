<?php

namespace App\Http\Controllers\Frontend\Exams;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Exam\ExamAttendValidationRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\MemberAnswerOverview;
use App\Models\MemberQuestionAnswerDetail;
use App\Models\Program;
use App\Models\ProgramExam;
use App\Models\ProgramExamQuestion;
use Illuminate\Http\Request;

class ExamCenterController extends Controller
{
    //
    use CourseFeeCheck;
    public function index()
    {
        user()->load(['member_detail']);
        $userPrograms = user()->member_detail->groupBy('program_id')->toArray();
        $exams = ProgramExam::where('program_id', array_keys($userPrograms))
            ->withCount(['questions'])
            ->where('active', true)->orderBy('start_date', 'desc')->get();

        return view("frontend.user.exams.index", compact('exams'));
    }

    public function result()
    {
        return view("frontend.user.exams.result");
    }


    public function overview(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam)
    {
        // validate if user can participate in the exam :)

        $questions = $exam->questions->groupBy('question_type');
        $overview = [];
        foreach ($questions as $type => $question) {
            $overview[$type] = $question->count();
        }
        $memberAnswer = MemberAnswerOverview::where('question_collection_id', $exam->getKey())
            ->where('member_id', auth()->id())
            ->first();
        return view('frontend.user.exams.overview', compact('program', 'exam', 'overview', 'memberAnswer'));
    }

    public function start(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam)
    {
        // validate if user can participate in the exam :)

        if (!session()->has('exam_start')) {
            session()->put('exam_start', time());
        }
        $exam->load(['questions']);

        return view('frontend.user.exams.start', compact('program', 'exam'));
    }

    /**
     *
     *
     */
    public function getQuestion(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam, ProgramExamQuestion $question = null)
    {
        if (!$question) {
            // check if member have attempted any previous.
            $userAnswer = MemberQuestionAnswerDetail::where('member_id', auth()->id())
                ->where('program_exam_id', $exam->getKey())
                ->where('program_id', $program->getKey())
                ->latest()
                ->first();

            if (!$userAnswer) {

                $question = ProgramExamQuestion::where('program_exam_id', $exam->getKey())
                    ->where('program_id', $program->getKey())
                    ->first();
            } else {
                $question = ProgramExamQuestion::where('program_exam_id', '>', $userAnswer->program_exam_question_id)
                    ->where('program_id', $program->getKey())
                    ->first();
            }
        } else {
            $question = ProgramExamQuestion::where('program_exam_id', '>', $question->getKey())
                ->where('program_id', $program->getKey())
                ->first();
        }
        return view('frontend.user.exams.lister.question', compact('question', 'program', 'exam'));
    }
}
