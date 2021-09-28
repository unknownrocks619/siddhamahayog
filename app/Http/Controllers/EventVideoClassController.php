<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventVideoClass;
use App\Models\SibirRecord;
use App\Models\VideoClassLog;
use App\Models\EventVideoAttendance;
use App\Models\UserSadhakRegistration;
// use App\Http\Policies\EventVideoClassPolicy;
use App\Models\SadhakUniqueZoomRegistration;
class EventVideoClassController extends Controller
{
    //

    public function index() {
        $this->authorize("viewAny",[EventVideoClass::class,auth()->user()]);
        
        $all_class = EventVideoClass::where('class_source','!=','video')->get();
        return view("admin.event_class.index",compact('all_class'));
    }

    public function create() {
        //event list
        $this->authorize("viewAny",[EventVideoClass::class,auth()->user()]);

        $events = SibirRecord::get();
        return view("admin.event_class.new_class_form",compact('events'));
    }

    public function store(Request $request) {
        $this->authorize("create",[EventVideoClass::class,auth()->user()]);

        // validate later 
        $manage_data = [
            "event_id" => $request->event,
            'class_start' => $request->event_start,
            'class_end' => $request->event_start,
            'is_active' => false,
            'meeting_id' => $request->meeting_id,
            'password' => $request->meeting_password,
            'class_source' => "ZOOM",
            'video_link' => $request->meeting_url
        ];
        try {
            EventVideoClass::create($manage_data);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            $request->session()->flash('status',"Oops ! Something went wrong. ". $th->getMessage());
            return back()->withInput();
        }
        $request->session()->flash('success',"New Video Class Information Added.");
        return back();
    }

    public function start(Request $request) {
            if (auth()->user() && auth()->user()->userRoles && auth()->user()->userRoles->role_name == "Admin") {
                // 
                $event_detail = EventVideoClass::findOrFail($request->class);
                $event_detail->is_active = true;
                $event_detail->save();

                // also generate 
                $class_log = VideoClassLog::where('event_video_class_id',$event_detail->id)
                                            ->where('active',true)
                                            ->first();
                if($class_log) {
                    $class_log->active = false;
                    $class_log->ended_by = auth()->id();
                    $class_log->save();
                } else{
                    $class_log = new VideoClassLog;
                    $class_log->event_video_class_id = $event_detail->id;
                    $class_log->active = true;
                    $class_log->start_time = \Carbon\Carbon::now();
                    $class_log->started_by = auth()->id();
                    $class_log->save();
                }
                return redirect()->to($event_detail->video_link);
            } else if(auth()->check()) {
                // check if user is already engaged.
                $event_detail = EventVideoClass::findOrFail(decrypt($request->class));
                // fetch event as well and check if this user has been added to this class or not.
                if( ! $event_detail->event_source ) {
                    $request->session()->flash('message','Unknown Event Source.');
                    return back();
                }

                                // check if link has been created for this user.
                $user_link = SadhakUniqueZoomRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                        ->where('sibir_record_id',$event_detail->event_id)
                                        ->where('meeting_id',$event_detail->meeting_id)
                                        ->latest()
                                        ->first();
                if ( ! $user_link )
                {
                    $request->session()->flash('message',"Your link has not been generated. Please contact Support to join link to your account.");
                    return back();
                }


                // also check if this user has subscribed.
                $registered_user = UserSadhakRegistration::where('sibir_record_id',$event_detail->event_source->id)
                                                            ->where('user_detail_id',auth()->user()->user_detail_id)
                                                            ->first();
                if (  ! $registered_user) {
                    $request->session()->flash('message',"You are not authorized to participate");
                    return back();
                    abort(403);
                }
                $active_class = VideoClassLog::where('event_video_class_id',$event_detail->id)
                                                    ->where('active',true)
                                                    ->first();
                if( ! $active_class ) {
                    $request->session()->flash('message',"Session Not Available.");
                    return back();
                    abort(403);
                }
                // now lets check attendance
                $attendance = EventVideoAttendance::where('event_class_id',$event_detail->id)
                                                    ->where('video_class_log',$active_class->id)
                                                    ->where('user_id',auth()->user()->user_detail_id)
                                                    ->where('is_active',true)
                                                    ->first();
                if($attendance) {
                    // $request->session()->flash('message','Your session is already active. To join the session ask admin to revoke your class.');
                    // return back();
                    // abort(403);
                }
                if( ! $attendance ) {
                    $attendance = new EventVideoAttendance;
                    $attendance->event_class_id = $event_detail->id;
                    $attendance->user_id = auth()->user()->user_detail_id;
                    $attendance->is_active = true;
                    $attendance->video_class_log = $active_class->id;

                    $attendance->save();
                }
                return redirect()->to($user_link->join_link);
                // return redirect()->to($event_detail->video_link);
            }
            abort(403);
    }

    public function end_class(Request $request){
        if (auth()->user()->userRoles->role_name == "Admin") {

            // 
            $event_detail = EventVideoClass::findOrFail($request->class);
            $event_detail->is_active = false;
            $event_detail->save();

            // also generate 
            $class_log = VideoClassLog::where('event_video_class_id',$event_detail->id)
                                        ->where('active',true)
                                        ->first();
            if($class_log) {
                $class_log->active = false;
                $class_log->end_time = \Carbon\Carbon::now();
                $class_log->save();
            } 
            $request->session()->flash('success','Class Ended.');
            return back();
        } 
        abort(403);
    }

    public function revoke_access(Request $request) {
        if (auth()->user()->userRoles->role_name == "Admin") {
            // 
            $get_content = EventVideoAttendance::where('event_class_id',$request->event_id)
                                                    ->where('user_id',$request->u_id)
                                                    ->where('video_class_log',$request->v_l_id)
                                                    ->where('is_active',true)
                                                    ->first();
            if ($get_content) {
                $get_content->is_active = false;
                $get_content->save();
            }
            $request->session()->flash('success',"User Revoked");
            return back();
        }
        abort(403);
    }

    public function view_active_attendance(Request $request){
        $this->authorize("viewAny",[EventVideoClass::class,auth()->user()]);
        $active_attendance = VideoClassLog::where('event_video_class_id',$request->event)
                                            ->where('active',true)
                                            ->first();
        // all attendance.
        if ($active_attendance){
            $attendances = EventVideoAttendance::where('event_class_id',$request->event)
            ->where('video_class_log',$active_attendance->id)
            ->get();
        } else {
            $attendances = [];
        }

        return view('admin.event_class.active_attendance',compact('attendances','active_attendance'));

    }

    public function view_session(Request $request, SibirRecord $event) {
        $this->authorize("viewAny",[EventVideoClass::class,auth()->user()]);
        $event_detail = EventVideoClass::where('event_id',$event->id)->first();
        $all_video_logs = VideoClassLog::where('event_video_class_id',$event_detail->id)->withCount('attendee')->latest()->get();
        return view('admin.event_class.video_class_session_list',compact('all_video_logs','event'));
    }

    public function view_session_attendance(Request $request, VideoClassLog $log_id) {
        $this->authorize('viewAny',[EventVideoClass::class,auth()->user()]);
        $attendances = EventVideoAttendance::where('video_class_log',$log_id->id)
            ->get();
        $event_class = EventVideoClass::findOrFail($log_id->event_video_class_id);
        return vieW('admin.event_class.session_attendance',compact('attendances','log_id','event_class'));
    }

    /**
     * Zonal Settings
     */

    public function zoom_seetings(){
        // $settings = 
    }

    public function add_zoom_settings(){

    }

    public function delete_zoom_settings(){

    }

    public function update_zoom_seetings(){

    }

     public function zone_session_list(Request $request){
        return view("admin.event_class.meeting-country");
     }

     public function zone_session_add(){

     }
}
