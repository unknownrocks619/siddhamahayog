<div class="card">
    <div class="card-body">
        @if ($question->question_title)
            <div class=" d-flex justify-content-start">
                <h5 class="card-title">
                    {!! $question->question_title !!}
                </h5>
            </div>
            <div class="text-md  d-flex justify-content-start">
                {!! $question->description !!}
            </div>
        @else
            <div class="card-title text-info">
                {!! $question->description !!}
            </div>
        @endif
    </div>
</div>
