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
        $query = ProgramChapterLession::where('program_course_id', $course->getKey());
        if (!in_array(auth()->user()->role_id, [1, 12])) {
            $query->where('status', 'active');
        }

        if ($lessionID) {
            $result = $query->where('id', $lessionID)->first();
        } else {
            $result = $query->orderBy('sort', 'asc')->get();
        }

        return response($result);
    }
}
