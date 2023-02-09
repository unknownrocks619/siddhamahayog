<?php

namespace App\Http\Controllers\Frontend\Exams;

use App\Http\Controllers\Controller;
use App\Models\ProgramExam;
use Illuminate\Http\Request;

class ExamCenterController extends Controller
{
    //

    public function index()
    {
        user()->load(['member_detail']);
        $userPrograms = user()->member_detail->groupBy('program_id')->toArray();
        $exams = ProgramExam::where('program_id', array_keys($userPrograms))
                                ->withCount(['questions'])
                                ->where('active', true)->orderBy('start_date', 'desc')->get();

        return view("frontend.user.exams.index", compact('exams'));
    }

    public function result()
    {
        return view("frontend.user.exams.result");
    }
}
