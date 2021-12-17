<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SibirRecord;
use App\Models\UserSadhakRegistration;
use App\Models\UserFamilyGroup;
use App\Models\EventVideoAttendance;
use App\Models\EventVideoClass;
use App\Models\VideoClassLog;
use App\Models\EventAbsentRecord;
use App\Models\SadhakUniqueZoomRegistration;
use App\Models\ZoomSetting;
use App\Models\userDetail;
use App\Models\OfflineVideo;
use App\Models\OfflineVideoAttendance;
class PublicEventController extends Controller
{
    //

    public function single_attendance(Request $request, $event) {
        //  if ( auth()->user()->user_type !== "public") {
        //     return response([
        //         'success' => false,
        //         "message" => "Your account is not allowed to join this session."
        //     ]);
        // }
        $sibir_record = SibirRecord::find(decrypt($event));
        if ( ! $sibir_record ) {
            return response([
                "success" => false,
                'message' => "Unknown request. Entry Not found."
            ],404);
        }


        
        $verify_user = UserSadhakRegistration::where('sibir_record_id',$sibir_record->id)
                                                    ->where('user_detail_id',auth()->user()->user_detail_id)
                                                    ->first();
        if (! $verify_user ) {
            return response([
                "success" => false,
                'message' => "You are not authorized to join this session."
            ],403);
        }

        if ( $request->zone_attendance ) {
            return $this->single_zone_attendance($request);
        }

        // $verify_member = UserFamilyGroup::where("sibir_record_id",$sibir_record->id)
        //                                         ->where('member_id',auth()->user()->user_detail_id)
        //                                         ->where('status',true)
        //                                         ->where('approved',true)
        //                                         ->first();
        // if ($verify_member) {
        //     return response([
        //         "success" => false,
        //         'message' => "You are assigned in the group to join."
        //     ],403);
        // }

        $get_active_session = EventVideoClass::where('event_id',$sibir_record->id)
                                                ->where('is_active',true)
                                                ->first();
        // now let fetch current session.
        if (! $get_active_session && $request->ajax()) {
            return response([
                'success' => false,
                'message' => "Session currently unavailable."
            ]);
        } elseif ( ! $get_active_session ) {
            $request->session()->flash('message',"Session currently unavailable");
            return back();
        }
        
        $link_generated = SadhakUniqueZoomRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                                        ->where('meeting_id',$get_active_session->meeting_id)
                                                        ->where('sibir_record_id',$sibir_record->id)
                                                        ->first();
        if ( ! $link_generated ) {
            return response([
                "success" => false,
                "message" => "Your account has not been setup to attend this session."
            ]);
        }
        
        if ( $get_active_session->meeting_lock && ! $link_generated->have_joined) 
        {
            return response([
                'success' => false,
                'message' => ($get_active_session->meeting_lock_message) ? $get_active_session->meeting_lock_message : "Sorry, This meeting is locked."
            ]);
        }


        $current_session_detail = VideoClassLog::where('event_video_class_id',$get_active_session->id)
                                                ->where('active',true)
                                                ->latest()
                                                ->first();
        if (! $current_session_detail && $request->ajax()) {
            return response([
            'success' => false,
            'message' => "Session currently unavailable."
            ]);
        } elseif ( ! $current_session_detail ) {
            $request->session()->flash('message',"Session currently unavailable");
            return back();
        }

        $event_attendance = EventVideoAttendance::where('event_class_id',$get_active_session->id)
                                            ->where('video_class_log',$current_session_detail->id)
                                            ->where('user_id',auth()->user()->user_detail_id)
                                            ->where('is_active',true)
                                            ->first();

        // don't allow new user after meeting is locked.
        if ($event_attendance) {
            $event_attendance->is_active = false;
            $event_attendance->save();
        } else if( ! $event_attendance && $get_active_session->meeting_lock ) {
            // return 
        }  

        $attendance_now = [
            "event_class_id" => $get_active_session->id,
            "user_id" => auth()->user()->user_detail_id,
            "is_active" => true,
            "video_class_log" => $current_session_detail->id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        try {
            \DB::transaction( function() use ($attendance_now,$link_generated) {
                EventVideoAttendance::insert($attendance_now);
                $link_generated->joined_at = \Carbon\Carbon::now();
                $link_generated->have_joined = true;
                $link_generated->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response([
                    'success' => false,
                    "message" => "Something went wrong. Unable to join session."
                ]);
            }

            $request->session()->flash('message',"Something went wrong. Unable to join session.");
            return back();
        }

        if ( $request->ajax() ) {
            return response([
                'success' => true,
                "message"=> "Loading completed...Please click <span style='font-size:24px;'>`Join`</span> button to begin",
                'join_url' => $link_generated->join_link
            ]);
        }

    }

    protected function single_zone_attendance(Request $request) {
        // get current user country and fetch data.
        if ($request->c_id ) {
            $zoom_settings = ZoomSetting::where('country_id',$request->c_id)
                                            ->where('is_active',true)
                                            ->first();
        } else {
            $zoom_settings = ZoomSetting::where('is_active',true)
                                        ->first();
        }

        if ( ! $zoom_settings ) {
            return response([
                'success' => false,
                "message" => "Zoom Zonal Live session is currently unavailable."
            ]);
        }
        // now lets check if this users session has been created.
        $check_registration = SadhakUniqueZoomRegistration::where('sibir_record_id',$zoom_settings->sibir_record_id)
                                    ->where('meeting_id',$zoom_settings->meeting_id)
                                    ->where('user_detail_id',auth()->user()->user_detail_id)
                                    ->first();
        if ( ! $check_registration ) {
            return response([
                'success' => false,
                "message" => "Your name is not listed on attendance sheet. Please contact your authorized center for Support"
            ]);
        }

        $event_attendance = EventVideoAttendance::where('zonal_setting_id',$zoom_settings->id)
                                                ->where('meeting_id',$zoom_settings->meeting_id)
                                                ->where('user_id',auth()->user()->user_detail_id)
                                                ->where('is_active',true)
                                                ->first();

        // don't allow new user after meeting is locked.
        if ($event_attendance) {
            $event_attendance->is_active = false;
            $event_attendance->save();
        }  

        $attendance_now = [
            "event_class_id" => json_encode(["source"=>"ZoomSetting","reference"=>$zoom_settings->id]),
            "user_id" => auth()->user()->user_detail_id,
            "is_active" => true,
            "source" => "zonal",
            "zonal_setting_id" => $zoom_settings->id,
            'meeting_id' => $zoom_settings->meeting_id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        try {
            \DB::transaction( function() use ($attendance_now,$check_registration) {
                EventVideoAttendance::insert($attendance_now);
                $check_registration->joined_at = \Carbon\Carbon::now();
                $check_registration->have_joined = true;
                $check_registration->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response([
                    'success' => false,
                    "message" => "Something went wrong. Unable to join session."
                ]);
            }

            $request->session()->flash('message',"Something went wrong. Unable to join session.");
            return back();
        }
        if ( $request->ajax() ) {
            return response([
                'success' => true,
                "message"=> "Loading completed...Please click <span style='font-size:24px;'>`Start Session`</span> button to begin",
                'join_url' => $check_registration->join_link
            ]);
        }
        // check if this user have already zoned.
        
    }

    public function group_attendance(Request $request,$event){
        // if ( auth()->user()->user_type !== "public") {
        //     abort(403);
        // }

        $sibir_record = SibirRecord::find(decrypt($event));

        if ( ! $sibir_record ) {
            return response([
                "success" => false,
                'message' => "Unknown request. Entry Not found."
            ],404);
        }

        $allow_participants = true;
        $error_log = [];
        $attendance_array = [];

        if ( $request->member ) {
            foreach ($request->member as $members) {

                // $check_each_participants = userDeail::find(decrypt($members));
                // check if user is in given sibir.
                $member_id = decrypt($members);
                $verify_user = UserSadhakRegistration::where('sibir_record_id',$sibir_record->id)
                                                        ->where('user_detail_id',$member_id)
                                                        ->first();
                if (! $verify_user ) {
                    $allow_participants = false;
                    break;
                }

                $member_detail = userDetail::findOrFail($member_id);
                // if ( $member_detail->country != auth()->user()->userdetail->country ) {
                //     return response([
                //         "success" => false,
                //         "message" => "`{$member_detail->full_name()}` have different timezone. Can not join the session with this user."
                //     ]);
                // }

                // check family member
                $verify_member = UserFamilyGroup::where("sibir_record_id",$sibir_record->id)
                                                    ->where('member_id',$member_id)
                                                    ->where('status',true)
                                                    ->where('approved',true)
                                                    ->where('leader_id',auth()->user()->user_detail_id)
                                                    ->first();
                if ( ! $verify_member ) {
                    $allow_participants = false;
                    return response([
                        'success' => false,
                        "message" => "One of the member is not yet approved."
                    ]);
                    break;
                }
                $attendance_array[] = $member_id;
            }

        }
        if ( ! $allow_participants  && $request->ajax()) {
            return response([
                'success' => false,
                'message' => "One of the family member doesn't have appropirate permission to attend this session."
            ]);
        } elseif ( ! $allow_participants ) {
            $request->session()->flash('message',"One of the family member doesn't have appropirate permission to attend this session.");
            return back();
        }
        // now let's make propert attendance..
        if ($request->zone_attendance) {
            return $this->group_zonal_attendance($request,$attendance_array);
        }
        return $this->proper_attendance($request,$sibir_record,$attendance_array);
    }

    protected function group_zonal_attendance(Request $request, $user_list) {
        if ( $request->c_id) {
            $zoom_settings = ZoomSetting::where("country_id",$request->c_id)
                                        ->where('is_active',true)
                                        ->first();
        } else {
            $zoom_settings = ZoomSetting::where('country_id',auth()->user()->userdetail->country)
                                        ->where('is_active',true)
                                        ->first();
        }

        if ( ! $zoom_settings ) {
            return response([
            'success' => false,
            "message" => "Zoom Zonal Live session is currently unavailable."
            ]);
        }
        $link_generated = SadhakUniqueZoomRegistration::where('sibir_record_id',$zoom_settings->sibir_record_id)
                                                    ->where('meeting_id',$zoom_settings->meeting_id)
                                                    ->where('user_detail_id',auth()->user()->user_detail_id)
                                                ->first();
        if ( ! $link_generated ) {
            return response([
                "success" => false,
                "message" => "Your account has not been setup to attend this session."
            ]);
        }

        $attendance_now = [];
        foreach ($user_list as $member_id){

            $event_attendance = EventVideoAttendance::where('source',"zonal")
                                                ->where('user_id',$member_id)
                                                ->where('is_active',true)
                                                ->where("zonal_setting_id",$zoom_settings->id)
                                                ->where('meeting_id',$zoom_settings->meeting_id)
                                                ->first();
            if ( $event_attendance ) {
                $event_attendance->is_active = false;
                $event_attendance->save();
            }
                // make fresh entry.
                $attendance_now[] = [
                    "event_class_id" => json_encode(['source'=>'ZoomSetting','reference'=>$zoom_settings->id]),
                    "user_id" => $member_id,
                    "is_active" => true,
                    "source" => "zonal",
                    "zonal_setting_id" => $zoom_settings->id,
                    'meeting_id' => $zoom_settings->meeting_id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
        } 
        // check leader as well...
        $leader_check = EventVideoAttendance::where('source',"zonal")
                                            ->where('zonal_setting_id',$zoom_settings->id)
                                            ->where('meeting_id',$zoom_settings->meeting_id)
                                            ->where('user_id',auth()->user()->user_detail_id)
                                            ->where('is_active',true)
                                            ->first();
        

        if ( $leader_check ) {
            $leader_check->is_active = false;
            $leader_check->save();
        }

        try {
            \DB::transaction( function() use ($link_generated,$attendance_now,$zoom_settings) {
                $attendance_now[] = [
                    "event_class_id" => json_encode(["source"=>"ZoomSetting","reference"=>$zoom_settings->id]),
                    "user_id" => auth()->user()->user_detail_id,
                    "is_active" => true,
                    "source" => "zonal",
                    "zonal_setting_id" => $zoom_settings->id,
                    "meeting_id" => $zoom_settings->meeting_id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
                $link_generated->have_joined = true;
                $link_generated->joined_at =\Carbon\Carbon::now();
                $link_generated->save();
                EventVideoAttendance::insert($attendance_now);
            });
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response([
                    'success' => false,
                    "message" => "Something went wrong. Unable to join session. Error : "
                ]);
            }

            $request->session()->flash('message',"Something went wrong. Unable to join session.");
            return back();
        }
        if ( $request->ajax() ) {
            return response([
                'success' => true,
                "message"=> "Request Completed... Please wait while we redirect you to your session.",
                'join_url' => $link_generated->join_link,
            ]);
        }
    }

    protected function proper_attendance(Request $request,SibirRecord $sibir_record,$user_list = null) {

        $get_active_session = EventVideoClass::where('event_id',$sibir_record->id)
                                            ->where('is_active',true)
                                            ->first();
        // now let fetch current session.
        if (! $get_active_session && $request->ajax()) {
            return response([
                'success' => false,
                'message' => "Session currently unavailable."
            ]);
        } elseif ( ! $get_active_session ) {
            $request->session()->flash('message',"Session currently unavailable");
            return back();
        }

        $current_session_detail = VideoClassLog::where('event_video_class_id',$get_active_session->id)
                                                ->where('active',true)
                                                ->latest()
                                                ->first();
        if (! $current_session_detail && $request->ajax()) {
            return response([
                'success' => false,
                'message' => "Session currently unavailable."
            ]);
        } elseif ( ! $current_session_detail ) {
            $request->session()->flash('message',"Session currently unavailable");
            return back();
        }
        $link_generated = SadhakUniqueZoomRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                                        ->where('meeting_id',$get_active_session->meeting_id)
                                                        ->where('sibir_record_id',$sibir_record->id)
                                                        ->first();
        if ( ! $link_generated ) {
            return response([
                "success" => false,
                "message" => "Your account has not been setup to attend this session."
            ]);
        }
        
        if ( $get_active_session->meeting_lock && ! $link_generated->have_joined) 
        {
            return response([
                'success' => false,
                'message' => ($get_active_session->meeting_lock_message) ? $get_active_session->meeting_lock_message : "Sorry, This meeting is locked."
            ]);
        }
        // now lets check if this user has already checked in ...
        $attendance_now = [];
        foreach ($user_list as $member_id){
            $event_attendance = EventVideoAttendance::where('event_class_id',$get_active_session->id)
                                                ->where('video_class_log',$current_session_detail->id)
                                                ->where('user_id',$member_id)
                                                ->where('is_active',true)
                                                ->first();
            if ( $event_attendance ) {
                $event_attendance->is_active = false;
                $event_attendance->save();
            }
                // make fresh entry.
                $attendance_now[] = [
                    "event_class_id" => $get_active_session->id,
                    "user_id" => $member_id,
                    "is_active" => true,
                    "video_class_log" => $current_session_detail->id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
        } 

        // check leader as well...
        $leader_check = EventVideoAttendance::where('event_class_id',$get_active_session->id)
                                            ->where('video_class_log',$current_session_detail->id)
                                            ->where('user_id',auth()->user()->user_detail_id)
                                            ->where('is_active',true)
                                            ->first();
        
        if ( $leader_check ) {
            $leader_check->is_active = false;
            $leader_check->save();
        }

        try {
            \DB::transaction( function() use ($link_generated,$attendance_now,$get_active_session,$current_session_detail) {
                $attendance_now[] = [
                    "event_class_id" => $get_active_session->id,
                    "user_id" => auth()->user()->user_detail_id,
                    "is_active" => true,
                    "video_class_log" => $current_session_detail->id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
                $link_generated->have_joined = true;
                $link_generated->joined_at =\Carbon\Carbon::now();
                $link_generated->save();
                EventVideoAttendance::insert($attendance_now);

            });
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response([
                    'success' => false,
                    "message" => "Something went wrong. Unable to join session."
                ]);
            }

            $request->session()->flash('message',"Something went wrong. Unable to join session.");
            return back();
        }
        // Cache::store('file')->put('is_logged',"yes",3600);
        // Cache::store("file")->put("join_link",$link_generated->join_link);
        if ( $request->ajax() ) {
            return response([
                'success' => true,
                "message"=> "Request Completed... Please wait while we redirect you to your session.",
                'join_url' => $link_generated->join_link,
            ]);
        }
        
    }

    public function absent(){
        $user_sibirs = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                                ->where("sibir_record_id", '!=', null)
                                                ->with(['sibir_record'])
                                                ->get();
        // dd($user_sibirs);
        return view("public.user.absent.index",compact('user_sibirs'));
    }

    public function absent_request_form(){
        return view("public.user.absent.add");
    }

    public function store_absent_request (Request $request){

        if (! auth()->check() ) {
            abort(403);
        }

        $request->validate([
            "event" => "required",
            "nod" => 'required|numeric',
            "from_date" => "required|date_format:Y-m-d",
            "reason" =>  "required"
        ],["event.required"=>"Please select atleast one event",
            "nod.required"=>"Specify No of days you need.",
            "nod.numeric"=>"Invalid data type for No of days field.",
            ]);

        $sibir_record = SibirRecord::findOrFail(decrypt($request->event));

        // check if user is authorized to perform this action.
        $user_registration = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                                    ->where('sibir_record_id',$sibir_record->id)
                                                    ->where('is_active',true)
                                                    ->first();
        if ( ! $user_registration ) {
            $request->session()->flash('message',"You are not authorize to apply for this event.");
            return back()->withInput();
        }

        $absent_record = new EventAbsentRecord;
        $absent_record->sibir_record_id = $sibir_record->id;
        $absent_record->user_detail_id = auth()->user()->user_detail_id;
        $absent_record->absent_from = $request->from_date;

        // now let's add no. days.
        $from_date = \Carbon\Carbon::createFromFormat("Y-m-d",$request->from_date);
        $add_days = $from_date->addDays($request->nod);
        $absent_record->nod = $request->nod;
        $absent_record->absent_till = $add_days;
        $absent_record->reason = $request->reason;
        $status = "Pending";

        try {
            $absent_record->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("message","Error:" . $th->getMessage());
            return back()->withInput();
        }

        session()->flash("success","Your leave application has been submitted successfully.");
        return back();
    }

    public function absent_record(Request $request) {
        // check selected event
        if (! auth()->check() ) {
            abort (403);
        }
        $user_event = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                            ->where('sibir_record_id',decrypt($request->event))
                                            ->first();
        return view('public.user.absent.absent_record',compact("user_event"));
    }

    public function cancel_absent_form(Request $request) {
        if ( ! auth()->check() || ! $request->ajax() ) {
            abort(403);
        }
        $request->validate([
            '_tk' => "required"
        ],["_tk.required"=>"Invalid parameter"]);

        $check_form = EventAbsentRecord::where('user_detail_id',auth()->user()->user_detail_id)
                                        ->where("id",decrypt($request->_tk))
                                        ->where('status', false)
                                        ->first();
        if ( ! $check_form ) {
            return response([
                "success" => false,
                "message" => "Invalid Request."
            ]);
        }

        $check_form->status = 2;

        try {
            $check_form->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success"=>false,
                "message" => "Unable to complete your request."
            ]);
        }

        return response([
            "success" => true,
            "message" => "Your absent form has been cancelled."
        ]);
    }

    public function offline_videos(Request $request, $sibir_record = 1, $video_id = null) {
        //check authroized
        $user_registration = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)->where('sibir_record_id',$sibir_record)->first();

        if ( ! $user_registration )  {
            abort(403);
        }

        $chapters = \App\Models\CourseChapter::with(["videos"])->where('sibir_record_id',$sibir_record)->get();
        if ( $request->ajax() ) {
            return view ("public.user.offline.offline.folder",compact('chapters'));
        }

        return view("public.user.offline.folder_view",compact('chapters','video_id'));
        return view("public.user.offline.chapter_view",compact('chapters','video_id'));
        return view("public.user.offline.index");
    }

    public function filter_offline_videos(Request $request) 
    {
        $request->validate([
            "record_type" => "required",
            "sibir_record" => "required|exists:sibir_records,id"
        ]);
        $access = true;

        if ($request->record_type == "public") {
            $offline_videos = OfflineVideos::where('event_id',$request->sibir_record)
                                            ->where('is_active',true)
                                            ->where('video_type','public')
                                            ->latest()
                                            ->get();
        } elseif ($request->record_type == "protected") {
            // check if this user is registered in selected program.
            $user_register_for_program = UserSadhakRegistration::where('user_detail_id',auth()->user()->id)
                                                                ->where('sibir_record_id',$request->sibir_record)
                                                                ->with(["event_source"])
                                                                ->first();
            if ( ! $user_registration_for_program ) {
                $access = false;
            }
            $offline_videos = OfflineVideos::where('event_id',$request->sibir_record)
                                            ->where('is_active',true)
                                            ->where('video_type','protected')
                                            ->with(["event_source"])
                                            ->latest()
                                            ->get();
        }

        return view("public.user.offline.filter-result",compact("offline_videos","access"));
    }

    public function live_program(){
        return view('public.user.program.live');
    }

    public function chapter_list(Request $request) {
        $videos = OfflineVideo::select(["full_link",'source','video_title','description','total_video_time','course_chapter_id',"id"])
                                ->where('course_chapter_id',decrypt($request->__v))
                                ->where('event_id',decrypt($request->__s))
                                ->orderBy("sortable","ASC")
                                ->get();
        return view("public.user.offline.offline.chapter-view",compact("videos"));
        
    }

    public function continue_watch(Request $request) {
        $event = OfflineVideoAttendance::where('user_id',auth()->user()->user_detail_id)->latest()->first();
        
        if ( ! $event ) {
            return null;
        }

        $offlineVideo = OfflineVideo::find($event->video_id);

        if ( ! $offlineVideo ) {
            return null;
        }

        return view("public.user.offline.offline.continue",compact("offlineVideo","event"));
    }
}
