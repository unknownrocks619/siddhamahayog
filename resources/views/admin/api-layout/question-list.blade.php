@if(! request()->sibir || ! request()->question_collection )
    <p>No Question Available</p>
@else

    @php
        $question_model = \App\Models\QuestionCollection::where('question_term_slug',request()->question_collection)->first();
        if ( ! $question_model ) {
            echo "<h4 class='text-danger'>Record Not Found</h4>";
            die();
        }
        if ( ! $question_model->questions->count() ) {
            echo "<h4 class='text-danger'>Record Not Found</h4>";
            die();
        }
    @endphp
    <h4 class='card-title'>Subjective & Objective Questions</h4>
    @foreach ($question_model->questions as $question)
        <div class='row'>
            <div class='col-md-8 table-hover'>
                <div class='card'>  
                    @if($question->question_title)
                        <div class='card-header mb-0 pb-0'>
                            <h5>
                                {!! $question->question_title !!}
                            </h5>
                            <p class='text-info'><strong>Points: </strong> {{ $question->total_point }} </p>
                        </div>
                    @endif
                    @if($question->question_type == "audio")
                        <div class='card-header mb-0 pb-0 border-bottom'>
                          
                                <audio controls>
                                    <source src="{{ audio_asset($question->alternate_question_title) }}" type="audio/ogg" />
                                    <source src="{{ audio_asset($question->alternate_question_title) }}" type="audio/mpeg" />
                                    Your browser does not support the audio tag.
                                </audio>
                        </div>
                    @endif

                    @if($question->question_type == "image")
                        <div class='card-header mb-0 pb-0 border-bottom'>
                            <img class='img-thumbnail' src="{{ question_image($question->alternate_question_title) }}" />
                        </div>
                    @endif

                    <div class='card-body'> 
                        @php
                            if($question->question_structure == "objective") {
                                $current_questions = json_decode($question->objectives);
                                $loop = ["first","second",'third','forth'];
                                $numeric = ["one",'two','three','four'];
                                $loop_counter = 0;
                                echo "<div class='row'>";
                                    foreach ($current_questions as $active_question) {
                                        
                                        if ($active_question->type == "text" && $active_question->text != null) {
                                            // for text
                                            echo "<div class='col-md-6'>";
                                                echo "<label";
                                                    if ($active_question->correct ) {
                                                        echo " class='options mb-2 lable-control '  ";
                                                    } else {
                                                        echo " class='options mb-2 label-control' ";
                                                    }
                                                echo ">";
                                                    echo $active_question->text ;
                                                    echo "<input type='radio' ";
                                                    if ($active_question->correct) {
                                                        echo " checked ";
                                                    }
                                                    echo " disabled>"; 
                                                    echo "<span class='checkmark'></span>"; 
                                                echo "</label>"; 
                                            echo "</div>";
                                            // 

                                        } else if ($active_question->type == "audio") {
                                            echo "<div class='col-md-6 mt-2'>";
                                                echo "<label class='options label-control pr-4'>";
                                                    echo "<input disabled  type='radio' ";
                                                        if ($active_question->correct) {
                                                            echo " checked  ";
                                                        }
                                                    echo " disabled />";
                                                    echo "<span class='checkmark mt-2'></span>";
                                                    echo "<audio controls style='width:150px'>";
                                                        echo "<source src='". audio_asset($active_question->media) ."' type='audio/ogg' />";
                                                        echo "<source src='".audio_asset($active_question->media) . "' type='audio/mpeg' />";
                                                        echo "Your browser does not support the audio tag.";
                                                    echo "</audio>";
                                                echo "</label>";
                                            echo "</div>";

                                        }   else if ($active_question->type == "image") {
                                            echo "<div class='col-md-6'>";
                                                echo "<label class='options mb-2 lable-control label-control pr-4' style='font-size:20px'>";
                                                echo "<input type='radio' ";
                                                    if ($active_question->correct) {
                                                        echo " checked ";
                                                    }
                                                echo " disabled  />";
                                                echo "<span class='checkmark' style='top: 50% !important'></span>";
                                                echo "<img src='".question_image ($active_question->media) ."' style='width:245px; height:245px;' />";
                                            echo "</div>";
                                        }
                                        $loop_counter++;
                                    }
                                echo "</div>";
                            }

                        @endphp
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <a data-option="{{ $question->id }}" data-toggle="modal" data-target="#edit-modal" href='{{ route("modals.display",["display"=>"modal","modal"=>"edit-question","reference"=>"question","reference_id"=>$question->id])  }}' class='btn btn-sm bg-success text-white'>Edit</a>
                <a href="{{ route('questions.admin_question_delete',$question->id) }}" class='btn btn-inline btn-sm bg-danger text-white'>Danger</a>
            </div>
        </div>
    @endforeach
@endif
