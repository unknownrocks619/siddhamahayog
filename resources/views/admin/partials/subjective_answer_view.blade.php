<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class='modal-body'>
    @foreach ($record->subjective_answer as $answers)
        <form method="post" action="{{ route('questions.admin_subjective_marks_submit') }}">
            @csrf
            <div class='row  mt-3 pt-3'>
                <div class='col-md-11 pl-0'>
                    <h3>
                        @if($answers->question->question_title)
                            <strong class='text-info'>Q.{{ $loop->index +1 }}</strong>
                            @php
                                echo strip_tags(htmlspecialchars_decode($answers->question->question_title));
                            @endphp
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
                        
                      
                    </h3>
                </div>
            </div>
            <div class="row bg-light" style="background:#f2f3f6 !important">
                <!-- <div class='1'></div> -->
                <div class='col-md-12'>
                    @if($answers->question_type == "subjective" && $answers->question->question_type == "text")
                        <textarea name="user_answer" class='form-control'>{{ $answers->subjective_answer }}</textarea>
                        <!-- <button type="submit" name='submitbtn'>Save Changes.</button> -->
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
                            @php
                                // $upload_file_type = json_decode($answers->subjective_answer_upload);

                                if ($user_upload_answer->type == "application/pdf") {
                                    echo "<a target='_blank' href='".question_image($user_upload_answer->file)."'>Click to Download PDF</a>";
                                }
                        @endphp
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
                    <div class='loading' name="marks_submit" style="display:none"></div>
                </div>
            </div>
        </form>
    @endforeach
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

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
        tinyMCE.triggerSave(); //this line of code will use to update textarea content

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
<script>
    tinymce.init({
    selector: 'textarea',
    plugins: 'lists image print preview hr save',
    toolbar_mode: 'floating',
    menubar: true,
    toolbar : " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | strikethrough | forecolor",
    font_formats:
    "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats; Preeti=preeti",

});
</script>
</body>
</html>
