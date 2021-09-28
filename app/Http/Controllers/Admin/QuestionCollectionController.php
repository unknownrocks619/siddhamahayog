<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionCollection;

class QuestionCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $collections = QuestionCollection::latest()->get();
        return view('admin.questions-collection.question-collection-list',compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.questions-collection.add-question-collection');
        // return view("admin.questions-collection.add-question-collection");
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
        $request->validate([
            "exam_title" => "required|string|unique:question_collections,question_term",
            "exam_start_date" => "required|date_format:Y-m-d",
            "exam_in_minute" =>"required|numeric",
            "exam_start_time" =>"required|date_format:H:i",
        ]);
        $title_slug = \Str::slug($request->exam_title,'-');
        $exists = QuestionCollection::where('question_term_slug',$title_slug)->first();

        if ( $exists ) {
            $request->session()->flash('message',"Exam Already Exists.");
            return back()->withInput();
        }

        // let's insert into database.
        $record = [
            "sibir_record_id" => $request->sibir,
            "question_term" => $request->exam_title,
            "question_term_slug" => $title_slug,
            "sortable" => $request->sortable,
            'exam_start_date' => $request->exam_start_date,
            'exam_end_date' => $request->exam_end_date,
            'start_time' => date("h:i A",strtotime($request->exam_start_time)),
            "end_time" => date("h:i A",strtotime($request->exam_end_time)),
            "total_exam_time" => $request->exam_in_minute,
            "description" => $request->description,
            "user_login_id" => auth()->id()
        ];
        try {
            QuestionCollection::create($record);      
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Unable to save record. Error: " . $th->getMessage());
            return back()->withInput();
        }

        $request->session()->flash("success","New exam paper created.");
        return back();
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
    public function edit(QuestionCollection $collection)
    {
        //
        return view('admin.questions-collection.edit-question-collection',compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionCollection $collection)
    {
        //
        $title_slug = \Str::slug($request->exam_title,'-');
        $exists = QuestionCollection::where('question_term_slug',$title_slug)
                                    ->where('id','!=',$collection->id)->first();

        if ( $exists ) {
            $request->session()->flash('message',"Exam Already Exists.");
            return back()->withInput();
        }
        $collection->sibir_record_id = $request->sibir;
        $collection->question_term = $request->exam_title;
        $collection->question_term_slug = $title_slug;
        $collection->sortable = $request->sortable;
        $collection->exam_start_date = $request->exam_start_date;
        $collection->exam_end_date = $request->exam_end_date;
        $collection->start_time = date("h:i A",strtotime($request->exam_start_time));
        $collection->end_time = date("h:i A",strtotime($request->exam_end_time));
        $collection->total_exam_time = $request->exam_in_minute;
        $collection->description = $request->description;
        // dd($collection);
        $collection->user_login_id = auth()->id();

        try {
            $collection->save();
        } catch (\Throwable $th) {
            $request->session()->flash('message',"Unable to Update. Error: ". $th->getMessage());
            return back();
        }

        $request->session()->flash('success','Question collection updated.');
        return back();
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionCollection $delete)
    {
        //
        try {
            \DB::transaction(function() use($delete) {
                if ($delete->questions) {
                    $delete->questions->delete();
                }
                $delete->delete();
            });
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Unable to delete. Error: ". $th->getMessage());
            return back();
        }

        $request->session()->flash('success',"Exam Question Collection Deleted.");
        return back();
    }

}
