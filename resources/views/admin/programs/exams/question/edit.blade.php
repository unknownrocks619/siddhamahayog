@php
    if (isset($question) ) {
        $url = route('admin.exam.question.update' ,[$program->getKey(), $question->getKey()]);
        $class ='js-update-question';
    } else {
        $url = route('admin.exam.store.question' ,[$program->getKey(),$exam->getKey()]);
        $class ='js-queue-questions';
    }

@endphp
    <form action="{{ $url }}" class="ajax-form" method="post">
        <div class="card">
            <div class="header">
                <h2>
                    @if(isset($question))
                    <strong>
                        Update Question
                    </strong>
                    @else
                    <strong>
                        Add
                    </strong>
                    @endif
                    Questions
                </h2>
            </div>
            <div class="body card-question-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="question">
                                Question Title
                                <sup class="text-danger">
                                    *
                                </sup>
                            </label>
                            <input type="text" name="question" id="question" class="form-control" value="{!! $question->question_title ?? '' !!}">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="question_type">
                                Question Type
                            </label>
                            <select name="question_type" id="question_type" class="form-control">
                                <option value="subjective" @if(isset($question) && $question->question_type =='subjective') selected @endif>Subjective</option>
                                <option value="objective" @if(isset($question) && $question->question_type =='objective') selected @endif>Objective</option>
                                <option value="boolean" @if(isset($question) && $question->question_type =='boolean') selected @endif>True / False</option>
                                <option value="figurative" @if(isset($question) && $question->question_type =='figurative') selected @endif>Figurative</option>
                                <option value="audio" @if(isset($question) && $question->question_type =='audio') selected @endif>Audio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marks">
                                Total Marks
                            </label>
                            <input type="text" value="{{ $question->marks ?? 0 }}" name="marks" id="marks" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control richtext border">{{ $question->description ?? '' }}</textarea>
                    </div>
                </div>

                @if (isset ($question) )

                    @if ($question->question_type == "objective")

                    <div class='row mt-3 row_by_q_type'>
                        <div class='col-md-12'>
                            <span class='fs-3 h3'>
                                Provide Option and Correct Answer
                            </span>
                        </div>
                        @foreach ($question->question_detail->answers as $key => $value)
                            <div class='col-md-12'>
                                <div class="row">
                                    <div class='col-md-5 mt-2'>
                                        <label>Options</label>
                                        <input type='text' name='subjective_answer[]' value='{{ $value->option }}' class='form-control' />
                                    </div>
                                    <div class='col-md-5 mt-2'>
                                        <label>Correct Answer</label>
                                        <select class='form-control' name='solution[]'>
                                            <option value='1' @if( $value->answer) selected @endif>Yes</option>
                                            <option value='0' @if ( ! $value->answer) selected @endif>No</option>
                                        </select>
                                    </div>
                                    <div class='col-md-2 w-100 d-block'>
                                        @if($loop->iteration > 1)
                                        <label class='w-100 d-block'>&nbsp;</label>
                                        <button type='button' class='btn btn-sm btn-danger js-subjective-remove'>
                                            Remove
                                        </button>
                                        @else
                                        <label class='w-100 d-block'>&nbsp;</label>
                                        <button type='button' class='btn btn-sm btn-info js-subjective-plus '>
                                            Add Options
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    @endif

                    @if($question->question_type == 'boolean')
                    <div class='row mt-3 row_by_q_type'>
                        <div class='col-md-12'>
                            <span class='fs-3 h3'>
                                Please Choose Correct Answer
                            </span>
                        </div>

                        <div class='col-md-4 mt-2'>
                            <input type='radio' name='boolean_answer' value='1' @if($question->question_detail->answer) checked @endif /> True
                        </div>
                        <div class='col-md-4 mt-2'>
                            <input type='radio' name='boolean_answer' value='0' @if( ! $question->question_detail->answer) checked @endif /> False
                        </div>

                    </div>
                    @endif

                @endif

            </div>
            <div class="footer">

                @if(isset($question))
                    <a href='{{ route("admin.exam.edit",[$program->getKey(),$question->questionModel->getKey()]) }}'>Reset Form (Cancel Edit)</a>
                @endif

                <button type='submit' data-action="{{ $url }}"  class="btn btn-primary {{$class}}">
                    @if(isset($question) )
                        Update
                    @else
                        Add
                    @endif
                    Question
                </button>

            </div>
        </div>
    </form>
