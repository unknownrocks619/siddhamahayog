<?php

namespace App\Http\Controllers\Admin\FileManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminProgramCourseLessionRequest;
use App\Models\Program;
use App\Models\ProgramChapterLession;
use App\Models\ProgramCourseResources;
use Illuminate\Http\Request;
use DataTables;

class AdminFileManagerController extends Controller
{

    public function update_video(AdminProgramCourseLessionRequest $request, ProgramChapterLession $video)
    {

        $video->lession_name = $request->lession_name;
        $video->total_duration = $request->total_video_duration;
        $video->total_credit = 0;
        $video->video_total_duration = $request->total_video_duration;
        $video->lession_date = $request->video_publish_date;
        $video->video_lock = ($request->video_lock_after) ? true : false;
        $video->lock_after = ($video->video_lock) ? $request->video_lock_after : false;
        $video->video_description = $request->description;
        $video->video_link = $request->vimeo_video_url;


        try {
            $video->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Unable to update record. Error: '. $th->getMessage(),null,[],200,url()->previous());
            //throw $th;
            // $request->session()->flash("error", "Unable to update record. Error: " . $th->getMessage());
            // return back()->withInput();
        }

        return $this->returnResponse(true,'Record Updated.',null,[],200,url()->previous());
    }

    public function update_resource()
    {
    }

    public function delete_resource(Request $request)
    {
        // $request->validate([
        //     "file_id" => "required",
        //     "file_address" => "required|in:program_course_resources,lession"
        // ]);
        // dd(ucwords($request->file_address));

        if ($request->file_address == "program_lession") {

            $resource_model = ProgramChapterLession::find($request->file_id);
        } elseif ($request->file_address == "program_resources") {

            $resource_model = ProgramCourseResources::find($request->file_id);
        }

        try {
            $resource_model->delete();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Unable to delete. Error: '. $th->getMessage(),null,[],200,url()->previous());
            //throw $th
            // $request->session()->flash('error', "Unable to delete. Error: " . $th->getMessage());
            // return back();
        }
        
        $jsCallback = $request->jscallback;
        $params = [];
        
        if ($request->sourceID) {
            $params['sourceID'] = $request->sourceID;
        }

        return $this->returnResponse(true,'Selected Resources was deleted.',$jsCallback,$params,200,url()->previous());

        // $request->session()->flash("success", "Selected Resourec deleted.");
        // return back();
    }

    /**
     * Filemanager by program
     */

    public function media_by_program(Request $request, Program $program)
    {
        if ($request->ajax()) {
            $videos_by_program = $program->program_videos;

            return view("admin.programs.videos.partials.videos-list", compact('videos_by_program'));
        }
        return view("admin.programs.videos.index", compact('program'));
    }

    public function doc_by_program(Request $request, Program $program)
    {
        if ($request->ajax()) {
            $CourseEagerLoading = $program->load(["courses"]);
            $docs = $CourseEagerLoading->courses;
            return view("admin.programs.videos.partials.docs-list", compact('docs'));
        }
        return view("admin.programs.videos.index", compact('program'));
    }
    public function edit_media_by_program(Request $request, Program $program, ProgramChapterLession $video)
    {
        if ($request->ajax()) {
            return view('admin.programs.modal.edit_lession_video', compact('program', 'video'));
        }
        return view("admin.filemanager.video.edit", compact('program', 'video'));
    }

    public function edit_doc_by_program(Request $request, ProgramCourseResources $course)
    {
        return view("admin.filemanager.resource.edit", compact("course"));
    }
}
