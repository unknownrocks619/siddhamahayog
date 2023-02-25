<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Exam\ExamAttendValidationRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\MemberAnswerOverview;
use App\Models\MemberQuestionAnswerDetail;
use App\Models\Program;
use App\Models\ProgramExam;
use App\Models\ProgramExamQuestion;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    //
    use CourseFeeCheck;
    public function index()
    {
    }
    public function overview(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam)
    {
        // validate if user can participate in the exam :)

        $questions = $exam->questions->groupBy('question_type');
        $overview = [];
        foreach ($questions as $type => $question) {
            $overview[$type] = $question->count();
        }
        return view('frontend.user.exam.overview', compact('program', 'exam', 'overview'));
    }

    public function start(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam)
    {
        // validate if user can participate in the exam :)

        if (!session()->has('exam_start')) {
            session()->put('exam_start', time());
        }
        $memberAnswer = MemberAnswerOverview::where('question_collection_id', $exam->getKey())
            ->where('member_id', auth()->id())
            ->first();
        return view('frontend.user.exam.start', compact('program', 'exam','memberAnswer'));
    }

    public function fetchQuestions(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam, ProgramExamQuestion $question = null)
    {

        if (!$question) {

            $question = $exam->questions()->first();
        } else {
            $question = $exam->questions()->where('id', '>', $question->getKey())->first();
        }
        //

        if (!view()->exists('frontend.user.exam.types.' . $question->question_type)) {
            return view('frontend.user.exam.types.unknown');
        }

        return view('frontend.user.exam.types.' . $question->question_type);
    }
}
