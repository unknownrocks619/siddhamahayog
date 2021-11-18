    @php
    
        // check if there is new question and check if this user have attended the question.
        $all_question =\App\Models\Questions::select("id")->get();
        $last_question = \App\Models\Questions::latest()->first();
        $question = $all_question->pluck('id');
        $signed_url = URL::temporarySignedRoute(
														'public.exam.public_examination_start',
														now()->addMinute(60) ,
														[encrypt($last_question->question_collections_id)]);
        $user_answer = \App\Models\UserAnswersSubmit::select('sibir_record_id')->whereIn('question_id',$question)->where('user_login_id',auth()->id())->count();
    @endphp

    <div class="card bg-danger">
        <div class="card-header bg-danger">
            <h4 class='card-title text-white'>Exam Notice</h4>
        </div>
        <div class="card-body text-white border-none" style="border-bottom:none !important">
            <!-- <p class='text-white'> -->
                {!! $last_question->question_title !!}
            <!-- </p> -->
        </div>
        <div class="card-footer bg-danger" style="border-top:none !important">
            <a href="{{ $signed_url }}" class='btn btn-primary'>Submit My Answer</a>
        </div>
    </div>

    @if($question->count() > $user_answer )
        <div class="card">
            <div class="card-body">
                <h5 class='card-title'>Homework Notice</h5>
                <p class='text-info'>
                    You have 
                    @php
                        $remaining_question = $question->count() - $user_answer;

                        $count_array = ["one","two",'three','four','five'];
                        if ($remaining_question > 5) {
                            echo " 5+ ";
                        } else {
                            echo $count_array[$remaining_question-1];
                        }
                    @endphp 
                    unattended questions left in your home section.
                </p>
                <a href="{{ route('public.exam.public_examination_list') }}" class='btn btn-sm btn-info'>Attend My Question</a>
                <hr />
                <p class='text-danger'>If you have already attended the home please ignore this notice.</p>
            </div>
        </div>
    @endif