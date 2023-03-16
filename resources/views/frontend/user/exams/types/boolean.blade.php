<?php
$disabled = false;
$checkBoxClass = 'form-check';
$userAnswer = null;
$correctAnswer = $question->question_detail->answer;
if (isset($answer)) {
    $disabled = true;
    $checkBoxClass = 'form-check-success';
    $userAnswer = $answer->result->answer;
    $isUserCorrect = $question->question_detail->answer == $answer->result->answer ? true : false;
}
?>
@if ($disabled == false)
    <form
        action="{{ route('user.account.programs.exam.save-answer', [$program->getKey(), $exam->getKey(), $question->getKey()]) }}"
        method="post" class="form-answer">
@endif
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="answer">
                Please Select Your Answer.
            </label>
            <div class="col-md">
                <div class="{{ $checkBoxClass }} form-check-inline mt-3">
                    <input class="form-check-input" type="radio" name="answer" id="answer_correct"
                        @if ($disabled == true && $userAnswer === $correctAnswer) disabled='true' checked='true' @endif value="1">
                    <label
                        class="form-check-label @if ($disabled == true && $correctAnswer == 1) text-success @elseif($disabled == true && $correctAnswer == 0 && $userAnswer == 1) text-danger @endif"
                        for="answer_correct">
                        True (ठिक)
                    </label>
                </div>
                <div
                    class="@if ($disabled == true && $correctAnswer == 0) form-check-success @elseif($disabled == true && $correctAnswer == 1) form-check-danger @else form-check @endif form-check-inline">
                    <input @if ($disabled == true) disabled='true' @endif
                        @if ($disabled == true && $userAnswer == 0) checked @endif class="form-check-input" type="radio"
                        name="answer" id="answer_wrong" value="0">
                    <label
                        class="form-check-label @if ($disabled == true && $correctAnswer == 0) text-success @elseif($disabled == true && $correctAnswer == 1 && $userAnswer == 0) text-danger @endif"
                        for="answer_wrong">False (बेठिक)</label>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($disabled == true)
    <div class="row mt-4">
        <div class="col-md-12 d-flex align-items-center" style="background: rgba(67, 89, 113, 0.04)">
            @if ($isUserCorrect)
                <h3 class="text-success mt-3">
                    Correct Answer
                </h3>
            @else
                <h3 class="text-danger mt-3">
                    Wrong Answer
                </h3>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>
                Mark Obtained: {{ $answer->result->marks_obtained }}
            </h4>
        </div>
    </div>
@endif
@if ($disabled == false)
    <div class="row d-flext justify-content-end bg-light mt-3 align-items-center">
        <div class="col-md-6 text-right d-flex align-items-center justify-content-end">
            <button type="submit" class="btn btn-primary save">
                Submit Answer
            </button>
        </div>
    </div>
    </form>
@endif
