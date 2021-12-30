<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\QuestionCollections;
use App\Models\SibirRecord;
use App\Models\UserSadhakRegistration;
use App\Models\QuestionCollection;
use App\Models\UserAnswer;
use App\Models\UserAnswersSubmit;
use App\Traits\Upload;
use Illuminate\Support\Facades\Storage;

class GeneralQuestionsController extends Controller
{
    //
    use Upload;
    public function index() {
        $collections = QuestionCollection::where("active",true)->with('questions')->get();
        return view('public.user.questions.index',compact('collections'));
    }

    public function start_exam(Request $request, $collection) {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        $question = QuestionCollection::withCount(["questions"])->find(decrypt($collection));
        if ( ! $question ) {
            $request->session()->flash("message","Question not available.");
            return back();
        }

        if ( $request->q ) {
            $qts = Questions::findOrFail($request->q);
        } else {
            $qts = Questions::where('question_collections_id',$question->id)->first();
            // dd($qts);

        }
        return view("public.user.questions.start-exam-new",compact('question','qts'));
        return view("public.user.questions.start-exam",compact('question','qts'));
    }

    public function user_answer(Request $request,$collection,$question) {
        
        // fetch collection
        $collection = QuestionCollection::findOrFail(decrypt($collection));
        // fetch current question
        // dd($question);
        $q = Questions::where("question_collections_id",$collection->id)
                                // ->offset($question)
                                ->find($question);
        // check if user have alredy attempted
        $user_answer = UserAnswersSubmit::where('user_login_id',auth()->id())
                                    ->where('question_collection_id',$collection->id)
                                    ->where('question_id',$q->id)
                                    ->first();
        if ( $user_answer ) {
            // $next_question = Questions::where("question_collections_id",$collection->id)
            //                         ->where('id','>',$q->id)
            //                         ->min('id');
            // $signed_url = \URL::temporarySignedRoute(
            //     'public.exam.public_examination_start',
            //     now()->addMinute(($collection->total_exam_time) ? $collection->total_exam_time : 60) ,
            //     [encrypt($collection->id),"q"=>$next_question]);
            $request->session()->flash("message","You have already attempted this question.");

            return back();
        }

        // check if this collection has already been added.
        $answer_collection = UserAnswer::where('question_collection_id',$collection->id)
                                        ->where('user_detail_id',auth()->user()->user_detail_id)
                                        ->where('user_login_id',auth()->id())
                                        ->first();


        // now lets check everything.
        if ($q->question_structure == "subjective") {
            $user_answer = new UserAnswersSubmit;
            $is_correct = true;
            $user_answer->question_collection_id = $collection->id;
            $user_answer->sibir_record_id = $collection->sibir_record_id;
            $user_answer->question_id = $q->id;
            $user_answer->subjective_answer = $request->answer;
            $user_answer->marks_verified = false;
            $user_answer->user_login_id = auth()->id();
            $user_answer->user_detail_id = auth()->user()->user_detail_id;
            $user_answer->question_type = $q->question_structure;

            // check if user have uploaded any images or audio.
            if ($request->hasFile('file') ) {
                // get file type image or audio
                $user_answer->subjective_answer_upload = json_encode(
                                            [
                                                "file"=>$this->upload($request,"file")->id,
                                                'type'=>$request->file->getMimeType()
                                            ]);
            }
            // dd($request->hasFile('file'));?
        }
        if ($q->question_structure == "objective") {
            $user_answer = new UserAnswersSubmit;
            
            $question_decode = json_decode($q->objectives);
            $answer = [];
            $is_correct = false;
            foreach ($question_decode as $key => $qts) {
                if ($key == $request->answer) {
                   $question_decode[$key]->user_choice = true;
                } else {
                    $question_decode[$key]->user_choice = false;
                }
                if ($key == $request->answer && $qts->correct) {
                    $is_correct = true;
                }
            }

            $user_answer->question_collection_id = $collection->id;
            $user_answer->sibir_record_id = $collection->sibir_record_id;
            $user_answer->question_id = $q->id;
            // $user_answer->subjective_answer = $request->answer;
            $user_answer->marks_verified = false;
            $user_answer->user_login_id = auth()->id();
            $user_answer->user_detail_id = auth()->user()->user_detail_id;
            $user_answer->question_type = $q->question_structure;
            $user_answer->user_answers = json_encode($question_decode);
            $user_answer->is_correct = $is_correct;

            if ($is_correct) {
                $user_answer->obtained_marks = $q->total_point;
            } else {
                $user_answer->obtained_marks = 0;
            }
        }
        
        // now also lets add this on answer submit if not added
        if ($answer_collection && $q->question_structure == 'objective' && $is_correct) {
            $answer_collection->marks_obtained = $answer_collection->marks_obtained + $q->total_point;
            $answer_collection->total_attempt += 1;
            $answer_collection->total_correct = $answer_collection->total_correct+ 1;
        } else if ($answer_collection && $q->question_structure == "objective" && ! $is_correct) {
            $answer_collection->marks_obtained = $answer_collection->marks_obtained;
            $answer_collection->total_attempt += 1;
            $answer_collection->total_incorrect = $answer_collection->total_incorrect+1;
        } else if ($answer_collection && $q->question_structure == "subjective") {
            $answer_collection->total_attempt += 1;
        }

        if ( ! $answer_collection ) {
            $answer_collection = new UserAnswer;
            $answer_collection->sibir_record_id = $collection->sibir_record_id;
            $answer_collection->question_collection_id = $collection->id;
            $answer_collection->marks_obtained = $user_answer->obtained_marks;
            $answer_collection->user_detail_id = auth()->user()->user_detail_id;
            $answer_collection->user_login_id = auth()->id();
            $answer_collection->total_attempt = 1;
            $answer_collection->total_correct = ($is_correct) ? 1 : 0;
            $answer_collection->display = false;
            $answer_collection->total_incorrect = ( ! $is_correct) ? 1 : 0;
        }
        // now let's save this information.
        try {
            \DB::transaction( function () use ($answer_collection,$user_answer) {
                $answer_collection->save();
                $user_answer->user_answer_id = $answer_collection->id;
                $user_answer->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            $request->session()->flash('message',"Something went wrong.");
            return back();
        }

        // now lets submit user to next page..
        $next_question = Questions::where("question_collections_id",$collection->id)
                                    ->where('id','>',$q->id)
                                    ->min('id');
        if ( ! $next_question ){
            $signed_url = \URL::temporarySignedRoute(
                                'public.exam.examination_complete',
                                now()->addMinute(600),
                                [encrypt($collection->id)]
            );    
        } else {
            $signed_url = \URL::temporarySignedRoute(
                'public.exam.public_examination_start',
                now()->addMinute(600) ,
                [encrypt($collection->id),"q"=>$next_question]);

        }
        return redirect()->to($signed_url);
    }

    public function question_complete($collection) {
        $question = QuestionCollection::where('id',decrypt($collection))->firstOrFail();

        return view('public.user.questions.complete',compact('question'));
    }

    public function submit_all_answer(Request $request, $collection) {
        // if (! $request->hasValidSignature()) {
        //     abort(401);
        // }
        // dd($request->answer_file);
        $all_users_answer = $request->all();
        $total_attempt = 0;
        $total_correct = 0;
        $total_incorrect =0 ;
        // answer bulk sheet.
        $answers = [];
        $question_collection_id = decrypt($collection);
        $question_model = Questions::where('question_collections_id',$question_collection_id)->get();
        // dd($all_users_answer["subjective_answer"][9]);
        $user_previous_answer = UserAnswer::where('question_collection_id',$question_collection_id)
                                ->where('user_login_id',auth()->id())
                                ->first();

        $user_answer_submit = new UserAnswersSubmit;
        foreach ($question_model as $default_question) {

            $user_have_attempted = UserAnswersSubmit::where('question_id',$default_question->id)
                                                    ->where('user_login_id',auth()->id())
                                                    ->first();
            if ( ! $user_have_attempted ) :
                
                $innerArray = [];
                if ($default_question->question_structure == "objective") {
                    
                    $admin_answer = json_decode($default_question->objectives);
                    $question_id = $default_question->id;
                    if (isset($request->objective_answer[$default_question->id])) {
                        //
                        $total_attempt++;
                        $is_correct = false;
                        $user_answer_sheet = $request->objective_answer[$default_question->id];
                        foreach ($admin_answer as $key => $qts) {
                            // dd($default_question);
                            if($key == $user_answer_sheet) {
                                $admin_answer[$key]->user_choice = true;
                            } else {
                                $admin_answer[$key]->user_choice = false;
                            }
                            
                            if ($key == $user_answer_sheet && $qts->correct) {
                                $is_correct = true;
                            }
                        }
                        $user_previous_answer = UserAnswer::where('question_collection_id',$question_collection_id)
                                                ->where('user_login_id',auth()->id())
                                                ->first();
                        if ( $user_previous_answer ) {
                            $user_previous_answer->total_attempt = $user_previous_answer->total_attempt + 1;
                            $user_previous_answer->total_correct = ($is_correct) ? $user_previous_answer->total_correct + 1 : $user_previous_answer->total_correct;
                            $user_previous_answer->total_incorrect = ($is_correct) ? $user_previous_answer->total_incorrect : $user_previous_answer->total_incorrect + 1;
                            $user_previous_answer->marks_obtained = ($is_correct) ? $user_previous_answer->marks_obtained + $default_question->total_point : $user_previous_answer->marks_obtained;
                            $user_previous_answer->save();
                            $user_answer_id = $user_previous_answer->id;
                        } else {
                            $new_user_answer = new UserAnswer;
                            $new_user_answer->sibir_record_id = 1;
                            $new_user_answer->question_collection_id = $question_collection_id;
                            $new_user_answer->marks_obtained = ($is_correct) ? $default_question->total_point : 0;
                            $new_user_answer->user_detail_id = auth()->user()->user_detail_id;
                            $new_user_answer->user_login_id = auth()->id();
                            $new_user_answer->total_attempt = 1;
                            $new_user_answer->total_correct = ($is_correct) ? true : false;
                            $new_user_answer->total_incorrect = ($is_correct) ? false : true;

                            $new_user_answer->display = false;

                            $new_user_answer->save();
                            $user_answer_id = $new_user_answer->id();
                        }
                        // new user answer submit .
                        $user_answer_detail = new UserAnswersSubmit;
                        $user_answer_detail->user_answer_id = $user_answer_id;
                        $user_answer_detail->question_collection_id = $question_collection_id;
                        $user_answer_detail->sibir_record_id = 1;
                        $user_answer_detail->question_id = $question_id;
                        $user_answer_detail->is_correct = ($is_correct) ? true : false;
                        $user_answer_detail->obtained_marks = ($is_correct)  ? $default_question->total_point : false;
                        $user_answer_detail->marks_verified = true;
                        $user_answer_detail->question_type = $default_question->question_structure;
                        $user_answer_detail->subjective_answer = null;
                        $user_answer_detail->user_login_id = auth()->id();
                        $user_answer_detail->user_answers = json_encode($admin_answer);
                        $user_answer_detail->user_detail_id = auth()->user()->user_detail_id;
                        $user_answer_detail->save();
                    }

                } elseif ($default_question->question_structure == "subjective") {
                    
                    $is_file = false;
                    $is_subjective = true;
                    if (isset($all_users_answer["answer_file"][$default_question->id])  ) 
                    {

                        // ($request->hasFile("answer_file"));

                        // let's upload and set in the given location
                        $uploader = new \App\Models\Uploader;
                        // dd($uploader);
                        // dd($all_users_answer["answer_file"][$default_question->id]->getMimeType());
                        // orginal filename 
                        $uploader->original_name = $all_users_answer["answer_file"][$default_question->id]->getClientOriginalName();
                        $uploader->file_type = $all_users_answer["answer_file"][$default_question->id]->getMimeType();
                        $uploader->path =  Storage::putFile('site',$all_users_answer["answer_file"][$default_question->id]->path());
                        $uploader->save();
                        // dd($uploaded_file)
                        $user_answer_file  = json_encode(
                            [
                                "file"=>$uploader->id,
                                'type'=>$all_users_answer["answer_file"][$default_question->id]->getMimeType()
                            ]);

                        $is_file = true;
                        $is_subjective = false;
                        // dd($user_answer_file);
                        // dd($all_users_answer["answer_file"][$default_question->id]->getClientOriginalName());
                    }

                    if (isset($all_users_answer['subjective_answer'][$default_question->id])) {
                        $is_subjective = true;
                        $user_previous_answer = UserAnswer::where('user_login_id',auth()->id())
                                                            ->where('question_collection_id',$question_collection_id)
                                                            ->first();

                        if($user_previous_answer) {
                            $user_previous_answer->marks_obtained = null;
                            $user_previous_answer->total_attempt = $user_previous_answer->total_attempt + 1;
                            $user_previous_answer->save();
                            $user_answer_id = $user_previous_answer->id;
                        } else {
                            $user_new_answer_prev = new UserAnswer;
                            $user_new_answer_prev->sibir_record_id = 1;
                            $user_new_answer_prev->question_collection_id = $question_collection_id;
                            $user_new_answer_prev->marks_obtained = null;
                            $user_new_answer_prev->user_detail_id = auth()->user()->user_detail_id;
                            $user_new_answer_prev->user_login_id = auth()->id();
                            $user_new_answer_prev->total_attempt = 1;
                            $user_new_answer_prev->total_correct = 0;
                            $user_new_answer_prev->total_incorrect = 0;
                            $user_new_answer_prev->display = false;
                            $user_new_answer_prev->save();

                            $user_answer_id = $user_new_answer_prev->id;
                        }

                        // now let's first add users answer 
                        $user_answers_detail = new UserAnswersSubmit;
                        $user_answers_detail->question_collection_id = $question_collection_id;
                        $user_answers_detail->sibir_record_id = 1;
                        $user_answers_detail->question_id = $default_question->id;
                        $user_answers_detail->question_type = $default_question->question_structure;
                        $user_answers_detail->is_correct = null;
                        $user_answers_detail->obtained_marks = 0;
                        $user_answers_detail->marks_verified = 0;
                        $user_answers_detail->subjective_answer = $all_users_answer['subjective_answer'][$default_question->id];
                        $user_answers_detail->user_login_id = auth()->id();
                        $user_answers_detail->user_detail_id = auth()->user()->user_detail_id;
                        $user_answers_detail->user_answer_id = $user_answer_id;
                        $user_answers_detail->subjective_answer_upload = ($is_file) ? $user_answer_file : null;
                        $user_answers_detail->save(); 

                        // now let's check for upload file as well.

        
                    }

                    if ($is_file && ! $is_subjective) {
                        $user_previous_answer = UserAnswer::where('user_login_id',auth()->id())
                                                            ->where('question_collection_id',$question_collection_id)
                                                            ->first();

                        if($user_previous_answer) {
                            $user_previous_answer->marks_obtained = null;
                            $user_previous_answer->total_attempt = $user_previous_answer->total_attempt + 1;
                            $user_previous_answer->save();
                            $user_answer_id = $user_previous_answer->id;
                        } else {
                            $user_new_answer_prev = new UserAnswer;
                            $user_new_answer_prev->sibir_record_id = 1;
                            $user_new_answer_prev->question_collection_id = $question_collection_id;
                            $user_new_answer_prev->marks_obtained = null;
                            $user_new_answer_prev->user_detail_id = auth()->user()->user_detail_id;
                            $user_new_answer_prev->user_login_id = auth()->id();
                            $user_new_answer_prev->total_attempt = 1;
                            $user_new_answer_prev->total_correct = 0;
                            $user_new_answer_prev->total_incorrect = 0;
                            $user_new_answer_prev->display = false;
                            $user_new_answer_prev->save();

                            $user_answer_id = $user_new_answer_prev->id;
                        }

                        // now let's first add users answer 
                        $user_answers_detail = new UserAnswersSubmit;
                        $user_answers_detail->question_collection_id = $question_collection_id;
                        $user_answers_detail->sibir_record_id = 1;
                        $user_answers_detail->question_id = $default_question->id;
                        $user_answers_detail->question_type = $default_question->question_structure;
                        $user_answers_detail->is_correct = null;
                        $user_answers_detail->obtained_marks = null;
                        $user_answers_detail->marks_verified = 0;
                        $user_answers_detail->subjective_answer = null;
                        $user_answers_detail->user_login_id = auth()->id();
                        $user_answers_detail->user_detail_id = auth()->user()->user_detail_id;
                        $user_answers_detail->user_answer_id = $user_answer_id;
                        $user_answers_detail->subjective_answer_upload = ($is_file) ? $user_answer_file : null;
                        $user_answers_detail->save(); 
                    }
                // if ($default_question->)
                }
            endif;

        // foreach ( $all_users_answer as $question_id => $user_answer ) {
        //     $innerArray = [];
        //     $innerArray["question_collections_id"] = $question_collection_id;
        //     $innerArray["user_login_id"] = auth()->id();
        //     $innerArray["question_type"] = $
        // }
        // dd(decrypt($collection));
        }

        
        $signed_url = \URL::temporarySignedRoute(
            'public.exam.examination_complete',
            now()->addMinute(600),
            [$collection]
        );    

        return redirect()->to($signed_url);
        
    }

    public function save_as_draft(Request $request, $collection) {
        $question_collection_id = decrypt($collection);
        
        $answer_submit = new UserAnswersSubmit;
        $question_model = Questions::find($request->q_id);
        /**
         * Check if user have already submittd this question 
         * before.
         */
        $previous_answer = UserAnswersSubmit::where('question_id', $question_model->id)
                                                    ->where('user_login_id',auth()->id())
                                                    ->first();
            
        if ( $previous_answer ) {
            if ($question_model->question_structure == "subjective") {
                $previous_answer->subjective_answer = (isset ($request->subjective_answer[$request->q_id])) ? $request->subjective_answer[$request->q_id] : $previous_answer->subjective_answer;
                // check if any has been uploaded.
                if ($request->answer_file  && $request->answer_file[$question_model->id]) {
                    // if user have uploaded image.
                    $uploader = new \App\Models\Uploader;
                    // dd($uploader);
                    // dd($all_users_answer["answer_file"][$default_question->id]->getMimeType());
                    // orginal filename 
                    $uploader->original_name = $request->answer_file[$question_model->id]->getClientOriginalName();
                    $uploader->file_type = $request->answer_file[$question_model->id]->getMimeType();
                    $uploader->path =  Storage::putFile('site',$request->answer_file[$question_model->id]->path());
                    $uploader->save();
                    // dd($uploaded_file)
                    $user_answer_file  = json_encode(
                        [
                            "file"=>$uploader->id,
                            'type'=>$request->answer_file[$question_model->id]->getMimeType()
                        ]);
                } else {
                    $user_answer_file = $previous_answer->subjective_answer_upload;
                }

                try {
                    $previous_answer->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash("message","Warning: Unabe to update draft.");
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash('message',"Error: Unable to update your submit.");
                    return back();
                }

                $request->session()->flash('success',"Your draft is saved.");
                return back();
            } elseif($question_model->question_structure == "objective") {
                $admin_answer = json_decode($question_model->objectives);
                    $question_id = $question_model->id;
                    if (isset($request->objective_answer[$question_model->id])) {
                        //
                        $user_answer_sheet = $request->objective_answer[$question_model->id];
                        foreach ($admin_answer as $key => $qts) {
                            // dd($question_model);
                            if($key == $user_answer_sheet) {
                                $admin_answer[$key]->user_choice = true;
                            } else {
                                $admin_answer[$key]->user_choice = false;
                            }
                            
                            // if ($key == $user_answer_sheet && $qts->correct) {
                            //     $is_correct = true;
                            // }
                        }
                        // new user answer submit .

                        // $user_answer_detail->user_answer_id = $user_answer_id;
                        $previous_answer->user_answers = json_encode($admin_answer);
                        try {
                            $previous_answer->save();
                        } catch (\Throwable $th) {
                            $request->session()->flash('message',"Warning: Unable to Save your draft.");
                            return back();
                        } catch (\Error $et) {
                            $request->session()->flash('message',"Error: Unable to save your draft.");
                            return back();
                        }

                        $request->session()->flash("success","Your draft is saved.");
                        return back();
                    }
            }
            // just update subjective answer.
            // just updated objective answer.

            // replace file if not avaiable

            // insert new file.
        }


        if ($question_model->question_structure == "objective") {
            $admin_answer = json_decode($question_model->objectives);
            $question_id = $question_model->id;
            
            if (isset($request->objective_answer[$question_model->id])) {
                //
                $user_answer_sheet = $request->objective_answer[$question_model->id];
                foreach ($admin_answer as $key => $qts) {
                    // dd($question_model);
                    if($key == $user_answer_sheet) {
                        $admin_answer[$key]->user_choice = true;
                    } else {
                        $admin_answer[$key]->user_choice = false;
                    }
                    
                }
                
                // new user answer submit .
                $user_answer_detail = new UserAnswersSubmit;
                $user_answer_detail->user_answer_id = null;
                $user_answer_detail->question_collection_id = $question_collection_id;
                $user_answer_detail->sibir_record_id = 1;
                $user_answer_detail->question_id = $question_id;
                $user_answer_detail->is_correct = false;
                $user_answer_detail->obtained_marks = false;
                $user_answer_detail->marks_verified = true;
                $user_answer_detail->question_type = $question_model->question_structure;
                $user_answer_detail->subjective_answer = null;
                $user_answer_detail->user_login_id = auth()->id();
                $user_answer_detail->user_answers = json_encode($admin_answer);
                $user_answer_detail->user_detail_id = auth()->user()->user_detail_id;
                $user_answer_detail->draft = true;
                try {
                    $user_answer_detail->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash('message',"Warning: Unable to save your draft.");
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash("success", "Error: Unable to save your draft.");
                    return back();
                }

                $request->session()->flash('success',"Your draft is saved.");
                return back();
            }
        }

        if ($question_model->question_structure == "subjective") {
            if (isset ($request->subjective_answer[$request->q_id]) ) {
                
                $user_answer = new UserAnswersSubmit;
                $user_answer->question_collection_id = $question_model->id;
                $user_answer->sibir_record_id = 1;
                $user_answer->question_id = $question_model->id;
                $user_answer->question_type = $question_model->question_structure;
                $user_answer->is_correct = null;
                $user_answer->obtained_marks = null;
                $user_answer->marks_verified = 0;
                $user_answer->subjective_answer = $request->subjective_answer[$question_model->id];
                $user_answer->user_login_id = auth()->id();
                $user_answer->user_detail_id = auth()->user()->user_detail_id;
                $user_answer->user_answer_id = null;

                if ($request->answer_file  && $request->answer_file[$question_model->id]) {
                    // if user have uploaded image.
                    $uploader = new \App\Models\Uploader;
                    // dd($uploader);
                    // dd($all_users_answer["answer_file"][$default_question->id]->getMimeType());
                    // orginal filename 
                    $uploader->original_name = $request->answer_file[$question_model->id]->getClientOriginalName();
                    $uploader->file_type = $request->answer_file[$question_model->id]->getMimeType();
                    $uploader->path =  Storage::putFile('site',$request->answer_file[$question_model->id]->path());
                    $uploader->save();
                    // dd($uploaded_file)
                    $user_answer_file  = json_encode(
                        [
                            "file"=>$uploader->id,
                            'type'=>$request->answer_file[$question_model->id]->getMimeType()
                        ]);
                } else {
                    $user_answer_file = null;
                }
                $user_answer->subjective_answer_upload = $user_answer_file;
                $user_answer->draft = true;

                try {
                    $user_answer->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash("message","Warning: Unable to save your draft.". $th->getMessage());
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash("message","Error: Unable to save your draft.");
                    return back();
                }
                $request->session()->flash("success","Your draft is saved.");
                return back();
            }
        }
        

    }

    public function submit_single_answer(Request $request, $collection) {
        $question_collection_id = decrypt($collection);
        
        $question_model = Questions::find($request->q_id);
        /**
         * Check if user have already submittd this question 
         * before.
         */
        $previous_answer = UserAnswersSubmit::where('question_id', $question_model->id)
                                                    ->where('user_login_id',auth()->id());
        $check_no_draft = $previous_answer->where('draft',false)->first();

        if ($check_no_draft ) {
            $request->session()->flash('mesasge', "You have already submitted this answer.");
            return back();
        }
        // dd($request->all());
        // now let's check 
        $collection_answer = UserAnswer::where('question_collection_id',$question_collection_id)
                                        ->where('user_login_id',auth()->id())
                                        ->first();
        $subjective_answer = ( ($request->subjective_answer) && isset($request->subjective_answer[$request->q_id])) ? $request->subjective_answer[$request->q_id] : null;
        $objective_answer = (($request->objective_answer) && isset($request->objective_answer[$request->q_id])) ? $request->objective_answer[$request->q_id] : null;
        // check for file. 
        $user_file = ($request->answer_file && isset($request->answer_file[$request->q_id])) ? true : false;
        
        // let's upload file.
        if ( $user_file ) 
        {
            $uploader = new \App\Models\Uploader;
            $uploader->original_name = $request->answer_file[$request->q_id]->getClientOriginalName();
            $uploader->file_type = $request->answer_file[$request->q_id]->getMimeType();
            $uploader->path =  Storage::putFile('site',$request->answer_file[$request->q_id]->path());
            $uploader->save();
            $user_answer_file  = json_encode(
                [
                    "file"=>$uploader->id,
                    'type'=>$request->answer_file[$request->q_id]->getMimeType()
                ]);
        }
        if ($collection_answer) {
            $collection_id = $collection_answer->id;
            $collection_answer->total_attempt = $collection_answer->total_attempt + 1;
            $collection_answer->save();
        } else {
            $question_collection = new UserAnswer;
            $question_collection->sibir_record_id = 1;
            $question_collection->question_collection_id = $question_collection_id;
            $question_collection->marks_obtained = false;
            $question_collection->user_detail_id = auth()->user()->user_detail_id;
            $question_collection->user_login_id = auth()->id();
            $question_collection->total_attempt = 1;
            $question_collection->total_correct = 0;
            $question_collection->total_incorrect = 0;
            $question_collection->display = false;

            $question_collection->save();
            $collection_id = $question_collection->id;
        }
        $check_for_draft = UserAnswersSubmit::where('user_login_id',auth()->id())
                                            ->where('question_id', $question_model->id)
                                            // ->where('draft',true)
                                            ->first();
        // dd(auth()->id());
        if ($question_model->question_structure == "subjective") {
            // check if there is a draft.
            // dd("subjective");
            if ( $check_for_draft ) {
                $check_for_draft->user_answer_id = $collection_id;
                $check_for_draft->subjective_answer = ($subjective_answer) ? $subjective_answer : $check_for_draft->subjective_answer;
                $check_for_draft->draft = false;
                if ($user_file) {
                    $check_for_draft->subjective_answer_upload = ($user_answer_file) ? $user_answer_file : $check_for_draft->subjective_answer_upload;
                }
                try {
                    $check_for_draft->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash('message',"Warning: Unable to submit your answer from draft.". $th->getMessage());
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash("message", "Error: Unable to submit your answer.");
                    return back();
                }

                $request->session()->flash('success',"Your answer has been submitted.");
                return back();
            } else {
                $user_answer_new = new UserAnswersSubmit;
                $user_answer_new->question_collection_id = $question_collection_id;
                $user_answer_new->sibir_record_id = 1;
                $user_answer_new->question_id = $question_model->id;
                $user_answer_new->question_type = $question_model->question_structure;
                $user_answer_new->is_correct = false;
                $user_answer_new->obtained_marks = false;
                $user_answer_new->marks_verified = false;
                $user_answer_new->subjective_answer = $subjective_answer;
                $user_answer_new->user_login_id = auth()->id();
                $user_answer_new->user_detail_id = auth()->user()->user_detail_id;
                $user_answer_new->user_answer_id = $collection_id;
                $user_answer_new->subjective_answer_upload = ($user_file) ? $user_answer_file : null;
                $user_answer_new->draft = false;

                try {
                    $user_answer_new->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash('message',"Warning: Unable to submit your answer." . $th->getMessage());
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash("message","Error: Unable to submit your answer.");
                    return back();
                }
                $request->session()->flash('success',"Your answer has been submitted.");
                return back();
            }
        }

        if ($question_model->question_structure == "objective") {
            
            if($check_for_draft) {
                $check_for_draft->user_answer_id = $collection_id;
                
                // now let's again loop and get the correct answer.
                $admin_answer = json_decode($question_model->objectives);

                foreach ($admin_answer as $key => $qts) {
                    // dd($default_question);
                    if($key == $objective_answer) {
                        $admin_answer[$key]->user_choice = true;
                    } else {
                        $admin_answer[$key]->user_choice = false;
                    }
                    
                    if ($key == $objective_answer && $qts->correct) {
                        $is_correct = true;
                    }
                }
                $check_for_draft->is_correct = ($is_correct) ? true : false;
                $check_for_draft->obtained_marks = ($is_correct)  ? $question_model->total_point : false;
                $check_for_draft->marks_verified = true;
                $check_for_draft->draft = false;
                $check_for_draft->user_answers = json_encode($admin_answer);
                if ($collection_answer && $is_correct) {
                    $collection_answer->marks_obtained = $question_model->total_point;
                    $collection_answer->save();
                } elseif($question_collection && $is_correct ) {
                    $question_collection->marks_obtained = $question_model->total_point;
                    $question_collection->save();
                }
                try {
                    $check_for_draft->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash('message',"Warning: Unable to submit your objective answer." . $th->getMessage());
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash('message',"Error: Unable to submit your objective answer.");
                    return back();
                }

                $request->session()->flash("success","Your answer has been submitted");
                return back();
            } else {


                $user_answer_new = new UserAnswersSubmit;
                $user_answer_new->user_answer_id = $collection_id;
                $user_answer_new->question_collection_id = $question_collection_id;
                // now let's again loop and get the correct answer.
                $admin_answer = json_decode($question_model->objectives);

                foreach ($admin_answer as $key => $qts) {
                    // dd($default_question);
                    if($key == $objective_answer) {
                        $admin_answer[$key]->user_choice = true;
                    } else {
                        $admin_answer[$key]->user_choice = false;
                    }
                    
                    if ($key == $objective_answer && $qts->correct) {
                        $is_correct = true;
                    }
                }
                $user_answer_new->is_correct = ($is_correct) ? true : false;
                $user_answer_new->obtained_marks = ($is_correct)  ? $question_model->total_point : false;
                $user_answer_new->marks_verified = true;
                $user_answer_new->draft = false;
                $user_answer_new->user_answers = json_encode($admin_answer);
                if ($collection_answer && $is_correct) {
                    $collection_answer->marks_obtained = $question_model->total_point;
                    $collection_answer->save();
                } elseif($question_collection && $is_correct ) {
                    $question_collection->marks_obtained = $question_model->total_point;
                    $question_collection->save();
                }
                $user_answer_new->user_detail_id = auth()->user()->user_detail_id;
                $user_answer_new->user_login_id = auth()->id();
                $user_answer_new->sibir_record_id = 1;
                $user_answer_new->question_id = $question_model->id;
                $user_answer_new->question_type = $question_model->question_structure;
                
                try {
                    $user_answer_new->save();
                } catch (\Throwable $th) {
                    //throw $th;
                    $request->session()->flash('message',"Warning: Unable to submit your objective answer." . $th->getMessage());
                    return back();
                } catch (\Error $er) {
                    $request->session()->flash('message',"Error: Unable to submit your objective answer.");
                    return back();
                }

                $request->session()->flash("success","Your answer has been submitted");
                return back();


            }
        }
        
    }


}
