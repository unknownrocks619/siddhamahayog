@php
    $answer = \App\Models\UserAnswer::where('question_collection_id',$record->id)
    ->where('user_login_id',auth()->id())
    ->first();

@endphp
<div class='modal-body'>
    @if($answer)
        <h4>Marks Obtained :  <span @if($answer->display) class='text-success' @else class='text-danger' @endif> {{ $answer->marks_obtained }} </span> @if($answer->display) <small>verified</small> @else <small>unverified</small> @endif</h4> 
        <h4>Total Questions Attempt :  <small>{{ $answer->total_attempt }}</small></h4> 
        <h4>Total Incorrect Answer :  <small>{{ $answer->total_incorrect }}</small></h4>
        <h4>Total Correct Answer: <small>{{ $answer->total_correct }}</small></h4>
        <p class='text-info'>For Subjective question only after your marks it will be marked as correct answer.</p>
    @endif
</div>


<div class='modal-body'>

    @foreach ($record->questions as $question)
        @php
            $user_answer = \App\Models\UserAnswersSubmit::where('question_id',$question->id)
                                                        ->where('user_login_id',auth()->id())
                                                        ->first();
                $user_answer_decode = json_decode($user_answer->user_answers);
        @endphp
        <div class='card card-body'>
            @if($question->question_title)
                <h4> Q.  {!! $question->question_title !!} </h4>                
            @endif
            @if($question->question_type == "audio" && $question->alternate_question_title)
                <audio controls class='form-control'>
                    <source src="{{audio_asset($question->alternate_question_title)}}" type="audio/ogg" />
                    <source src="{{audio_asset($question->alternate_question_title)}}" type="audio/mpeg" />
                </audio>
            @endif
            @if($question->question_type == "image" && $question->alternate_question_title)
                <img src="{{ question_image($question->alternate_question_title) }}" class='img-thumbnail' style="max-width:80px; max-height:80px;" />
            @endif
            <p class='card-text'>
                @if($user_answer->question_type == "objective")
                    @foreach ($user_answer_decode as $u_a)
                        @if($u_a->type == "text")
                            @if($u_a->correct && $u_a->user_choice)
                               A.  <span class='text-success'> {{ $u_a->text }} [<i class='fas fa-check'></i>] </span>
                            @elseif ($u_a->user_choice)
                                A. <span class='text-danger'> {{ $u_a->text }} [<i class='fas fa-times'></i>]</span>
                            @endif
                        @endif
                        
                        @if($u_a->type == "audio")
                            @if($u_a->correct && $u_a->user_choice)
                                <audio controls class='bg-success'>
                                    <source src="{{ audio_asset($u_a->media) }}" type="audio/mpeg" />
                                    <source src="{{ audio_asset($u_a->media) }}" type="audio/ogg" />
                                </audio>
                                [<span class="fas fa-check"></span>]
                            @elseif ($u_a->user_choice)
                                <audio controls class='bg-danger'>
                                    <source src="{{ audio_asset($u_a->media) }}" type="audio/mpeg" />
                                    <source src="{{ audio_asset($u_a->media) }}" type="audio/ogg" />
                                </audio>
                                <span class='text-danger'>[x]</span>
                            @endif
                        @endif

                        @if ($u_a->type == "image")
                        @if($u_a->correct && $u_a->user_choice)
                                <img src='{{ question_image($u_a->media) }}' class="img-thumbnail bg-success" style="max-width:75px; max-height:75px;" />
                                [<span class="fas fa-check"></span>]
                            @elseif ($u_a->user_choice)
                                <img src='{{ question_image($u_a->media) }}' class="img-thumbnail bg-success" style="max-width:75px; max-height:75px;" />
                                <span class='text-danger'>[x]</span>
                            @endif
                        @endif
                    @endforeach
                    
                @elseif($user_answer->question_type == "subjective")
                    A. {!! $user_answer->subjective_answer !!}
                    <br />
                    @if($user_answer->subjective_answer_upload)
                        @php
                            $upload_file = json_decode($user_answer->subjective_answer_upload);
                            if (\Str::contains($upload_file->type,"image")) {
                                echo "user image";
                                echo "<img style='max-width:75px; max-height:75px;' src='".question_image($upload_file->file)."' class='img-thumbnail' />";
                            } elseif (\Str::contains($upload_file->type,"audio")) {
                                echo "User Audio";
                                echo "<audio controls >";
                                    echo "<source src='".audio_asset($upload_file->file)."' type='audio/ogg' />";
                                    echo "<source src='".audio_asset($upload_file->file)."' type='audio/mpeg' />";
                                echo "</audio>";
                            }
                        @endphp
                    @endif
                    <strong>Point: {{ $user_answer->obtained_marks }}</strong>
                @endif
            </p>
        </div> 
    @endforeach

</div>