@php
    $disabled = false;
    $submitted = false;
    if (isset($answer)) {
        $submitted = true;
        $disabled = true;
        $checkBoxClass = 'form-check-success';
        $correct = $answer->result->marks_obtained ? true : false;
        $userAnswer = $answer->result->answer;
    
        $correctAnswer = $answer->result->correct_answers;
    }
    $url = '';
    if (!$submitted) {
        $url = route('user.account.programs.exam.save-answer', [$program->getKey(), $exam->getKey(), $question->getKey()]);
    }
@endphp
<form action="{{ $url }}" @if (!$submitted) class="form-answer" method="post" @endif>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="answer">
                    @if (!$submitted)
                        Select Your Answer From Given Option.
                    @endif
                </label>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            @foreach ($question->question_detail->options as $index => $questionOption)
                                <div
                                    class="col-6 mb-3 @if ($submitted && in_array($index, $correctAnswer)) text-success @elseif($submitted && in_array($index, $userAnswer)) text-danger @endif">
                                    <input @if ($submitted) disabled=true @endif type="checkbox"
                                        name="answer[]" id="" value="{{ $index }}"
                                        @if ($submitted && in_array($index, $userAnswer)) checked @endif>

                                    {{ $questionOption }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if ($submitted)
                    <div class="row mt-3">
                        <div class="col-md-12 fs-4 text-info">
                            Marks Obtained: {{ $answer->result->marks_obtained }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (!$submitted)
        <div class="row  d-flext justify-content-end bg-light mt-3 align-items-center">
            <div class="col-md-6 text-right d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-primary save">
                    Submit Answer
                </button>
            </div>
        </div>
    @endif
</form>
