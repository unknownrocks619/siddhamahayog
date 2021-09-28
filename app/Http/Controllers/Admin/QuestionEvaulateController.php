<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\QuestionCollection;
use App\Models\SibirRecord;
use App\Models\UserAnswer;
use App\Models\UserAnswersSubmit;

class QuestionEvaulateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sibir_record = SibirRecord::get();
        return view("admin.evaluate.index",compact('sibir_record'));
    }

    public function eval_form(){
        $sibir_record = SibirRecord::get();

        return view("admin.evaluate.eval",compact('sibir_record'));
    }

    public function manual_eval(Request $request){
        $collection = QuestionCollection::where('question_term_slug',$request->question_collection)->first();
        $attempt_list = UserAnswer::where('question_collection_id',$collection->id)->get();
        return view('admin.api-layout.eval-list',compact('collection','attempt_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_subjective_marks(Request $request)
    {
        //
        $answer = UserAnswersSubmit::findOrFail($request->answer_for);
        
        // check previous marks deduct from total marks.
        $answer->answer_collection->marks_obtained = $answer->answer_collection->marks_obtained - $answer->obtained_marks;
        $answer->answer_collection->marks_obtained += $request->marks;
        $answer->answer_collection->display = true;
        $answer->obtained_marks = $request->marks;
        $answer->marks_verified = true;
        $answer->is_correct = ($request->marks) ? true : false;

        try {
            $answer->save();
            $answer->answer_collection->save();
        } catch (\Throwable $th) {
            return response([
                'success' => false,
                'message' => "Unable to save changes."
            ]);
        }

        return response([
            "success" => true,
            'message' => "Record updated."
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
