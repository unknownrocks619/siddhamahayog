@foreach ($exam->questions as $question)
    <div class="card">
        <div class="header">
            <h2 style="font-weight:bold">
                {{ $question->question_title}}
                -
                [
                    @if($question->question_type == 'objective')
                        Multiple Choice
                    @elseif($question->question_type == 'subjective')
                        Subjective Answer
                    @elseif($question->question_type == 'boolean')
                        True / False
                    @else
                        Other
                    @endif
                ]

            </h2>
        </div>
        <div class="body">
            @if($question->description)
                <div class="border p-3">
                    {!! $question->description !!}
                </div>
            @endif


            @if($question->question_type == 'boolean')
                <h5 class="mt-2">
                    Correct Answer : {{ ($question->question_detail->answer) ? 'True' : 'False' }}
                </h5>
            @endif

            @if($question->question_type == 'objective')
                <div class="row mt-3">
                    @foreach ($question->question_detail->answers as $key => $value)
                    <div class="col-6 mt-2">
                        {{ $value->option }}
                        @if( ! $value->answer)
                            <span class="text-danger">
                                [Wrong Answer]
                            </span>
                        @else
                            <span class="text-success">
                                [Correct Answer]
                            </span>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="footer">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <button type="button" data-action='{{route("admin.exam.question.edit",[$program->getKey(),$question->getKey()])}}' data-question-id="{{ $question->getKey() }}" class="js-question-edit-question btn btn-primary">Edit Question</button>
                    <button type="button" data-action='{{route("admin.exam.remove.question",[$program->getKey(),$question->getKey()])}}' data-question-id="{{ $question->getKey() }}" class="js-delete-question btn btn-danger">Delete Question</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
