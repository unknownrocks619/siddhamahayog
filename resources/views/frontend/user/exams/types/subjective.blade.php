@php
    $disabled = false;
    $submitted = false;
    if (isset($answer)) {
        $submitted = true;
        $disabled = $answer->status == 'draft' ? false : true;
        $correct = $answer->result->marks_obtained ? true : false;
        $userAnswer = $answer->result->answer;
    
        $correctAnswer = $answer->result->correct_answers;
    }
    $url = '';
    if (!$submitted) {
        $url = route('user.account.programs.exam.save-answer', [$program->getKey(), $exam->getKey(), $question->getKey()]);
    }
@endphp
<form
    action="{{ route('user.account.programs.exam.save-answer', [$program->getKey(), $exam->getKey(), $question->getKey()]) }}"
    class="form-answer" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="answer">
                    Please type your answer below.
                </label>
                <textarea @if ($disabled) data-disabled="{{ $disabled }}" disabled @endif name="answer"
                    id="answer" class="form-control save-state answer" data-name='answer' cols="30" rows="10">
@if ($submitted)
{{ $answer->result->answer }}
@endif
</textarea>
            </div>
        </div>
    </div>
    @if ($submitted == true && $answer->status != 'completed')
        <div class="row bg-light p-2">
            @if ($answer->result->checked)
                <div class="col-md-12">
                    <h4>Mark Obtained: <span
                            class="badage badge-success px-2">{{ $answer->result->marks_obtained }}</span></h4>
                </div>
                @if ($answer->result->remarks)
                    <div class="col-md-12">
                        <h4>
                            Remarks:
                        </h4>
                        {!! $answer->result->remarks !!}
                    </div>
                @endif
            @endif
        </div>
    @endif

    @if (!$disabled)
        <div class="row  d-flext justify-content-end bg-light mt-3 align-items-center">
            <div class="col-md-6 text-right d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-link text-danger me-3 draft">
                    Save as Draft
                </button>
                <button type="submit" class="btn btn-primary save">
                    Submit Answer
                </button>
            </div>
        </div>
    @endif
</form>
