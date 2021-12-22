<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ Questions;
use App\Models\QuestionCollections;
use App\Models\SibirRecord;
use App\Models\UserSadhakRegistration;
use App\Models\QuestionCollection;
use App\Models\UserAnswer;
use App\Models\UserAnswersSubmit;
use App\Traits\Upload;

class GeneralQuestionsController extends Controller
{
    //
    use Upload;
    public function index() {
        $collections = QuestionCollection::with('questions')->get();
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
                                now()->addMinute(2),
                                [encrypt($collection->id)]
            );    
        } else {
            $signed_url = \URL::temporarySignedRoute(
                'public.exam.public_examination_start',
                now()->addMinute(($collection->total_exam_time) ? $collection->total_exam_time : 60) ,
                [encrypt($collection->id),"q"=>$next_question]);

        }
        return redirect()->to($signed_url);
    }

    public function question_complete($collection) {
        $question = QuestionCollection::where('id',decrypt($collection))->firstOrFail();

        return view('public.user.questions.complete',compact('question'));
    }
}
