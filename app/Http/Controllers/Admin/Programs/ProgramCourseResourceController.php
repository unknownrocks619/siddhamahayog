<?php

namespace App\Http\Controllers\Admin\Programs;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Program\ProgramCourseResourceRequest;
use App\Models\Program;
use App\Models\ProgramCourse;
use App\Models\ProgramCourseResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;

class ProgramCourseResourceController extends Controller
{
    //

    public function create_program_resource_modal(ProgramCourse $course)
    {
        return view("admin.programs.modal.add_resource_to_chapter", compact('course'));
    }

    public function store_program_resource(ProgramCourseResourceRequest $request, ProgramCourse $course)
    {

        // return response(["message"=>"Errror Unable to Save your data.","errors"=>["resource_title"=>["Title is requird."]]],422);
        $program_resource = new ProgramCourseResources;
        $program_resource->lock = ($request->lock_after_days) ? true : false;
        $program_resource->lock_after = $request->lock_after_days;
        $program_resource->resource_title = $request->resource_title;
        $program_resource->description = $request->resource_text;
        $program_resource->program_id = $course->program_id;
        $program_resource->program_course_id = $course->id;
        $program_resource->resource_type = $request->resource_type;

        // upload file if type is image or pdf.
        if ($request->resource_type == "image" || $request->resource_type == "pdf") {

            if (!$request->hasFile("resource_file")) {
                if ($request->wantsJson()) {
                    return response([
                        "message" => "Please check all the fields.",
                        "errors" => [
                            "resource_file" => ["Resource File Field is required for type" . ucfirst($request->resource_type)]
                        ]
                    ], 422);
                } else {
                    $request->session()->flash("error", "Resource File Field is required for type " . ucwords($request->resource_type));
                    return redirect()->route('admin.program.courses.admin_program_course_list', [$course->program_id]);
                }
            }

            $upload_file = Storage::putFile("courses/resources", $request->file('resource_file')->path());
            $program_resource->resource = [
                "original_name" => $request->file('resource_file')->getClientOriginalName(),
                'file_type' => $request->file('resource_file')->getMimeType(),
                'path' => $upload_file
            ];
        }

        try {
            $program_resource->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "message" => "Error: " . $th->getMessage()
            ], 422);
        }

        if ($request->wantsJson()) {
            return response(['message' => "New Resource added."], 200);
        }

        $request->session()->flash("success", "New Resource Added.");
        return redirect()->route('admin.program.courses.admin_program_course_list', [$course->program_id]);
        // store safely and than allow download only or view only.

    }

    public function update_program_resource(ProgramCourseResourceRequest $request, ProgramCourseResources $resource)
    {
        $resource->lock = ($request->lock_after_days) ? true : false;
        $resource->lock_after = $request->lock_after_days;
        $resource->resource_title = $request->resource_title;
        $resource->description = $request->resource_text;
        // $resource->program_id = $request->program;
        // $resource->program_course_id = $request->course;
        $resource->resource_type = $request->resource_type;

        // upload file if type is image or pdf.
        if ($request->resource_type == "image" || $request->resource_type == "pdf") {

            if (!$request->hasFile("resource_file")) {
                if ($request->wantsJson()) {
                    return response([
                        "message" => "Please check all the fields.",
                        "errors" => [
                            "resource_file" => ["Resource File Field is required for type" . ucfirst($request->resource_type)]
                        ]
                    ], 422);
                } else {
                    $request->session()->flash("error", "Resource File Field is required for type " . ucwords($request->resource_type));
                    return redirect()->route('admin.program.courses.admin_program_course_list', [$course->program_id]);
                }
            }

            $upload_file = Storage::putFile("courses/resources", $request->file('resource_file')->path());
            $resource->resource = [
                "original_name" => $request->file('resource_file')->getClientOriginalName(),
                'file_type' => $request->file('resource_file')->getMimeType(),
                'path' => $upload_file
            ];
        }

        try {
            $resource->save();
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->wantsJson()) {
                return response([
                    "message" => "Error: " . $th->getMessage()
                ], 422);
            }
            $request->session()->flash("error", "Unable to updated resource. Error:" . $th->getMessage());
            return back()->withInput();
        }

        if ($request->wantsJson()) {
            return response(['message' => "New Resource added."], 200);
        }

        $request->session()->flash("success", "New Resource Added.");
        return back();
        // store safely and than allow download only or view only.
    }

    public function list_resource_modal_admin(Request $request, Program $program, ProgramCourse $course)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $all_resources = $course->load(["resources"]);
            return DataTables::of($all_resources->resources)
                ->addColumn('resource_title', function ($row) {
                    return $row->resource_title;
                })
                ->addColumn('resource_type', function ($row) {
                    if ($row->resource_type == "image") {
                        return "<span><i class='zmdi zmdi-image-o'></i>Image</span>";
                    } else if ($row->resource_type == "pdf") {
                        return "<span <i class='zmdi zmdi-collection-pdf'></i>PDF</span>";
                    } else {
                        return "<span i class='zmdi zmdi-file'></i> Text </span>";
                    }
                })
                ->addColumn('total_view', function ($row) {
                    return "0";
                })
                ->addColumn("view", function ($row) {
                    // $action = "<a href='#'>Download</a>";
                    // $action .= " | ";
                    $action = "<a class='remove-resource-content' href='" . route("admin.resources.admin_delete_resource", ['file_id' => $row->id, 'file_address' => 'program_resources']) . "'>Delete Resource</a>";
                    return $action;
                })
                ->rawColumns(["view", "resource_type"])
                ->make(true);
        }
        return view("admin.programs.modal.detail_lession_resource", compact("course", "program"));
    }

    public function edit_doc_by_program(Request $request, ProgramCourseResources $course)
    {
        if ($request->ajax()) {
            return [
                "results" =>
                [["id" => "1", "text" => "program name"]]
            ];
        }
        $programs = Program::get();
        return view("admin.filemanager.resource.edit", compact("course", "programs"));
    }
}
