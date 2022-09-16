<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Program\ProgramResourceIndexRequest;
use App\Http\Requests\Frontend\User\Program\ProgramResourceViewRequest;
use App\Models\Program;
use App\Models\ProgramCourseResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProgramResourceController extends Controller
{
    //

    public function index(ProgramResourceIndexRequest $request, Program $program)
    {
        $program->load(["courses"]);
        // $resources = $program->courses;
        return view('frontend.user.program.resources.index', compact('program'));
    }

    public function show(ProgramResourceViewRequest $request, Program $program, ProgramCourseResources $programResource)
    {
        // if resource is text, send modal request.

        // if resource if pdf allow force download
        if ($programResource->resource_type == "pdf") {
            return Storage::download($programResource->resource->path, $programResource->resource_title . ".pdf", ["Content-Type" => "application/pdf"]);
        }
        // if its image than display in view image section.
        return view("frontend.user.program.resources.modal." . $programResource->resource_type, compact("program", 'programResource'));
    }
}
