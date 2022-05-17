<?php

namespace App\Http\Controllers\Admin\Programs;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProgramCourseRequest;
use App\Http\Requests\Program\AdminProgramCourseLessionRequest;
use App\Models\Program;
use App\Models\ProgramChapterLession;
use App\Models\ProgramCourse;
use Illuminate\Http\Request;

use DataTables;

class AdminProgramCourseController extends Controller
{
    //

    public function index(Program $program) {
        
        $courses = ProgramCourse::latest()->where('program_id',$program->id)->paginate(20);
        return view("admin.programs.courses.index",compact("program","courses"));
    }
    
    public function create(AdminProgramCourseRequest $request,  Program $program) {

        

    }

    public function edit(Program $program) {

    }

    public function store_course(AdminProgramCourseRequest $request,Program $program) {
        $program_course = new ProgramCourse;
        $program_course->course_name = $request->course_title;
        $program_course->slug = Str::slug($request->course_title,"-");
        $program_course->total_chapters = 0;
        $program_course->program_id = $program->id;
        $program_course->description = $request->description;
        $program_course->public_visible = true;
        $program_course->lock = ($request->lock_course == "yes") ? true : false;;
        $program_course->enable_resource = ($request->lock_resources == "yes")? true : false;
        $program_course->sort = $program_course->count() + 1;
        try {
            $program_course->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("error","Error: ". $th->getMessage());
            return back()->withInput();
        }
        $request->session()->flash("success","New Course Created.");
        return back();
    }

    public function update_course(ProgramCourse $course) {

    }

    public function delete_course(ProgramCourse $course) {
        // check if this have any lession and resources.
    }

    public function create_video_modal(ProgramCourse $course){
        return view("admin.programs.modal.add_lession_to_chapter",compact('course'));
    }

    public function list_video_modal(Request $request, ProgramCourse $course) {
        if ( $request->ajax() && $request->wantsJson() ) {

            $all_lession = $course->lession;
            $datatable = DataTables::of($all_lession)
                                    ->addColumn("status",function($row){
                                        $return = "";
                                        if ($row->video_lock) {
                                            $return .= "<span class='badge badge-danger'>";
                                                $return .= "Locked";
                                            $return .= "</span>";
                                        } else {
                                            $return .= "<span class='badge badge-success'>";
                                                $return .= strtoupper($row->status);
                                            $return .= "</span>";
                                        }
                                        return $return;
                                    })
                                    ->addColumn("lession_name", function ($row) {
                                        $lession = $row->lession_name;
                                        if ($row->lession_date) {
                                            $lession .= "<br />";
                                            $lession .= "Uploaded Date: ". $row->lession_date;    
                                        }

                                        return $lession;
                                    })
                                    ->addColumn('video_link', function ($row) {
                                        return "<a href='{$row->video_link}' target='_blank'>Open</a>";
                                    })
                                    ->addColumn('total_watched',0)
                                    ->rawColumns(["status","video_link","lession_name"])
                                    ->make(true);
            return $datatable;

        }
        return view('admin.programs.modal.detail_lession_video',compact('course'));
    }

    public function store_course_lession_video(AdminProgramCourseLessionRequest $request,ProgramCourse $course) {

        $lession = new ProgramChapterLession;
        $lession->program_course_id = $course->id;
        $lession->lession_name = $request->lession_name;
        $lession->program_id = $course->program_id;
        $lession->total_duration = $request->total_video_duration;
        $lession->total_credit = 0;
        $lession->online_medium = true;
        $lession->video_total_duration = $request->total_video_duration;
        $lession->lession_date = $request->video_publish_date;
        $lession->video_lock = ($request->video_lock_after) ? true : false;
        $lession->lock_after = ($lession->video_lock) ? $request->video_lock_after : false;
        $lession->video_description = $request->description;
        $lession->video_link = $request->vimeo_video_url;

        // get video count.

        try {
            $lession->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('error',"Error: ". $th->getMessage());
            return redirect()->route('admin.program.courses.admin_program_course_list',[$course->program_id]);
        }

        $request->session()->flash("success","New Video Resource Added To " . $course->course_name );
        return redirect()->route('admin.program.courses.admin_program_course_list',[$course->program_id]);
    }
}
