<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\QuestionCollection;
use App\Models\SibirRecord;
use App\Traits\Upload;
class QuestionController extends Controller
{
    //
    use Upload;

    public function index() {

        $sibir_record = SibirRecord::get();
        return view('admin.questions.question-list',compact('sibir_record'));
    }

    public function add_questions() {
        $paper_collection = QuestionCollection::get();
        $sibir_record = SibirRecord::get();
        return view("admin.questions.question-add",compact("paper_collection",'sibir_record'));
    }

    public function store_question(Request $request) {
        // dd($request->all());
        $request->validate([
            "sibir" => "required|exists:sibir_records,id",
            "question_collection" => "required|exists:question_collections,question_term_slug",
            "points" => "required|numeric",
            "question_type" => "required|in:subjective,objective",
            "question_display_type" => "required|in:text,image,audio",
            "question"=>"required_if:question_display_type,text",
            "question_display_file" => "exclude_if:question_display_type,text",
        ]);


        $question_collection = QuestionCollection::where('question_term_slug',$request->question_collection)->first();


        // get current question type.
        $objective_answer = [];
        $question_type = $request->question_type;
        if ($question_type == "objective")  {
            // lets make sure there is atleast on right answer.
            $option_one_type = $request->type_one;
            $option_two_type = $request->type_two;
            $option_three_type = $request->type_three;
            $option_four_type = $request->type_four;

            if ($option_one_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_one,'type'=>$request->type_one,'correct'=>($request->corrent_answer_one == "no") ? null : true];
            } else if($option_one_type == "image" || $option_one_type == "audio") {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_one')->id,'type'=>$request->type_one,'correct'=>($request->corrent_answer_one == "no") ? null : true];
            }
           if ($option_two_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_two,'type'=>$request->type_two,'correct'=>($request->corrent_answer_two == "no") ? null : true];
            } else if($option_two_type == "image" || $option_two_type == "audio") {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_two')->id,'type'=>$request->type_two,'correct'=>($request->corrent_answer_two == "no") ? null : true];
            }

            if ($option_three_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_three,'type'=>$request->type_three,'correct'=>($request->corrent_answer_three == "no") ? null : true];
            } else if($option_three_type == "image" || $option_three_type == "audio") {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_three')->id,'type'=>$request->type_three,'correct'=>($request->corrent_answer_three == "no") ? null : true];
            }

            if ($option_four_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_four,'type'=>$request->type_four,'correct'=>($request->corrent_answer_four == "no") ? null : true];
            } else if($option_four_type == "image" || $option_four_type == "audio") {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_four')->id,'type'=>$request->type_four,'correct'=>($request->corrent_answer_four == "no") ? null : true];
            }

        }
        // now let's inset into db.
        // dd($request->all());
        $record = [
            "question_collections_id" => $question_collection->id,
            "user_login_id" => auth()->id(),
            "question_type" => $request->question_display_type,
            "sibir_record_id" =>$request->sibir,
            "objectives" => json_encode($objective_answer),
            "question_title" => $request->question,
            "total_point" => $request->points,
            "question_structure" => $request->question_type,
        ];
        if ( ($request->question_display_type == "image" || $request->question_display_type == "audio") && $request->hasFile('question_display_file')) {
            $record["alternate_question_title"] = $this->upload($request,"question_display_file")->id;
        }

        try {
            Questions::create($record);
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Unable to Create question. Error: ". $th->getMessage());
            return back();
        }

        $request->session()->flash('success',"New Question Created.");
        return back();

    }

    public function update_question(Request $request, Questions $question) {
        $request->validate([
            "question_display_type" => "required|in:text,audio,image",
            "question" => "required_if:question_display_type,text",
            "question_display_file" => "exclude_if:question_display_type,text"
        ]);

        $question->question_title = $request->question;
        if ( ($request->question_display_type == "image" || $request->question_display_type == "audio") && $request->hasFile('question_display_file')) {
           $question->alternate_question_title = $this->upload($request,"question_display_file")->id;
        }
        if ($question->question_structure == "objective") {
            // get current question type.
            $objective_answer = [];
            $question_type = $request->question_type;
            // lets make sure there is atleast on right answer.
            $option_one_type = $request->type_one;
            $option_two_type = $request->type_two;
            $option_three_type = $request->type_three;
            $option_four_type = $request->type_four;
            $previous = json_decode($question->objectives);
            if ($option_one_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_one,'type'=>$request->type_one,'correct'=>($request->corrent_answer_one == "no") ? null : true];
            } else if(($option_one_type == "image" || $option_one_type == "audio") && $request->hasFile('answer_file_one')) {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_one')->id,'type'=>$request->type_one,'correct'=>($request->corrent_answer_one == "no") ? null : true];
            } else {
                $objective_answer[] = (isset($previous[0])) ? $previous[0] : [];
            }

            if ($option_two_type == "text") {
                    $objective_answer[] = ['text'=>$request->answer_text_two,'type'=>$request->type_two,'correct'=>($request->corrent_answer_two == "no") ? null : true];
            } else if(($option_two_type == "image" || $option_two_type == "audio" )&& $request->hasFile('answer_file_two')) {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_two')->id,'type'=>$request->type_two,'correct'=>($request->corrent_answer_two == "no") ? null : true];
            } else {
                $objective_answer[] = (isset($previous[1])) ? $previous[1] : [];
            }

            if ($option_three_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_three,'type'=>$request->type_three,'correct'=>($request->corrent_answer_three == "no") ? null : true];
            } else if(($option_three_type == "image" || $option_three_type == "audio") && $request->hasFile('answer_file_three')) {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_three')->id,'type'=>$request->type_three,'correct'=>($request->corrent_answer_three == "no") ? null : true];
            } else {
                $objective_answer[] = (isset($previous[2])) ? $previous[2] :[];
            }

            if ($option_four_type == "text") {
                $objective_answer[] = ['text'=>$request->answer_text_four,'type'=>$request->type_four,'correct'=>($request->corrent_answer_four == "no") ? null : true];
            } else if(($option_four_type == "image" || $option_four_type == "audio") && $request->hasFile('answer_file_four')) {
                $objective_answer[] = ['media'=>$this->upload($request, 'answer_file_four')->id,'type'=>$request->type_four,'correct'=>($request->corrent_answer_four == "no") ? null : true];
            } else {
                $objective_answer[] = (isset($previous[3])) ? $previous[3] : [];
            }
            $question->objectives = json_encode($objective_answer);
        }

        $question->total_point = $request->points;

        try {
            $question->save();
        } catch (\Throwable $th) {
            if ($request->ajax() ) {
                // return response([
                //     'success' => "false",
                //     'message' => "Unable to update detail. Error: ". $th->getMessage()
                // ]);
            }
            $request->session()->flash('message',"Unable to update question. Error: ". $th->getMessage());
            return back();
        }

        if ($request->ajax() ) {
            // return response([
            //     "success" => "true",
            //     "message" => "Question Updated.",
            // ]);
        }
        $request->session()->flash('success',"Question Detail Updated.");
        return back();

    }

    public function delete_question(Request $request , Questions $question) {

        try {
            $question->delete();
        } catch (\Throwable $th) {
            $request->session()->flash('message',"Unable to delete. Error: ". $th->getMessage());
            return back();
        }

        //  now lets udpate total score as well.
        $all_points = Questions::where('question_collections_id',$question->question_collections_id)->sum('total_point');
        $all_objective = Questions::where('question_collections_id',$question->question_collections_id)
                                    ->where('question_structure','objective')->count();

        $all_subjective = Questions::where('question_collections_id',$question->question_collections_id)
                                    ->where('question_structure','subjective')->count();
        try {
            $question->question_collections->total_marks = $all_points;
            $question->question_collections->total_objective = $all_objective;
            $question->question_collections->total_subjective = $all_subjective;
            $question->question_collections->save();
        } catch (\Throwable $th) {
            $request->session()->flash('message',"Question Deleted but paper was not updated. Error: ". $th->getMessage());
            return back();
        }
        $request->session()->flash('success',"Question Deleted.");
        return back();
    }
}
