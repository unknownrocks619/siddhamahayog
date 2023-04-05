<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Congratulation !
                </h4>
                <div class="">
                    Your all question answer has been submitted.
                    <?php
                    $subjectiveQuestion = $exam
                        ->questions()
                        ->where('question_type', 'subjective')
                        ->exists();
                    ?>

                    @if ($subjectiveQuestion)
                        Your questions has been submitted. You will be notified when
                        result is published.
                    @else
                        Please Check Result section to view Your Result.
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('user.account.exams.exam.index') }}" class="btn btn-danger">
                    <x-arrow-left>
                        Go Back
                    </x-arrow-left>
                </a>
                <a class="btn btn-primary clickable"
                    href="{{ route('user.account.programs.exam.start', [$exam->program_id, $exam->getKey()]) }}">
                    <x-eye-open>
                        View My Answer
                    </x-eye-open>
                </a>
            </div>
        </div>
    </div>
</div>
