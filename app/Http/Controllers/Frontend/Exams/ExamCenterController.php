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
        if (!$request->get('question')) {
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

                $availableQuestions = $exam->questions()->where('id', '!=', $userAnswer->program_exam_question_id)->get();
                $question = $availableQuestions[$availableQuestions->count() - 1];
            }
        } else {
            $question = ProgramExamQuestion::where('program_exam_id', '=', $exam->getKey())
                ->where('program_id', $program->getKey())
                ->where('id', $request->get('question'))
                ->first();
        }
        $questions = view('frontend.user.exams.lister.question', compact('question', 'program', 'exam'))->render();
        return $this->json(true, '', 'displayQuestion', ['html' => $questions]);
    }

    public function saveAnswer(ExamAttendValidationRequest $request, Program $program, ProgramExam $exam, ProgramExamQuestion $question)
    {
        $request->validate(['answer' => 'required']);
        $existingAnswer = MemberQuestionAnswerDetail::where('program_id', $program->getKey())
            ->where('program_exam_id', $exam->getKey())
            ->where('program_exam_question_id', $question->getKey())
            ->first();

        if (!$existingAnswer) {
            $method = '_' . $question->question_type;
            $answer = $this->$method($request, $program, $exam, $question);
            if (!$answer) {
                return $this->json(false, 'Unable to save your answer.');
            }

            $questions = view('frontend.user.exams.lister.question', compact('question', 'program', 'exam', 'answer'))->render();
            return $this->json(true, 'Answer Submitted.', 'booleanResponseAnswer', ['html' => $questions, 'question_index' => $question->getKey()]);
        }


        if ($existingAnswer && $existingAnswer->status == 'completed') {
            return $this->json(false, 'Answer already submitted.');
        }

        if ($existingAnswer && $existingAnswer->status == 'draft') {
            $existingAnswer->answer = $request->post('answer');
            if ($question->question_type == 'subjective') {
                $existingAnswer->result = [
                    'answer' => $request->post('answer'),
                    'marks_obtained' => 0,
                    'checked' => false,
                    'remarks' => null,
                    'status' => 'Pending'
                ];
            } elseif ($question->question_type == 'objective') {
            } elseif ($question->question_type == 'boolean') {
                $correct_answer = $question->answer;
                $existingAnswer->result = [
                    'answer' => $request->post('answer'),
                    'marks_obtained' => $request->post('answer') == $correct_answer ? $question->marks : 0,
                    'checked' => true,
                    'remarks' => 'Correct Answer',
                    'status' => 'completed'
                ];
                $existingAnswer->status = 'completed';
                $existingAnswer->save();
                $answer = $existingAnswer;
                $questions = view('frontend.user.exams.lister.question', compact('question', 'program', 'exam', 'answer'))->render();
                return $this->json(true, 'Answer Submitted.', 'booleanResponseAnswer', ['html' => $question]);
            }
        }
    }

    private function _boolean(Request $request,  Program $program, ProgramExam $exam, ProgramExamQuestion $question)
    {
        $newUserAnswer = new MemberQuestionAnswerDetail();
        $newUserAnswer->program_id = $program->getKey();
        $newUserAnswer->member_id = auth()->id();
        $newUserAnswer->program_exam_id = $exam->getKey();
        $newUserAnswer->program_exam_question_id = $question->getKey();
        $newUserAnswer->exam_detail = $exam->toArray();
        $newUserAnswer->question_detail = $question->toArray();
        $newUserAnswer->status = 'completed';
        $correct_answer = $question->answer;
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

                if (is_array($answerOverView)) {
                    $answerOverView['total_wrong_answer'] = $newUserAnswer->result->marks_obtained ? 1 : 0;
                    $answerOverView['total_right_answer'] = $newUserAnswer->result->marks_obtained ? 0 : 1;
                    $answerOverView['attempted_questions'][] = $newUserAnswer->question_detail;
                    $answerOverView['total_marks_obtained'] = $newUserAnswer->result->marks_obtained;
                    $answerOverView['status'] = true;
                    $overView = new MemberAnswerOverview;
                    $overView->fill($answerOverView);
                    $overView->save();
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


    private function _answerOverView(Program $program, ProgramExam $exam, ProgramExamQuestion $question, $addQuestion = null)
    {
        $check_previousRecord = MemberAnswerOverview::where('program_id', $program->getKey())
            ->where('member_id', auth()->id())
            ->where('question_collection_id', $exam->getKey())
            ->first();

        if (!$check_previousRecord) {
            $overviewRecord =
                [
                    "program_id" => $program->getKey(),
                    "member_id" => auth()->id(),
                    "question_collection_id" => $exam->getKey(),
                ];
            return $overviewRecord;
        }

        return $check_previousRecord;
    }
}
