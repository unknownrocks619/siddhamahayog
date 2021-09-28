<div class='modal-body'>
    @foreach ($record->subjective_answer as $answers)
        <form method="post" action="{{ route('questions.admin_subjective_marks_submit') }}">
            @csrf
            <div class='row'>
                <div class='col-md-0 pr-0'>
                    <h5><strong>Q.</strong></h5>
                </div>
                <div class='col-md-11 pl-0'>
                    <h5>
                        @if($answers->question->question_title)
                            {!! $answers->question->question_title !!}
                        @endif

                        @if($answers->question->question_type == "audio")
                            <audio controls>
                                <source src="{{ audio_asset($answers->question->alternate_question_title) }}" type="audio/ogg" />
                                <source src="{{ audio_asset($answers->question->alternate_question_title) }}" type="audio/mpeg" />
                            </audio>
                        @endif
                        @if($answers->question->question_type == "image")
                            <img src='{{ question_image($answers->question->alternate_question_title) }}' class='img-thumbnail' style="max-width:75px; max-height: 75px" />
                        @endif
                    </h5>
                </div>
            </div>
            <div class="row bg-light" style="background:#f2f3f6 !important">
                <div class='1'></div>
                <div class='col-md-12'>
                    @if($answers->question_type == "subjective" && $answers->question->question_type == "text")
                        {!! $answers->subjective_answer !!}
                        @if($answers->subjective_answer_upload)
                            @php
                                $user_upload_answer = json_decode($answers->subjective_answer_upload);
                            @endphp
                            @if (\Str::contains($user_upload_answer->type,"image") )
                                <img src="{{ question_image($user_upload_answer->file) }}" class='img-thumbnail' style="max-width:75px; max-height:75px;" />
                            @elseif (\Str::contains($user_upload_answer->type,"audio")) {
                                <audio controls>
                                    <source src="{{ audio_asset($user_upload_answer->file) }}" type="audio/ogg" />
                                    <source src="{{ audio_asset($user_upload_answer->file) }}" type="audio/mpeg" />
                                </audio>
                            @endif
                        @endif
                    @endif

                    
                </div>
            </div>

            <div class='row mt-2'>
                <div class='col-md-4 pl-0'>
                    <input type="hidden" name="answer_for" value="{{$answers->id}}" /> 
                    <input type="marks" name='marks' placeholder="Marks Obtained" value="{{ $answers->obtained_marks }}" class='form-control' />
                </div>
                <div class='col-md-0 pl-0'>
                / {{ $answers->question->total_point }}
                </div>
                <div class='col-md-2'>
                    <button type="submit" class='btn btn-sm btn-primary'>Submit</button>
                </div>
                <div class='col-md-2'>
                    <div class='loading' style="display:none"></div>
                </div>
            </div>
        </form>
    @endforeach
</div>

<script type="text/javascript">
    $("form").submit(function(event) {
        event.preventDefault()
        var parent = this
        $(document).ajaxStart(function(){
            $(parent).find('.loading').html('loading...').show();
        })
        $(document).ajaxStop(function(){
            $(parent).find('.loading').empty().hide();
        })

        $.ajax({
            type : "POST",
            url : $(this).attr('action'),
            data : $(this).serializeArray(),
            success : function (response) {
                $(this).closest('.row').find('.loading').html("saved.");
            }
        })
    })
</script>