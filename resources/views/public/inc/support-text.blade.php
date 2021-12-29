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

  

    @if($question->count() > $user_answer )
        <div class="card" style="background: #f1b633 !important">
            <div class="card-body">
                <h2 class='card-title'> Notice / सूचना </h2>
                <p class='text-white text-lg'>
                    <!-- You have  -->
                    @php
                        $remaining_question = $question->count() - $user_answer;

                        // $count_array = ["one","two",'three','four','five'];
                        // if ($remaining_question > 5) {
                        //    echo " 5+ ";
                        // } else {
                        //    echo $count_array[$remaining_question-1];
                        // }
                    @endphp
                    प्रथम त्रैमासिक प्रश्न पत्र , वैराग्य प्रकरण र द्वितीय त्रैमासिक प्रश्न पत्र, मुमुक्षु प्रकरण को अभ्यास गर्नुहोस ।


                    <!-- unattended questions left in your home section. -->
                </p>
                <a href="{{ route('public.exam.public_examination_list') }}" class='btn btn-lg btn-info'>Attend My Question / अभ्यास </a>
                <hr />
                <!-- <p class='text-danger'>If you have already attended the home please ignore this notice.</p> -->
            </div>
        </div>
    @endif