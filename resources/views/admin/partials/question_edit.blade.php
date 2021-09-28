<div class='modal-body'>
    <form method="post" enctype="multipart/form-data" action="{{ route('questions.admin_update_question',$record->id) }}">
        @csrf
        <div class="card">
            <div class='card-body'>
                <div class='card'>
                    <div class='card-body mt-2'>
                        <div class='form-row'>
                            <div class='col-md-4'>
                                <label class='label-control'> Sibir / Class</label>
                                <select disabled name='sibir' placeholder="Choose..." class='form-control'>
                                    <option>Select Class</option>

                                </select>
                            </div>
                            <div class='col-md-4'>
                                <label class='label-control'>Select Year</label>
                                <select disabled name='year' class='form-control'>
                                    <option value="2078">2078</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class='label-control'>Questions Paper</label>
                                <select disabled name="question_collection" id="question_collection" class='form-control'>

                                </select>
                            </div>
                        </div>

                        <div class='form-row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>Type</label>
                                <select disabled name='question_type' class='form-control'>
                                    <option value="subjective" @if($record->question_structure == "subjective") selected @endif>Subjective</option>
                                    <option value="objective"@if($record->question_structure == "objective") selected @endif>Objective</option>
                                </select>
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>Points</label>
                                <input type='text' name='points' value="{{ old('points',$record->total_point) }}" class='form-control' />
                            </div>
                        </div>
                        <div class='form-row mt-2'>
                            <div class='col-md-12'>
                                <label class='label-control'>Questions</label>
                                <textarea  name='question' class='form-control' id="questions">{{old('question',$record->question_title)}}</textarea>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class='col-md-6'>
                                <label class='label-control'>Question Type</label>
                                <select name='question_display_type' class="form-control">
                                    <option value="text" @if($record->question_type == "text") selected @endif>Text</option>
                                    <option value="image" @if($record->question_type == "image") selected @endif>Image</option>
                                    <option value="audio" @if($record->qustion_type == "audio") selected @endif>Audio</option>
                                </select>
                            </div>

                            <div class='col-md-6 @if($record->question_type == "image" || $record->questioon_type=="audio") @else d-none @endif' id="question_display_result">
                                <label class='label-control'>Upload File</label>
                                <input type="file" name="question_display_file" class='form-control @if($record->question_type=="text") d-none @endif' />
                            </div>
                        </div>
                    </div>
                    @if($record->question_structure == "objective")
                    <div class='card-body @if($record->question_type == "subjective") d-none  @endif' id='objective_answer'>
                        @php
                            $answer = json_decode($record->objectives);
                            
                        @endphp
                        <h5>Answers</h5>
                        <div class='form-row'>
                            @if(isset($answer[0]) && ($answer[0]->type == "image" || $answer[0]->type == "audio"))
                                <div class='col-md-3'>
                                    @if(isset($answer[0]) && $answer[0]->type == "audio")
                                        <label class='label-control'>Currect Audio</label>
                                        <audio controls class='form-control'>
                                            <source src="{{ audio_asset($answer[0]->media) }}" type="audio/ogg" />
                                            <source src="{{ audio_asset($answer[0]->media) }}" type="audio/mpeg" />
                                        </audio>
                                    @endif
                                    @if(isset($answer[0]) && $answer[0]->type == "image")
                                        <label class='label-control'>Currect Image</label>
                                        <img src="{{ question_image ($answer[0]->media)}}" class='img  img-circle' style="width:50px; height:50px" />
                                    @endif
                                </div>
                            @endif
                            <div @if(isset($answer[0]) && $answer[0]->type != "text") class='col-md-3' @else class='col-md-6' @endif'>
                                <label class='label-control'>Write Answer</label>
                                <input type='text' value="@if(isset($answer[0]) && $answer[0]->type== 'text') {{ $answer[0]->text }}  @endif"  class="form-control @if(isset($answer[0]) && $answer[0]->type !='text') d-none @endif " id="answer_text_one" name='answer_text_one' />
                                <input type='file' class="form-control @if(isset($answer[0]) && $answer[0]->type == 'text') d-none @endif" id="answer_file_one" name='answer_file_one' />
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Type</label>
                                <select class='form-control' name='type_one'>
                                    <option value='text' @if(isset($answer[0]) && $answer[0]->type == "text") selected @endif>Text</option>
                                    <option value='image' @if(isset($answer[0]) && $answer[0]->type == "image") selected @endif>Image</option>
                                    <option value='audio' @if(isset($answer[0]) && $answer[0]->type == "audio") selected @endif>Audio</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Righ Answer</label>
                                <select class='form-control' name='corrent_answer_one'>
                                    <option value='yes' @if(isset($answer[0]) && $answer[0]->correct) selected @endif>Yes</option>
                                    <option value='no' @if(isset($answer[0]) &&  ! $answer[0]->correct) selected @endif>No</option>
                                </select>
                            </div>
                        </div>

                        <div class='form-row'>
                            @if(isset($answer[1]) && ($answer[1]->type == "image" || $answer[1]->type == "audio"))
                                <div class='col-md-3'>
                                    @if(isset($answer[1]) && $answer[1]->type == "audio")
                                        <label class='label-control'>Currect Audio</label>
                                        <audio controls class='form-control'>
                                            <source src="{{ audio_asset($answer[1]->media) }}" type="audio/ogg" />
                                            <source src="{{ audio_asset($answer[1]->media) }}" type="audio/mpeg" />
                                        </audio>
                                    @endif
                                    @if(isset($answer[1]) && $answer[1]->type == "image")
                                        <label class='label-control'>Currect Image</label>
                                        <img  style="width:50px; height:50px" src="{{ question_image ($answer[1]->media)}}" class='img img-resonsive img-circle' />
                                    @endif
                                </div>
                            @endif
                            <div @if(isset($answer[1]) && $answer[1]->type != "text") class='col-md-3' @else class='col-md-6' @endif'>
                                <label class='label-control'>Write Answer</label>
                                <input type='text' value="@if(isset($answer[1]) && $answer[1]->type== 'text') {{ $answer[1]->text }}  @endif"  class="form-control @if(isset($answer[1]) && $answer[1]->type !='text') d-none @endif " id="answer_text_two" name='answer_text_two' />
                                <input type='file' class="form-control @if(isset($answer[1]) && $answer[1]->type == 'text') d-none @endif" id="answer_file_two" name='answer_file_two' />
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Type</label>
                                <select class='form-control' name='type_two'>
                                    <option value='text'@if(isset($answer[1]) && $answer[1]->type == "text") selected @endif>Text</option>
                                    <option value='image'@if(isset($answer[1]) && $answer[1]->type == "image") selected @endif>Image</option>
                                    <option value='audio' @if(isset($answer[1]) && $answer[1]->type == "audio") selected @endif>Audio</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Righ Answer</label>
                                <select class='form-control' name='corrent_answer_two'>
                                    <option value='yes'   @if(isset($answer[1]) && $answer[1]->correct) selected @endif>yes</option>
                                    <option value='no'  @if(isset($answer[1]) &&  ! $answer[1]->correct) selected @endif>No</option>
                                </select>
                            </div>
                        </div>

                        <div class='form-row'>
                             @if( isset($answer[2]) && ( $answer[2]->type == "image" || $answer[2]->type == "audio"))
                                <div class='col-md-3'>
                                    @if(isset($answer[2]) && $answer[2]->type == "audio")
                                        <label class='label-control'>Currect Audio</label>
                                        <audio controls class='form-control'>
                                            <source src="{{ audio_asset($answer[2]->media) }}" type="audio/ogg" />
                                            <source src="{{ audio_asset($answer[2]->media) }}" type="audio/mpeg" />
                                        </audio>
                                    @endif
                                    @if(isset($answer[2]) && $answer[2]->type == "image")
                                        <label class='label-control'>Currect Image</label>
                                        <img  style="width:50px; height:50px" src="{{ question_image ($answer[2]->media)}}" class='img img-resonsive img-circle' />
                                    @endif
                                </div>
                            @endif
                            <div @if(isset($answer[2]) && $answer[2]->type != "text") class='col-md-3' @else class='col-md-6' @endif'>
                                <label class='label-control'>Write Answer</label>
                                <input type='text' value="@if(isset($answer[2]) && $answer[2]->type== 'text') {{ $answer[2]->text }}  @endif"  class="form-control @if(isset($answer[2]) && $answer[2]->type !='text') d-none @endif " id="answer_text_three" name='answer_text_three' />
                                <input type='file' class="form-control @if(isset($answer[2]) && $answer[2]->type == 'text') d-none @endif" id="answer_file_three" name='answer_file_three' />
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Type</label>
                                <select class='form-control' name='type_three'>
                                    <option value='text' @if(isset($answer[2]) && $answer[2]->type == "text") selected @endif>Text</option>
                                    <option value='image' @if(isset($answer[2]) && $answer[2]->type == "image") selected @endif>Image</option>
                                    <option value='audio' @if(isset($answer[2]) && $answer[2]->type == "audio") selected @endif>Audio</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Righ Answer</label>
                                <select class='form-control' name='corrent_answer_three'>
                                    <option value='yes'  @if(isset($answer[2]) && $answer[2]->correct) selected @endif>Yes</option>
                                    <option value='no'  @if(isset($answer[2]) &&  ! $answer[2]->correct) selected @endif>No</option>
                                </select>
                            </div>
                        </div>

                        <div class='form-row'>
                            @if( isset($answer[3]) && ( $answer[3]->type == "image" || $answer[3]->type == "audio"))
                                <div class='col-md-3'>
                                    @if( isset($answer[3]) && $answer[3]->type == "audio")
                                        <label class='label-control'>Currect Audio</label>
                                        <audio controls class='form-control'>
                                            <source src="{{ audio_asset($answer[3]->media) }}" type="audio/ogg" />
                                            <source src="{{ audio_asset($answer[3]->media) }}" type="audio/mpeg" />
                                        </audio>
                                    @endif
                                    @if( isset($answer[3]) && $answer[3]->type == "image")
                                        <label class='label-control'>Currect Image</label>
                                        <img  style="width:50px; height:50px" src="{{ question_image ($answer[3]->media)}}" class='img img-resonsive img-circle' />
                                    @endif
                                </div>
                            @endif
                            <div @if( isset($answer[3]) && $answer[3]->type != "text")class='col-md-3' @else class='col-md-6' @endif'>
                                <label class='label-control'>Write Answer</label>
                                <input type='text' value="@if( isset($answer[3]) && $answer[3]->type== 'text') {{ $answer[3]->text }}  @endif"  class="form-control @if( isset($answer[3]) && $answer[3]->type !='text') d-none @endif "  name='answer_text_four' />
                                <input type='file' class="form-control @if( isset($answer[3]) && $answer[3]->type == 'text') d-none @endif" id="answer_file_four" name='answer_file_four' />
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Type</label>
                                <select class='form-control' name='type_four'>
                                    <option value='text' @if( isset($answer[3]) && $answer[3]->type == "text") selected @endif>Text</option>
                                    <option value='image' @if( isset($answer[3]) && $answer[3]->type == "image") selected @endif>Image</option>
                                    <option value='audio' @if( isset($answer[3]) && $answer[3]->type == "audio") selected @endif>Audio</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class='label-control text-bold'>Righ Answer</label>
                                <select class='form-control' name='corrent_answer_four'>
                                    <option value='yes'  @if( isset($answer[3]) && $answer[3]->correct) selected @endif>Yes</option>
                                    <option value='no' @if( isset($answer[3]) &&  ! $answer[3]->correct) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class='card-footer bg-light'>
                        <button type="submit" class='btn btn-info'>Update Questions</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $("select[name='type_one']").change(function() {
        console.log(this.value);
        if (this.value == "image") {
            $("input[name='answer_text_one']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_one']")
                    .removeAttr('accept')
                    .attr('accept','image/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if(this.value == "audio") {
        $("input[name='answer_text_one']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_one']")
                    .removeAttr('accept')
                    .attr('accept','audio/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if (this.value == 'text' ) {
            $("input[name='answer_file_one']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_text_one']")
                .removeClass('d-none')
                .show()
            })
        }
    })
</script>

<script>
    $("select[name='type_two']").change(function() {
        console.log(this.value);
        if (this.value == "image") {
            $("input[name='answer_text_two']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_two']")
                    .removeAttr('accept')
                    .attr('accept','image/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if(this.value == "audio") {
        $("input[name='answer_text_two']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_two']")
                    .removeAttr('accept')
                    .attr('accept','audio/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if (this.value == 'text' ) {
            $("input[name='answer_file_two']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_text_two']")
                .removeClass('d-none')
                .show()
            })
        }
    })
</script>

<script>
    $("select[name='type_three']").change(function() {
        console.log(this.value);
        if (this.value == "image") {
            $("input[name='answer_text_three']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_three']")
                    .removeAttr('accept')
                    .attr('accept','image/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if(this.value == "audio") {
        $("input[name='answer_text_three']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_three']")
                    .removeAttr('accept')
                    .attr('accept','audio/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if (this.value == 'text' ) {
            $("input[name='answer_file_three']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_text_three']")
                .removeClass('d-none')
                .show()
            })
        }
    })
</script>


<script>
    $("select[name='type_four']").change(function() {
        console.log(this.value);
        if (this.value == "image") {
            $("input[name='answer_text_four']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_four']")
                    .removeAttr('accept')
                    .attr('accept','image/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if(this.value == "audio") {
        $("input[name='answer_text_four']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_file_four']")
                    .removeAttr('accept')
                    .attr('accept','audio/*')
                    .removeClass('d-none')
                    .show()
            });
        } else if (this.value == 'text' ) {
            $("input[name='answer_file_four']").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='answer_text_four']")
                .removeClass('d-none')
                .show()
            })
        }
    })
</script>

<script>
    tinymce.init({
    selector: 'textarea',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
});
</script>

<script type="text/javascript">
    $("select[name='question_display_type']").change(function() {
        console.log(this.value);
        if (this.value == "image") {
            $("#question_display_result").fadeIn('fast',function(){
                $(this).removeClass('d-none');
                $("input[name='question_display_file']")
                    .removeAttr('accept')
                    .attr('accept','image/*')
                    .removeClass('d-none')
                    // .show()
            });
        } else if(this.value == "audio") {
        $("#question_display_result").fadeIn('fast',function(){
                $(this).removeClass('d-none');
                $("input[name='question_display_file']")
                    .removeAttr('accept')
                    .attr('accept','audio/*')
                    .removeClass('d-none')
                    // .show()
            });
        } else if (this.value == 'text' ) {
            $("#question_display_result").fadeOut('fast',function(){
                $(this).addClass('d-none');
                $("input[name='question_display_file']")
                .addClass('d-none')
                // .show()
            })
        }
    })
</script>