<?php

namespace App\Http\Controllers\API\V1\Programs;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    //

    public function userProgram()
    {
        $program = ProgramStudent::where('student_id', user()->getKey())
            ->with(['program', 'live'])
            ->where('active', true)
            ->get();
        return $program;
    }
}
