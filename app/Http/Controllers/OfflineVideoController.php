<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfflineVideo;
use App\Models\SibirRecord;
use App\Models\OfflineVideoAttendance;
use App\Traits\Upload;
class OfflineVideoController extends Controller
{
    use Upload;
    //
    public function index() {
        $offline_video = OfflineVideo::withCount('video_attendance')->where('course_chapter_id' ,null)->get();
        return view('admin.event_class.video_list',compact('offline_video'));
    }

    public function create() {
        //event list
        $this->authorize("viewAny",[EventVideoClass::class,auth()->user()]);

        $events = SibirRecord::get();
        return view("admin.event_class.offline-video.add_video",compact('events'));
    }

    public function store(Request $request) {
        // $this->authorize("viewAny",[EventVideoClass::class,auth()->user()]);
        $youtube  = explode("?v=",$request->youtube_link);
        $video = explode("/",$request->youtube_link);
        $offline_video = new OfflineVideo;
        $offline_video->event_id = $request->event;

        $offline_video->full_link = $request->youtube_link;
        $offline_video->youtube_id = ($request->class_medium == "YOUTUBE") ? $youtube[1] : (($request->class_medium == "VIMEO") ? $video[3] : null);
        $offline_video->source = $request->class_medium;
        $offline_video->video_title = $request->video_title;

        $offline_video->is_active = $request->active;
        if ($request->class_medium == "UPLOAD" && $request->hasFile('upload')) {
            $offline_video->offline_video = $this->upload($request,'upload')->id;
        }
        try {
            $offline_video->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Unable to upload video link. Error: ". $th->getMessage());
            return back();
        }

        $request->session()->flash('success',"Video Link Added.");
        return back();
    }

    public function update_status(Request $request,OfflineVideo $video) {

        $video->is_active = !$video->is_active;
        try {
            $video->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Unable to change status. Error: ".$th->getMessage());
            return back();
        }
        $request->session()->flash('success',"Status Change Successfully");
        return back();


    }

    public function attendance_list(OfflineVideo $video){
        $attendances = OfflineVideoAttendance::where('video_id',$video->id)->latest()->get();
        return view("admin.event_class.offline-video.attendances",compact('attendances','video'));
    }

    public function public_offline_attendance(Request $request) {
        if (! $request->ajax()) {
            abort(403);
        }
        $attendance = OfflineVideoAttendance::findOrFail(decrypt($request->a_id));
        $attendance->end_time = \Carbon\Carbon::now();

        try {
            $attendance->save();
            // now let's put it on watch
            $time_tracker = new \App\Models\OfflineVideoTimeTracker;
            $time_tracker->attendance_id = $attendance->id;
            $time_tracker->start_time = $attendance->start_time;
            $time_tracker->end_time = $attendance->end_time;
            $time_tracker->ip_ = $request->ip();

            $time_tracker->save();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return response(["success"=>false]);
        }

        return response(['success'=>true]);
    }
}
