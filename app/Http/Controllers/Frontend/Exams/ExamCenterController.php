<?php

namespace App\Http\Controllers\Frontend\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamCenterController extends Controller
{
    //

    public function index()
    {
        return view("frontend.user.exams.index");
    }

    public function result()
    {
        return view("frontend.user.exams.result");
    }
}
