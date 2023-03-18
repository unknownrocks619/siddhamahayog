<?php

namespace App\Http\Controllers\API\V1\Courses;

use App\Http\Controllers\Controller;
use App\Models\ProgramChapterLession;
use App\Models\ProgramCourse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseControllerAPI extends Controller
{
    //
    public static function lession(ProgramCourse $course, int $lessionID = null): Response
    {
        $result = [];
        if ($lessionID) {
            $result = $course->lession()->where('id', $lessionID)->first();
        } else {
            $result = $course->lession;
        }
        return response($result);
    }
}
