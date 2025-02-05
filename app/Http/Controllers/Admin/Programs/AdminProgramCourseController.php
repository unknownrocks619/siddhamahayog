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
use Illuminate\Support\Facades\DB;

class AdminProgramCourseController extends Controller
{
    //

    public function index(Program $program)
    {

        $courses = ProgramCourse::where('program_id', $program->id)->orderBy('sort', 'asc')->get();
        return view("admin.programs.courses.index", compact("program", "courses"));
    }

    public function create(AdminProgramCourseRequest $request,  Program $program)
    {
    }

    public function edit(Request $request, ProgramCourse $course)
    {
        if ($request->ajax()) {
            return view('admin.programs.modal.edit_main_course', compact('course'));
        }
    }

    public function store_course(AdminProgramCourseRequest $request, Program $program)
    {
        $program_course = new ProgramCourse;
        $program_course->course_name = $request->course_title;
        $program_course->slug = Str::slug($request->course_title, "-");
        $program_course->total_chapters = 0;
        $program_course->program_id = $program->id;
        $program_course->description = $request->description;
        $program_course->public_visible = true;
        $program_course->lock = ($request->lock_course == "yes") ? true : false;;
        $program_course->enable_resource = ($request->lock_resources == "yes") ? true : false;
        $program_course->sort = $program_course->count() + 1;
        try {
            $program_course->save();
        } catch (\Throwable $th) {
            return $this->json(false,'Unable to create new course.',null,['Error: '. $th->getMessage()]);
            //throw $th;
//            session()->flash("error", "Error: " . $th->getMessage());
//            return back()->withInput();
        }

        return $this->json(true,'New Course Created.','reload');
        session()->flash("success", "New Course Created.");
        return back();
    }

    public function update_course(Request $request, ProgramCourse $course)
    {
        $course->course_name = $request->course_title;
        $course->slug = Str::slug($request->course_title, "-");
        $course->description = $request->description;
        $course->lock = ($request->lock_course == "yes") ? true : false;;
        $course->enable_resource = ($request->lock_resources == "yes") ? true : false;
        try {
            $course->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Error: " . $th->getMessage());
            return back()->withInput();
        }
        return $this->returnResponse(true,'New Course Created','reload');
        // session()->flash("success", "New Course Created.");
        // return back();
    }

    public function delete_course(ProgramCourse $course)
    {
        dd('hello');
        // check if this have any lession and resources
        try {
            DB::transaction(function () use ($course) {
                $course->videoWatchHistory()->delete();
                $course->resources()->delete();
                $course->lession()->delete();
                $course->delete();
            });
        } catch (\Throwable $th) {
            return $this->json(false,'Error: '. $th->getMessage());
            //throw $th;
//            session()->flash('error', 'Unable to remove Course. Error: ' . $th->getMessage());
//            return back();
        }
        return $this->json(true,'Course removed.','reload');
        return back();
    }

    public function create_video_modal(ProgramCourse $course)
    {
        return view("admin.programs.modal.add_lession_to_chapter", compact('course'));
    }

    public function list_video_modal(Request $request, Program $program, ProgramCourse $course)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $all_lession = $course->lession()->orderBy('sort', 'asc')->get();

            $datatable = DataTables::of($all_lession)
                ->setRowData(['data-order' =>  fn ($row) => $row->getKey()])
                ->setRowId(function ($row) {
                    $row->getKey();
                })
                ->setRowClass(function ($row) {
                    return 'sortable-row';
                })
                ->setRowAttr(['data-order' => fn ($row) => $row->getKey()])
                ->addIndexColumn()
                ->addColumn('darg_icon', function () {
                    return "<button class='btn btn-sm btn-info'><i class='zmdi zmdi-arrows'></i></button>";
                })
                ->addColumn("status", function ($row) {
                    $return = "";
                    if ($row->video_lock) {
                        $return .= "<span class='badge bg-label-danger'>";
                        $return .= "Locked";
                        $return .= "</span>";
                    } else {
                        $return .= "<span class='badge bg-label-success'>";
                        $return .= strtoupper($row->status);
                        $return .= "</span>";
                    }
                    return $return;
                })
                ->addColumn("lession_name", function ($row) {
                    $lession = $row->lession_name;
                    return $lession;
                })
                ->addColumn('uploaded_date', fn ($row) => "<span class='text-primary'>".$row->lession_date."</span>")
                ->addColumn('video_link', function ($row) {
                    return "<a href='{$row->video_link}' target='_blank'>Open</a>";
                })
                ->addColumn('action', function ($row) use ($program,$course) {
                    $return  = "";

                    $return .= "<a href='" . route('admin.videos.admin_edit_video_by_program', [$program->getKey(), $row->getKey()]) . "' data-target='#addNewLession' data-toggle='modal' class='btn btn-info mx-2 edit-video-link'>";
                    $return .= '<i class="fas fa-pencil"></i>';
                    $return .= "</a>";

                    $return .= "<button data-method='get' data-action='" . route("admin.resources.admin_delete_resource", ['file_id' => $row->id, 'file_address' => 'program_lession','jscallback' => 'ajaxDataTableReload','sourceID' => 'lession_ajax_'.$course->getKey()]) . "' class='btn btn-danger data-confirm'>";
                    $return .= '<i class="fas fa-trash"></i>';
                    $return .= "</button>";
                    return $return;
                })
                ->rawColumns(["darg_icon", "status", "video_link", "lession_name", 'action',"uploaded_date"])
                ->make(true);
            return $datatable;
        }
        return view('admin.programs.modal.detail_lession_video', compact('course', 'program'));
    }

    public function store_course_lession_video(AdminProgramCourseLessionRequest $request, ProgramCourse $course)
    {

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
        $currentMax = ProgramChapterLession::where('program_course_id', $course->getKey())->get()->max('sort');
        $lession->sort = ($currentMax == null) ? 0 : $currentMax + 1;
        // get video count.

        try {
            $lession->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error: " . $th->getMessage());
            return redirect()->route('admin.program.courses.admin_program_course_list', [$course->program_id]);
        }

        session()->flash("success", "New Video Resource Added To " . $course->course_name);
        return redirect()->route('admin.program.courses.admin_program_course_list', [$course->program_id]);
    }

    public function re_order_course(Request $request, Program $program)
    {
        $courseOrder = $request->post('sortableID');

        foreach ($courseOrder as $key => $programID) {
            $programCourse = ProgramCourse::where('program_id', $program->getKey())
                ->where('id', $programID)
                ->first();
            $programCourse->sort = $key;
            $programCourse->save();
        }
    }

    public function re_order_lession(Request $request, Program $program, ProgramCourse $course)
    {
        $courseOrder = $request->post('sortableID');

        foreach ($courseOrder as $key => $courseID) {
            $programCourse = ProgramChapterLession::where('program_id', $program->getKey())
                ->where('program_course_id', $course->getKey())
                ->where('id', $courseID)
                ->first();
            $programCourse->sort = $key;
            $programCourse->save();
        }
    }
}
