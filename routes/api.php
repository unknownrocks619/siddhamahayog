<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cities',function(Request $request) {
    if (! request()->country ){
        abort(404);
    }
    $country = \App\Models\Countries::findOrFail(request()->country);

    $cities = \App\Models\City::select('id','name as text')->where('country_id',$country->id)->get();
    return response(['results'=>$cities]);

})->name('cities-list');

Route::get("/question-pape", function (Request $request) {
    if ( ! $request->sibir ) {
        return response(404);
    }
    $sibir_detail = \App\Models\SibirRecord::find($request->sibir);
    
    if ( ! $sibir_detail ) {
        return response(204)->json([]);
    }
    
    //
    $questions = \App\Models\QuestionCollection::select(["question_term_slug","question_term"])->where('sibir_record_id',$sibir_detail->id)->get();

    if ( ! $questions ) {
        return response(204)->json([]);
    }

    $response = "";
    $response .= "<option value=''>Select Exam</option>";
    foreach ($questions as $question) {
        $response .= "<option value='{$question->question_term_slug}'>";
        $response .= $question->question_term;
        $response .= "</option>";
    }
    return $response;

})->name('api-response-question-collection');

Route::get('/show-questions-collection', function (Request $request) {
    if ( ! $request->question_collection) {
        return "<h4 class='text-danger'>Data not available</h4>";
    }
    return view('admin.api-layout.question-list');
})->name('api_list_questions_for_collection');



Route::get('/exam/evaulate/{q_collection?}', function (Request $request) {
    // get current collection detail
    $collection = \App\Models\QuestionCollection::where('question_term_slug',$request->question_collection)->first();
    return view("admin.api-layout.exam_stat",compact('collection'));
})->name("api_evaludate_answers");