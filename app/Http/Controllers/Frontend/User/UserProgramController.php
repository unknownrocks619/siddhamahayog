<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class UserProgramController extends Controller
{
    //
    public function index()
    {
        $programs = ProgramStudent::where('student_id', auth()->id())
            ->with(["program", 'section', 'batch'])
            ->latest()->get();
        return view('frontend.user.program.index', compact('programs'));
    }
}
