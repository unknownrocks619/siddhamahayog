<?php

namespace App\Http\Controllers\Admin\Chapters;
use Illuminate\Support\Str;

use App\Models\OfflineVideo;
use App\Models\CourseChapter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\Upload;

class ChapterCourseController extends Controller
{
    use Upload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if ( ! isAdmin() ) {
            abort(404);
        }
        $chapters = CourseChapter::orderBy('sibir_record_id',"ASC")->with(["sibir_record"])->paginate(20);
        return view("admin.chapters.index",compact("chapters"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! isAdmin() ) {
            abort(404);
        }
        //
        $sibir_records = \App\Models\SibirRecord::latest()->get();
        
        return view('admin.chapters.add_chapters',compact('sibir_records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ( ! isAdmin() ) {
            abort(404);
        }

        $course_chapter = new CourseChapter;

        $get_max_order = $course_chapter->select(["sort_by"])->orderBy("sort_by","DESC")->first();
        // first let check if slug exists.
        $check_slug = $course_chapter->where("chapter_slug",Str::slug($request->chapter_name,"-"))->first();

        if ($check_slug) {
            $request->session()->flash('message',"Chapter Already Exists. Please use different chapter name.");
            return back()->withInput();
        }

        $course_chapter->sibir_record_id = $request->sibir_record_id;
        $course_chapter->chapter_name = $request->chapter_name;
        $course_chapter->chapter_slug = Str::slug($request->chapter_name,"-");
        $course_chapter->description = $request->description;
        $course_chapter->active = ($request->chapter_status == "yes") ? true : false;
        $course_chapter->locked = ($request->chapter_locked == "yes") ? true : false;
        $course_chapter->sort_by = ( ! $get_max_order) ? 1 : $get_max_order->sort_by + 1;

        try {
            $course_chapter->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message",'Error: '. $th->getMessage());
            return back()->withInput();
        }

        $request->session()->flash('success',"New chapter Creatd.");
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function show(CourseChapter $courseChapter)
    {
        //
        $get_videos = $courseChapter->videos;
        // $total_sortable = \App\Models\OfflineVideo::select(["sortable"])->get();
        $total_sortable = $get_videos->pluck("sortable");
        return view('admin.chapters.lessions.list',compact('get_videos','courseChapter','total_sortable'));
    }

    public function edit_video(OfflineVideo $video) {
        return view('admin.chapters.lessions.edit',compact('video'));
    }

    public function update_video(Request $request, OfflineVideo $video) {

        if ( ! $video->course_chapter_id ) {
            $request->validate([
                "chapter" => "required"
            ]);
        }

        if ( ! $video->total_video_time ) {
            $request->validate([
                "video_time" => "required"
            ]);
        }

        $video->video_title = $request->video_title;
        $video->description = $request->description;
        $video->course_chapter_id = ($video->course_chapter_id) ? $video->course_chapter_id : $request->chapter;
        $video->total_video_time = $request->video_time;
        $video->description = $request->description;
        try {
            $video->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message','Error: '. $th->getMessage());
            return back()->withInput();
        }

        $request->session()->flash('success',"Update Profile Updated.");
        return back();
    }

    public function add_video(CourseChapter $courseChapter) {
        return view("admin.chapters.lessions.add",compact('courseChapter'));
    }

    public function store_video(Request $request, CourseChapter $courseChapter) {
        $offline_video = new OfflineVideo;

        $offline_video->course_chapter_id = $courseChapter->id;
        $offline_video->total_video_time = $request->video_time;
        $offline_video->video_title = $request->video_title;

        $youtube  = explode("?v=",$request->youtube_link);
        $video = explode("/",$request->youtube_link);
        $offline_video->event_id = $courseChapter->sibir_record_id;

        $offline_video->full_link = $request->youtube_link;
        $offline_video->youtube_id = ($request->class_medium == "YOUTUBE") ? $youtube[1] : (($request->class_medium == "VIMEO") ? $video[3] : null);
        $offline_video->source = $request->class_medium;
        $offline_video->video_title = $request->video_title;
        $offline_video->is_active = $request->active;
        if ($request->class_medium == "UPLOAD" && $request->hasFile('upload')) {
            $offline_video->offline_video = $this->upload($request,'upload')->id;
        }
        $offline_video->description = $request->description;
        try {
            $offline_video->save();
            $courseChapter->total_lessions = $courseChapter->total_lessions+1;
            $courseChapter->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Unable to upload video link. Error: ". $th->getMessage());
            return back();
        }

        $request->session()->flash('success',"Video Link Added.");
        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseChapter $courseChapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseChapter $courseChapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseChapter $courseChapter)
    {
        //
    }
}
