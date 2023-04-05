<?php

namespace App\Jobs;

use App\Models\ExamResult;
use App\Models\Member;
use App\Models\MemberQuestionAnswerDetail;
use App\Models\ProgramExam;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $member;
    protected $exam;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Member $member, ProgramExam $exam)
    {
        $this->member = $member;
        $this->exam = $exam;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        //count result first.
        $questions  = $this->exam->questions;
        $userAttemptQuestion = MemberQuestionAnswerDetail::where('program_exam_id', $this->exam->getKey())
            ->where('member_id', $this->member->getKey())
            ->where('status', 'completed')
            ->get();

        $resultPublished = ExamResult::where('member_id', $this->member->getkey())
            ->where('program_exam_id', $this->exam->getKey())
            ->first();

        if ($resultPublished) {
            return;
        }

        if ($userAttemptQuestion->count() < $questions->count()) {
            return;
        }

        $totalMarks = $questions->sum('marks');
        $obtainedMarks = 0;
        $total_right = 0;
        $total_wrong = 0;

        foreach ($userAttemptQuestion as $answers) {
            $result = $answers->result;

            // do not generate marks sheet.
            if (!$result->checked) {
                return;
            }

            if ($result->remarks == MemberQuestionAnswerDetail::CORRECT_ANSWER) {

                $total_right++;
                $obtainedMarks += $result->marks_obtained;
            } else {

                $total_wrong++;
            }
        }

        $result = new ExamResult();
        $result->fill([
            'member_id' => $this->member->getKey(),
            'program_exam_id'   => $this->exam->getKey(),
            'total_marks'       => $totalMarks,
            'obtained_marks'    => $obtainedMarks,
            'total_right'       => $total_right,
            'total_wrong'       => $total_wrong,
            'full_name'         => $this->member->full_name,
        ]);

        try {
            $result->save();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Error Generating Result : " . $th->getMessage(), [ExamResult::class, $this->exam, $this->member]);
        }
    }
}
