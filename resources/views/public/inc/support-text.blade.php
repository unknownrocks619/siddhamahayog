    @php
    
        // check if there is new question and check if this user have attended the question.
        $question = \App\Models\Questions::select("id")->get()->pluck('id');
        $user_answer = \App\Models\UserAnswersSubmit::select('sibir_record_id')->whereIn('question_id',$question)->where('user_login_id',auth()->id())->count();
    @endphp
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