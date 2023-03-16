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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        $response = ['program' => $program, 'exam' => $exam];
        if (!$request->get('question')) {
            // check if member have attempted any previous.
            $question = ProgramExamQuestion::where('program_exam_id', '=', $exam->getKey())
                ->where('program_id', $program->getKey())
                ->first();
        } else {
            $question = ProgramExamQuestion::where('program_exam_id', '=', $exam->getKey())
                ->where('program_id', $program->getKey())
                ->where('id', $request->get('question'))
                ->first();
        }
        $memberAnswer = MemberQuestionAnswerDetail::where('member_id', auth()->id())
            ->where('program_exam_id', $exam->getKey())
            ->where('program_id', $program->getKey())
            ->where('program_exam_question_id', $question->getKey())
            ->latest()
            ->first();
        if ($memberAnswer) {
            $response['answer'] = $memberAnswer;
        }

        $response['question'] = $question;

        $questions = view('frontend.user.exams.lister.question', $response)->render();
        return $this->json(true, '', 'displayQuestion', ['html' => $questions]);
    }

    public function saveAnswer(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam, ProgramExamQuestion $question)
    {
        $request->validate(['answer' => 'required']);
        $existingAnswer = MemberQuestionAnswerDetail::where('program_id', $program->getKey())
            ->where('program_exam_id', $exam->getKey())
            ->where('program_exam_question_id', $question->getKey())
            ->first();


        $method = '_' . $question->question_type;

        $answer = $this->$method($request, $program, $exam, $question, $existingAnswer);

        if (!$answer) {

            return $this->json(false, 'Unable to save your answer.');
        }

        $message = 'Answer Submitted.';

        if ($request->get('type') == 'draft') {
            $message = "Answer Saved as Draft.";
        }

        $questions = view('frontend.user.exams.lister.question', compact('question', 'program', 'exam', 'answer'))->render();
        return $this->json(true, $message, 'responseAnswer', ['html' => $questions, 'question_index' => $question->getKey()]);
    }

    private function _boolean(Request $request,  Program $program, ProgramExam $exam, ProgramExamQuestion $question, $previousAnswer = null): MemberQuestionAnswerDetail|null
    {

        if ($previousAnswer) {
            return null;
        }

        $newUserAnswer = new MemberQuestionAnswerDetail();
        $newUserAnswer->program_id = $program->getKey();
        $newUserAnswer->member_id = auth()->id();
        $newUserAnswer->program_exam_id = $exam->getKey();
        $newUserAnswer->program_exam_question_id = $question->getKey();
        $newUserAnswer->exam_detail = $exam->toArray();
        $newUserAnswer->question_detail = $question->toArray();
        $newUserAnswer->status = 'completed';
        $correct_answer = $question->question_detail->answer;

        $newUserAnswer->result = [
            'answer' => $request->post('answer'),
            'marks_obtained' => $request->post('answer') == $correct_answer ? $question->marks : 0,
            'checked' => true,
            'remarks' => 'Correct Answer',
            'status' => 'completed',
        ];
        $answerOverView = $this->_answerOverView($program, $exam, $question);
        try {
            DB::transaction(function () use ($newUserAnswer, $answerOverView) {
                $newUserAnswer->save();
                $total_right_answer = $newUserAnswer->result->marks_obtained ? 1 : 0;
                $total_wrong_answer =  $newUserAnswer->result->marks_obtained ? 0 : 1;
                if (is_array($answerOverView)) {
                    $answerOverView['total_wrong_answer'] = $total_right_answer;
                    $answerOverView['total_right_answer'] = $total_wrong_answer;
                    $answerOverView['attempted_questions'][] = $newUserAnswer->question_detail;
                    $answerOverView['total_marks_obtained'] = $newUserAnswer->result->marks_obtained;
                    $answerOverView['status'] = true;
                    $overView = new MemberAnswerOverview;
                    $overView->fill($answerOverView);
                    $overView->save();
                } else {
                    $overView = $answerOverView;
                    $overView->total_right_answer = $total_right_answer + $overView->total_right_answer;
                    $overView->total_wrong_answer = $total_wrong_answer + $overView->total_wrong_answer;
                    $overView->total_marks_obtained = $newUserAnswer->result->marks_obtained + $overView->total_marks_obtained;
                }

                $newUserAnswer->member_answer_overview_id = $overView->getKey();
                $newUserAnswer->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }

        // also add to collection.
        return $newUserAnswer;
    }

    private function _objective(Request $request, Program $program, ProgramExam $exam, ProgramExamQuestion $question, $previousAnswer = null): MemberQuestionAnswerDetail|null
    {

        if ($previousAnswer) {
            return null;
        }

        $newUserAnswer = new MemberQuestionAnswerDetail();
        $newUserAnswer->program_id = $program->getKey();
        $newUserAnswer->member_id = auth()->id();
        $newUserAnswer->program_exam_id = $exam->getKey();
        $newUserAnswer->program_exam_question_id = $question->getKey();
        $newUserAnswer->exam_detail = $exam->toArray();
        $newUserAnswer->question_detail = $question->toArray();
        $newUserAnswer->status = 'completed';
        $remarks = "Incorrect Answer";
        $marksObtained = 0;
        // check if user was correct.
        $totalCorrect = $request->post('answer');
        $actualCorrect = [];
        foreach ($question->question_detail->answers as $index => $question_answer) {
            if ($question_answer->answer) {
                $actualCorrect[] = $index;
            }
        }

        if (count($totalCorrect) == count($actualCorrect)) {
            $correct = true;
            foreach ($actualCorrect as $correctValues) {
                if (!in_array($correctValues, $totalCorrect)) {
                    $correct = false;
                }
            }

            if ($correct) {
                $remarks = 'Correct Answer';
                $marksObtained = $question->marks;
            }
        }

        $newUserAnswer->result = [
            'answer' => $request->post('answer'),
            'marks_obtained' => $marksObtained,
            'checked' => true,
            'remarks' => $remarks,
            'status' => 'completed',
            'correct_answers' => $actualCorrect
        ];

        $answerOverView = $this->_answerOverView($program, $exam, $question);
        try {
            DB::transaction(function () use ($newUserAnswer, $answerOverView, $marksObtained) {
                $newUserAnswer->save();
                $total_right_answer = ($marksObtained) ? 1 : 0;
                $total_wrong_answer = (!$marksObtained) ? 1 : 0;
                if (is_array($answerOverView)) {
                    $answerOverView['total_wrong_answer'] = $total_wrong_answer;
                    $answerOverView['total_right_answer'] = $total_right_answer;
                    $answerOverView['attempted_questions'][] = $newUserAnswer->question_detail;
                    $answerOverView['total_marks_obtained'] = $marksObtained;
                    $answerOverView['status'] = true;
                    $overView = new MemberAnswerOverview;
                    $overView->fill($answerOverView);
                    $overView->save();
                } else {
                    $overView = $answerOverView;
                    $overView->total_right_answer = $total_right_answer + $overView->total_right_answer;
                    $overView->total_wrong_answer = $total_wrong_answer + $overView->total_wrong_answer;
                    $overView->total_marks_obtained = $marksObtained + $overView->total_marks_obtained;
                }
                $newUserAnswer->member_answer_overview_id = $overView->getKey();

                $newUserAnswer->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }

        return $newUserAnswer;
    }

    private function _subjective(Request $request, Program $program, ProgramExam $exam, ProgramExamQuestion $question, $previousAnswer = null): MemberQuestionAnswerDetail|null
    {

        if ($previousAnswer) {
            $previousAnswer->answer = $request->post('answer');

            $previousAnswer->result = [
                'answer' => $request->post('answer'),
                'marks_obtained' => 0,
                'checked' => false,
                'remarks' => null,
                'status' => ($request->get('type') == 'draft') ? 'completed' : 'Pending',
                'correct_answers' => ''
            ];
            $previousAnswer->status = ($request->get('type') == 'draft') ? 'draft' : 'completed';

            try {
                $previousAnswer->save();
            } catch (\Throwable $th) {
                //throw $th;
                return null;
            }

            return $previousAnswer;
        }

        $newUserAnswer = new MemberQuestionAnswerDetail();
        $newUserAnswer->program_id = $program->getKey();
        $newUserAnswer->member_id = auth()->id();
        $newUserAnswer->program_exam_id = $exam->getKey();
        $newUserAnswer->program_exam_question_id = $question->getKey();
        $newUserAnswer->exam_detail = $exam->toArray();
        $newUserAnswer->question_detail = $question->toArray();
        $newUserAnswer->status = ($request->get('type') == 'draft') ? 'draft' : 'completed';
        $newUserAnswer->result = [
            'answer' => $request->post('answer'),
            'marks_obtained' => 0,
            'checked' => false,
            'remarks' => '',
            'status' => 'completed',
            'correct_answers' => null
        ];
        $answerOverView = null;
        if ($request->get('type') != 'draft') {
            $answerOverView = $this->_answerOverView($program, $exam, $question);
        }
        try {
            DB::transaction(function () use ($newUserAnswer, $answerOverView) {
                $newUserAnswer->save();
                if (is_array($answerOverView)) {
                    $answerOverView['total_wrong_answer'] = 0;
                    $answerOverView['total_right_answer'] = 0;
                    $answerOverView['attempted_questions'][] = $newUserAnswer->question_detail;
                    $answerOverView['total_marks_obtained'] = 0;
                    $answerOverView['status'] = true;
                    $overView = new MemberAnswerOverview;
                    $overView->fill($answerOverView);
                    $overView->save();
                } else {
                    $overView = $answerOverView;
                }
                if ($overView) {
                    $newUserAnswer->member_answer_overview_id = $overView->getKey();
                }

                $newUserAnswer->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return null;
        }

        return $newUserAnswer;
    }

    private function _answerOverView(Program $program, ProgramExam $exam, ProgramExamQuestion $question, $addQuestion = null)
    {
        $check_previousRecord = MemberAnswerOverview::where('program_id', $program->getKey())
            ->where('member_id', auth()->id())
            ->where('question_collection_id', $exam->getKey())
            ->first();

        if (!$check_previousRecord) {

            $check_previousRecord =
                [
                    "program_id" => $program->getKey(),
                    "member_id" => auth()->id(),
                    "question_collection_id" => $exam->getKey(),
                ];
        }

        return $check_previousRecord;
    }
}
