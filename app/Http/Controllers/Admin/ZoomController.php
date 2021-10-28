<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZoomSetting;
use App\Models\UserSadhakRegistration;
use App\Models\EventCountry;
use App\Models\userDetail;
use App\Models\userLogin;
use App\Models\SadhakUniqueZoomRegistration;
use App\Models\EventVideoClass;
use App\Models\VideoClassLog;

class ZoomController extends Controller
{
    //
    public function settings() {
        if (isAdmin() ) {
            $settings = ZoomSetting::with(["country"])->get(); 
            // dd($settings);
            return view('admin.zoom.settings',compact('settings'));    
        }
        if (isCenter()) {
            $settings = ZoomSetting::with(["country"])
                        ->where('is_global',false)
                        ->where('country_id',auth()->user()->userdetail->country)->get(); 
            return view("centers.zoom.settings",compact('settings'));
        }
        abort(404);
    }

    public function create_settings() {
        return view("admin.zoom.zoom-account");
    }

    public function store_zoom_settings(Request $request){
        if ( ! isAdmin() ) {
            abort(403);
        }
        $request->validate([
            "country" => "required",
            "zoom_username" => "required|email",
            "password" => "required",
            "jwt_token" => "required"
        ]);

        // dd($request->all());
        $start_time = date("Y-m-dTh:i:s",strtotime($request->date_time));
        $zoom_settings = new ZoomSetting;
        $zoom_settings->country_id = $request->country;
        $zoom_settings->username = $request->zoom_username;
        $zoom_settings->password = \Hash::make($request->password);
        $zoom_settings->start_time = $start_time;
        $zoom_settings->timezone = $request->timezone;
        $zoom_settings->is_global = false;
        $zoom_settings->signature = $request->jwt_token;
        $zoom_settings->sibir_record_id = $request->sibir;
        try {
            $zoom_settings->save();
        } catch (\Throwable $th) {
            $request->session()->flash('message',"Error: " . $th->getMessage());
            return back();
        }
        
        $request->session()->flash('success',"Zoom Account Created.");
        return back();
    }

    public function create_zonal_meeting(Request $request, $country) {
        
        // fetch jwt token for meeting.
        $meeting_setting = ZoomSetting::where('country_id',$country)->firstOrFail();
        
        // $signature = $meeting_setting
            $curl = curl_init();
            $time = date("h:i:s",strtotime($meeting_setting->start_time));
            $meeting_data = json_encode([
                "type" => 2,
                "topic" =>$meeting_setting->sibir->sibir_title . " Zone " . address($country,"country"),
                "start_time" => date('Y-m-dT'.$time),
                "timezone" => $meeting_setting->timezone,
                "duration" => 300,
                "settings" => [
                                "approval_type"=>0,
                                "allow_multiple_devices"=>0,
                                "show_share_button"=>0,
                                "registrants_confirmation_email"=>false,
                                "auto_recording" => "cloud"],
                "language_interpretation" => [
                            "show_share_button"=>0,
                            "allow_multiple_devices"=>0,
                ]
            ]);
            // dd($meeting_data);
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/{$meeting_setting->username}/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $meeting_data,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$meeting_setting->signature}",
                "content-type: application/json"
            ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ( $err ) {
                dd($err);
            }
            // dd($meeting_setting->signature);
            $zoom_response = json_decode($response);
            $required_params = [
                "meeting_id" => $zoom_response->id,
                "is_used" => false,
                "admin_start_url" => $zoom_response->start_url,
            ];

            $meeting_setting->meeting_id = $zoom_response->id;
            $meeting_setting->is_used = false;
            $meeting_setting->admin_start_url = $zoom_response->start_url;

            try {
                $meeting_setting->save();
            } catch (\Throwable $th) {
                $request->session("message","Error: " . $th->getMessage());
                return back();
            }
            $request->session()->flash('success',"Meeting Created.");
            return back();
    }

    public function create_global_meeting(Request $request) {
        if (! isAdmin() ) {
            abort(403);
        }
        $time = date("h:i:s");

        // fetch jwt token for meeting.
        $meeting_setting = ZoomSetting::where('is_global',true)->firstOrFail();
        $meeting_configuration = [
            "type" => 2,
            "topic" => $meeting_setting->sibir->sibir_title . " Global ",
            "start_time" => date('Y-m-dT'.$time),
            "timezone" => $meeting_setting->timezone,
            "duration" => 300,
            "settings" => [
                            "approval_type"=>0,
                            "allow_multiple_devices"=>0,
                            "show_share_button"=>0,
                            "registrants_confirmation_email"=>false,
                            "auto_recording" => "cloud",
                            "registrants_confirmation_email" => false
                        ],
            "language_interpretation" => [
                        "show_share_button"=>0,
                        "allow_multiple_devices"=>0,
            ]
        ];
        $zoom_meeting_response = create_zoom_meeting($meeting_setting->username,$meeting_setting->signature,$meeting_configuration);
        if ($zoom_meeting_response) {
            // now let's save this new meeting in database.
            $response_to_settings = [
                "meeting_id" => $zoom_meeting_response->id,
                'admin_start_url' => $zoom_meeting_response->start_url,
                "is_used" => false,
            ];
            $meeting_setting->meeting_id = $zoom_meeting_response->id;
            $meeting_setting->admin_start_url = $zoom_meeting_response->start_url;
            $meeting_setting->is_used = false;
            /**
             * Back Support 
             * v 1.0
             */
            $getCurrentRecord = EventVideoClass::latest()->first();            
            // set new record.
            $place_new_record = [
                "event_id" => $meeting_setting->sibir_record_id,
                "class_start" => date("Y-m-dT7:30"),
                "class_end" => \Carbon\Carbon::now(),
                "is_active" => false,
                "meeting_id" => $zoom_meeting_response->id,
                "password" => $zoom_meeting_response->id,
                "video_link" => $zoom_meeting_response->join_url,
                "class_source" => "ZOOM"
            ];

            try {
                //code...
                $meeting_setting->save();
                $getCurrentRecord->delete();
                EventVideoClass::create($place_new_record);
            } catch (\Throwable $th) {
                //throw $th;
                $request->session()->flash('message',"Unable to create Meeting. Error: ". $th->getMessage());
                return back();
            }
        }
        $request->session()->flash('success',"Meeting Created.");
        return back();
    }

    public function register_participants(Request $request, $zoom){

        // get all users by 
        $meeting_setting = ZoomSetting::findOrFail($zoom);

        // get all users who registered in this event
        $meeting_exists = meeting_exists($meeting_setting->meeting_id,$meeting_setting->signature);
        if ( isset ($meeting_exists->code) && $meeting_exists->code == 3001) {
            $meeting_setting->is_used = true;
            $meeting_setting->save();
            $request->session()->flash('message',"Meeting expired. Please register your meeting validity.");
            return back();
        }

        if ($request->user) {
            $user_detail = userDetail::find($request->user);
            if (! $user_detail ) {
                $request->session()->flash('message',"Invalid User Detail.");
                return back();
            }
            $first_name = ($user_detail->middle_name) ? $user_detail->first_name . " ". $user_detail->middle_name : $user_detail->first_name;
            $user_data = [
                "first_name" => ucwords(strtolower($first_name)),
                "last_name" => ucwords(strtolower($user_detail->last_name)),
                "email" => "{$user_detail->first_name}_test_{$user_detail->id}@gmail.com"
            ];

            $zoom_response = zoom_registration_link($user_data,$meeting_setting->meeting_id,$meeting_setting->signature);
                if ($zoom_response) {
                    $sadhak_registration = new SadhakUniqueZoomRegistration;
                    $sadhak_registration->join_link = $zoom_response->join_url;
                    $sadhak_registration->registration_id = $zoom_response->registrant_id;
                    $sadhak_registration->user_detail_id = $user_detail->id;
                    $sadhak_registration->have_joined = false;
                    $sadhak_registration->sibir_record_id = $meeting_setting->sibir_record_id;
                    $sadhak_registration->meeting_id = $meeting_setting->meeting_id;

                    try {
                        $sadhak_registration->save();
                    } catch (\Throwable $th) {
                        //throw $th;
                        $request->session()->flash('message',"Unable to register participants. Error: ". $th->getMessage());
                        return back();
                    }

                    $request->session()->flash("success","`{$user_detail->full_name()}` registered to current meeting.");
                    return back();
                }
        }


        // along with the users whose country code matches this list.
        if( $request->merge_to && $request->merge_country){
            $meeting_setting->country_id = $request->merge_country;
        }
        // $user_detail = userDetail::where('country',$meeting_setting->country_id)->get();
        $register_participants = [];
        // get registration 
        $get_registered_user = UserSadhakRegistration::where('sibir_record_id',$meeting_setting->sibir_record_id)
                            ->with(['userDetail'=>function($query) use ($meeting_setting){
                                return $query->where('country',$meeting_setting->country_id);
                            }])->get();
        $nextPage = 1;
        foreach ($get_registered_user as $registered) {
            
            if ($registered->userDetail && $registered->sibir_record_id) {
                // dd($registered);
                // alllowed
                $innerArray = [];
                $first_name = ($registered->userDetail->middle_name) ? $registered->userDetail->first_name. " ".$registered->userDetail->middle_name : $registered->userDetail->first_name;

                // $register_name = ($registered->userDetail->middle_name) ? $registered->first_name . " " . $registered->middle_name : $registered->first_name; 
                $user_data = [
                    "first_name" => ucwords(strtolower($first_name)),
                    "last_name" => ucwords(strtolower($registered->userDetail->last_name)),
                    "email" => "{$registered->userDetail->first_name}_test_{$registered->userDetail->user_detail_id}@gmail.com"
                ];
                $zoom_response = zoom_registration_link($user_data,$meeting_setting->meeting_id,$meeting_setting->signature);
                if ($zoom_response) {
                    $innerArray["join_link"] = $zoom_response->join_url;
                    $innerArray["registration_id"] = $zoom_response->registrant_id;    
                    $innerArray["user_detail_id"] = $registered->userDetail->id;
                    $innerArray["have_joined"] = false;
                    $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
                    $innerArray["meeting_id"] = $meeting_setting->meeting_id;
                    $innerArray["created_at"] = \Carbon\Carbon::now();
                    $innerArray["updated_at"] = \Carbon\Carbon::now();
                    $register_participants[] = $innerArray;
                }
            }
        }
        $binod_giri = [
            "first_name" => "Ram",
            "last_name" => "Das (B)",
            "email" => "_guest_89_@siddhamahayog.org",
        ];
        $binod_zoom_link = zoom_registration_link($binod_giri,$meeting_setting->meeting_id,$meeting_setting->signature);
        if ($zoom_response) {
            $innerArray = [];
            $innerArray["join_link"] = $binod_zoom_link->join_url;
            $innerArray["registration_id"] = $binod_zoom_link->registrant_id;    
            $innerArray["user_detail_id"] = 89;
            $innerArray["have_joined"] = false;
            $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
            $innerArray["meeting_id"] = $meeting_setting->meeting_id;
            $innerArray["created_at"] = \Carbon\Carbon::now();
            $innerArray["updated_at"] = \Carbon\Carbon::now();
            $register_participants[] = $innerArray;
        };

        $prakash_gauli = [
            "first_name" => "Ram",
            "last_name" => "Das",
            "email" => "_guest_114@siddhamahayog.org"
        ];
        $prakash_zoom_link = zoom_registration_link($prakash_gauli,$meeting_setting->meeting_id,$meeting_setting->signature);
        if ($zoom_response) {
            $innerArray = [];
            $innerArray["join_link"] = $prakash_zoom_link->join_url;
            $innerArray["registration_id"] = $prakash_zoom_link->registrant_id;    
            $innerArray["user_detail_id"] = 114;
            $innerArray["have_joined"] = false;
            $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
            $innerArray["meeting_id"] = $meeting_setting->meeting_id;
            $innerArray["created_at"] = \Carbon\Carbon::now();
            $innerArray["updated_at"] = \Carbon\Carbon::now();
            $register_participants[] = $innerArray;
        };

        $prashant_join = [
            "first_name" => "Ram Das",
            "last_name" => "(C)",
            "email" => "_guest_98_@siddhamahayog.org",
        ];
        $prashant_join_link = zoom_registration_link($prashant_join,$meeting_setting->meeting_id,$meeting_setting->signature);
        if ($zoom_response) {
            $innerArray = [];
            $innerArray["join_link"] = $prashant_join_link->join_url;
            $innerArray["registration_id"] = $prashant_join_link->registrant_id;    
            $innerArray["user_detail_id"] = 98;
            $innerArray["have_joined"] = false;
            $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
            $innerArray["meeting_id"] = $meeting_setting->meeting_id;
            $innerArray["created_at"] = \Carbon\Carbon::now();
            $innerArray["updated_at"] = \Carbon\Carbon::now();
            $register_participants[] = $innerArray;
        };
        $gurudev_join = [
            "first_name" => "Jagadguru Mahayogi",
            "last_name" => "Siddhababa",
            "email" => "_guest_1300_@siddhamahayog.org"
        ];
        $gurudev_join_link =  zoom_registration_link($gurudev_join,$meeting_setting->meeting_id,$meeting_setting->signature);
        if ($zoom_response) {
            $innerArray = [];
            $innerArray["join_link"] = $gurudev_join_link->join_url;
            $innerArray["registration_id"] = $gurudev_join_link->registrant_id;    
            $innerArray["user_detail_id"] = 1300;
            $innerArray["have_joined"] = false;
            $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
            $innerArray["meeting_id"] = $meeting_setting->meeting_id;
            $innerArray["created_at"] = \Carbon\Carbon::now();
            $innerArray["updated_at"] = \Carbon\Carbon::now();
            $register_participants[] = $innerArray;
        };
        
        $banshi_join = [
            "first_name" => "Ram",
            "last_name" => "Das(D)",
            "email" => "_guest_91_@siddhamahayog.org"
        ];
        $banshi_join_link =  zoom_registration_link($banshi_join,$meeting_setting->meeting_id,$meeting_setting->signature);
        if ($zoom_response) {
            $innerArray = [];
            $innerArray["join_link"] = $banshi_join_link->join_url;
            $innerArray["registration_id"] = $banshi_join_link->registrant_id;    
            $innerArray["user_detail_id"] = 91;
            $innerArray["have_joined"] = false;
            $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
            $innerArray["meeting_id"] = $meeting_setting->meeting_id;
            $innerArray["created_at"] = \Carbon\Carbon::now();
            $innerArray["updated_at"] = \Carbon\Carbon::now();
            $register_participants[] = $innerArray;
        };
        $shipa_dee = [
            "first_name" => "Ram",
            "last_name" => "Das (E)",
            "email" => "_guest_1101_@siddhamahayog.org"
        ];
        $shipa_dee_link = zoom_registration_link($shipa_dee,$meeting_setting->meeting_id,$meeting_setting->signature);
            if ($zoom_response) {
                $innerArray = [];
                $innerArray["join_link"] = $shipa_dee_link->join_url;
                $innerArray["registration_id"] = $shipa_dee_link->registrant_id;    
                $innerArray["user_detail_id"] = 1101;
                $innerArray["have_joined"] = false;
                $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
                $innerArray["meeting_id"] = $meeting_setting->meeting_id;
                $innerArray["created_at"] = \Carbon\Carbon::now();
                $innerArray["updated_at"] = \Carbon\Carbon::now();
                $register_participants[] = $innerArray;
            }
            
        $ananda_dee = [
            "first_name" => "Ram",
            "last_name" => "Das (F)",
            "email" => "_guest_1258_@siddhamahayog.org"
        ];
        $ananda_dee_link = zoom_registration_link($ananda_dee,$meeting_setting->meeting_id,$meeting_setting->signature);
            if ($zoom_response) {
                $innerArray = [];
                $innerArray["join_link"] = $ananda_dee_link->join_url;
                $innerArray["registration_id"] = $ananda_dee_link->registrant_id;    
                $innerArray["user_detail_id"] = 1258;
                $innerArray["have_joined"] = false;
                $innerArray["sibir_record_id"] = $meeting_setting->sibir_record_id;
                $innerArray["meeting_id"] = $meeting_setting->meeting_id;
                $innerArray["created_at"] = \Carbon\Carbon::now();
                $innerArray["updated_at"] = \Carbon\Carbon::now();
                $register_participants[] = $innerArray;
            }
        try {
            SadhakUniqueZoomRegistration::insert($register_participants);
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Error: ". $th->getMessage());
            return back();
        }
        /**
         * Register authorized user.
         */

         $all_access  = userDetail::where(function($query) {
             return $query->where("user_type","supervisor")
                            ->orWhere('user_type',"admin");
         })->get();
         //
         
        $request->session()->flash('success',"Participants Registered Successfully.");
        return back();
    }

    public function revoke_access(Request $request, ZoomSetting $zoom) {
        $sadhak = SadhakUniqueZoomRegistration::where('user_detail_id',$request->user)
                                                ->where('meeting_id',$zoom->meeting_id)
                                                ->where("sibir_record_id",$zoom->sibir_record_id)
                                                ->latest()
                                                ->first();
        if ( ! $sadhak ) {
            $request->session()->flash('message',"User Not Found.");
            return back();
        }

        try {
            $sadhak->delete();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Unable to revoke access. Error: " . $th->getMessage());
            return back();
        }
        // also remove user from current zoom meeting.
        // if ($zoom->is_active) {
        //     //
        //     zoom_revoke_user($zoom->meeting_id,["action"=>'cancel',"registrants"=>[
        //         "id" => $sadhak->registration_id,
        //         "email" => ( ! $zoom->is_global) ? "zone_".$zoom->country_id."_test_".$sadhak->user_detail_id."@gmail.com" : "_test_".$sadhak->user_detail_id."@gmail.com"
        //     ]],$zoom->signature);
        // }
        $request->session()->flash('success',"User Revoked From joining.");
        return back();
    }

    public function start_zonal_session(Request $request, $zoom) {
        if ( ! auth()->user()->user_type == "center") {
            abort(404);
        }

        $zoom_setting = ZoomSetting::findOrFail($zoom);
        if ( $request->type != "rejoin" && $zoom_setting->is_used) {
            $request->session()->flash('message',"This meeting has already been used.");
            return back();
        }

        if ( $zoom_setting->is_global ) {
            $request->session()->flash('message',"You are not authorized to access this meeting.");
            return back();

        }

        try {
            \DB::transaction(function() use ($zoom_setting) {
                $zoom_setting->is_used = true;
                $zoom_setting->is_active = true;
                // $zoom_setting->meeting_id = null;
                $zoom_setting->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Error: Unable to start zoom session.");
            return back();
        }

        return redirect()->to($zoom_setting->admin_start_url);
    }

    public function end_zonal_session(Request $request, ZoomSetting $zoom) {
        if ( ! auth()->user()->user_type == "center") {
            abort(404);
        }

        $zoom_setting = $zoom;

        try {
            $zoom_setting->is_active = false;
            $zoom_setting->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Error: Unable to end this session.");
            return back();
        }

        $request->session()->flash("success","Session Ended.");
        return back();
    }

    public function start_global_session(Request $request, ZoomSetting $zoom) {
        if ( ! auth()->user()->user_type == "admin") {
            abort(404);
        }

        $zoom_setting = $zoom;
        if ($zoom_setting->is_used) {
            $request->session()->flash('message',"This meeting has already been used.");
            return back();
        }

        if ( ! $zoom_setting->is_global ) {
            $request->session()->flash('message',"You are not authorized to access this meeting.");
            return back();

        }

        /**
         * support v.1.0
         */
        $get_event_class = EventVideoClass::where('meeting_id',$zoom->meeting_id)
                                            ->where('event_id',$zoom->sibir_record_id)
                                            ->latest()
                                            ->first();
        if ( $get_event_class ) {
            $get_event_class->is_active = true;
            $get_event_class->save();
             // also generate 
             $class_log = VideoClassLog::where('event_video_class_id',$get_event_class->id)
                                        ->where('active',true)
                                        ->first();
            if($class_log) {
                $class_log->active = false;
                $class_log->ended_by = auth()->id();
                $class_log->save();
            } else{
                $class_log = new VideoClassLog;
                $class_log->event_video_class_id = $get_event_class->id;
                $class_log->active = true;
                $class_log->start_time = \Carbon\Carbon::now();
                $class_log->started_by = auth()->id();
                $class_log->save();
            }
        }
        try {
            \DB::transaction(function() use ($zoom_setting) {
                $zoom_setting->is_used = true;
                $zoom_setting->is_active = true;
                // $zoom_setting->meeting_id = null;
                $zoom_setting->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("message","Error: Unable to start zoom session.");
            return back();
        }
        return redirect()->to($zoom_setting->admin_start_url);
    }
    public function end_global_session(Request $request, ZoomSetting $zoom) {
        if ( ! auth()->user()->user_type == "admin") {
            abort(404);
        }

        $zoom_setting = $zoom;

        try {
            $zoom_setting->is_active = false;
            $zoom_setting->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Error: Unable to end this session.");
            return back();
        }

        /**
         * Support for 
         * V 1.0 
         * */
        $event_detail = EventVideoClass::where("event_id",$zoom->sibir_record_id)
                                        ->where("is_active",true)
                                        ->where("meeting_id",$zoom->meeting_id)
                                        ->latest()
                                        ->first();
        if ( $event_detail ) {
            $event_detail->is_active = false;
            $event_detail->save();

            // also generate 
            $class_log = VideoClassLog::where('event_video_class_id',$event_detail->id)
                                    ->where('active',true)
                                    ->latest()
                                    ->first();
            if($class_log) {
                $class_log->active = false;
                $class_log->end_time = \Carbon\Carbon::now();
                $class_log->save();
            } 
        }

        $request->session()->flash("success","Session Ended.");
        return back();
    }
    public function display_participants(Request $request, ZoomSetting $zoom) {
        if (isAdmin()):
            // $participants = SadhakUniqueZoomRegistration::where('sibir_record_id',$zoom->sibir_record_id)
            //                 ->where('meeting_id',$zoom->meeting_id)
            //                 ->with(["user","sibir"])
            //                 ->paginate(10);
            
            // $participants = SadhakUniqueZoomRegistration::where('meeting_id',$zoom->meeting_id)
            //                                             ->with(["user"=>function(){
            //                                             }])
            //                                             ->get();
            // country total available users.
            if ($zoom->is_global) {
                // count all sadhak registered in this program
                $total_sadhak = UserSadhakRegistration::where('sibir_record_id',$zoom->sibir_record_id)->count();
            } else{
                $total_sadhak = UserDetail::where('country',$zoom->country_id)->count();
            }

            return view("admin.zoom.meeting_participants",compact("total_sadhak","zoom"));
        elseif(isCenter()):
            $total_sadhak = UserDetail::where('country',$zoom->country_id)->count();
            return view("centers.zoom.meeting_participants",compact("total_sadhak","zoom"));

        endif;
    }

    public function global_sadhak_register(Request $request, ZoomSetting $zoom) {
        
        // let's begin registration process.
        if ($request->user) {
            $user_id = $request->user;
            $user_detail = userDetail::findOrFail($user_id);
            $user_login = userLogin::where('user_detail_id',$user_detail->id)->first();

            $data = [
                "first_name" => $user_detail->first_name,
                'last_name' => ($user_detail->last_name) ? $user_detail->last_name : ".",
                "email" => ($user_login->email) ? $user_login->email : "noemail{$user_detail->id}@siddhamahayog.com"
            ];
            $to_object = zoom_registration_link($data,$zoom->meeting_id,$zoom->signature);
            if ( ! $to_object ){
                return response([
                    "success" => false,
                    'message' => "Unable to Generate Link for selected User.",
                    "info" => $to_object
                ]);
            }

            $zoom_link_set = new  SadhakUniqueZoomRegistration;
            $zoom_link_set->join_link = $to_object->join_url;
            $zoom_link_set->registration_id = $to_object->registrant_id;
            $zoom_link_set->user_detail_id = $user_detail->id;
            $zoom_link_set->have_joined = false;
            $zoom_link_set->joined_at = false;
            $zoom_link_set->sibir_record_id = $zoom->sibir_record_id;
            $zoom_link_set->meeting_id = $zoom->meeting_id;
            try {
                $zoom_link_set->save();
            } catch (\Throwable $th) {
                //throw $th;
                return response([
                    "success" => false,
                    "message" => "Error Generating Link. " . $th->getMessage(),
                    "error" => $th
                ]);
            }
            return response([
                'success' => true,
                'message' => "Registration completed for `". $user_detail->full_name() . "`" 
            ]);
        }

        //
        $users = UserSadhakRegistration::with(['userDetail'=>function($query){
            return $query->with('userlogin');
        }])->where('sibir_record_id',$zoom->sibir_record_id);
        
        if ( $request->shift_order ) {
            $users->where('id','>',$request->shift_order);
        }
        $user_registration_record = $users->limit(50)->get();
        
        if ( ! $user_registration_record->count() ) {
            return response([
                "success" => true,
                "message" => "All Members have been registered."
            ]);
        }
        $offlimitcontd = 1;
        $bulk_record = [];
        $skip_record = [];
        $last_id = 0;

        foreach ($user_registration_record as $register_user) {
            if($register_user->userDetail) {
                $innerArray = [];
                $first_name = ($register_user->userDetail->middle_name) ? $register_user->userDetail->first_name. " ".$register_user->userDetail->middle_name : $register_user->userDetail->first_name;
                $data = [
                    "first_name" => ucwords(strtolower($first_name)),
                    "last_name" => ($register_user->userDetail->last_name) ?  ucwords(strtolower($register_user->userDetail->last_name)) : "L",
                    "email" => "_test_{$register_user->user_detail_id}@gmail.com",
                    // "email" => ($register_user->userDetail->userlogin && $register_user->userDetail->userlogin->email) ? $register_user->userDetail->userlogin->email : "anoemailg_{$register_user->user_detail_id}@gmail.com"
                ];
                
                $zoom_response = zoom_registration_link($data,$zoom->meeting_id,$zoom->signature);
                if ( $zoom_response ) {
                    $innerArray = [
                        'join_link' => $zoom_response->join_url,
                        'registration_id' => $zoom_response->registrant_id,
                        'user_detail_id' => $register_user->user_detail_id,
                        'have_joined' => false,
                        'joined_at' => true,
                        'sibir_record_id'=> $zoom->sibir_record_id,
                        'meeting_id' => $zoom->meeting_id,
                        "created_at" => \Carbon\Carbon::now()
                    ];
                    $bulk_record[] = $innerArray;
                    $offlimitcontd = $register_user->id;    
                } else {
                    $skip_record[] = $data;
                }
            }
        }

        if ($bulk_record) {
            try {
                SadhakUniqueZoomRegistration::insert($bulk_record);
            } catch (\Throwable $th) {
                //throw $th;
                return response([
                    'success' => false,
                    "message" => "Error, unable to register user. Error: ". $th->getMessage()
                ]);
            }
            return redirect()->route('events.admin_register_participants_to_sibir',[$zoom->id,'shift_order'=>$offlimitcontd]);

        }

    }

    public function global_remove_registration(Request $request, Zoom $zoom) 
    {

    }

    public function zoom_merge(){
        $current_live_session = ZoomSetting::where('is_active',true)
                                            ->where('is_global',false)
                                            ->get();
        //available merge session.
        $merge_zone = [
            "38" => "Canada Session",
            "230" => "U.K. Session",
            "101" => "India Session",
            "13" => "Australia Session"
        ];

        return view("admin.zoom.merge_session",compact("current_live_session","merge_zone"));
    }

    public function merge_submission(Request $request) {
        if ( ! isAdmin() ) {
            $request->session()->flash('message',"Unauthorized Access.");
            return back();
        }
        return $this->register_participants($request,$request->merge_to);
    }

    public function add_user_to_meeting(Request $request) {
        $zoom = ZoomSetting::findOrFail($request->current_meeting);

        $is_email = filter_var($request->search,FILTER_VALIDATE_EMAIL);
        
        if ($is_email) {
            $user_login = userLogin::where('email',$request->search)->first();
            if (! $user_login ) {
                return response ([
                    "success" => false,
                    "message" => "User Record Not Found."
                ]);
            }

            $user_detail = $user_login->userdetail;

            $user_detail_id = $user_login->user_detail_id;
        } else {
            $user_detail = userDetail::where('phone_number',$request->search)->first();
            if ( ! $user_detail ) {
                return response ([
                    "success" => false,
                    "message" => "User Phone Number Record Not Found."
                ]);                
            } 
            $user_detail_id = $user_detail->id;
        }

        $first_name = ($user_detail->middle_name) ? $user_detail->first_name. " ".$user_detail->middle_name : $user_detail->first_name;
        $data = [
            "first_name" => ucwords(strtolower($first_name)),
            "last_name" => ($user_detail->last_name) ?  ucwords(strtolower($user_detail->last_name)) : "L",
            "email" => "_test_{$user_detail_id}@siddhamahayog.org",
            // "email" => ($register_user->userDetail->userlogin && $register_user->userDetail->userlogin->email) ? $register_user->userDetail->userlogin->email : "anoemailg_{$register_user->user_detail_id}@gmail.com"
        ];
        $zoom_response = zoom_registration_link($data,$zoom->meeting_id,$zoom->signature);
        $bulk_record = [];
        if ( $zoom_response ) {
            $innerArray = [
                'join_link' => $zoom_response->join_url,
                'registration_id' => $zoom_response->registrant_id,
                'user_detail_id' => $user_detail_id,
                'have_joined' => false,
                'joined_at' => true,
                'sibir_record_id'=> $zoom->sibir_record_id,
                'meeting_id' => $zoom->meeting_id,
                "created_at" => \Carbon\Carbon::now()
            ];
            $bulk_record[] = $innerArray;
            // $offlimitcontd = $user_detail->id;    
        }

        try {
            SadhakUniqueZoomRegistration::insert($bulk_record);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'success' => false,
                "message" => "Error, unable to register user. Error: ". $th->getMessage()
            ]);
        }
        return response([
            'success' => true,
            "message" => "`{$user_detail->first_name}" . "` has been registered successfully." 
        ]);

    }

    public function admin_join_as_sadhak(Request $request, ZoomSetting $zoom) {
        if (! isAdmin()  ) {
            abort(404);
        }

        $user_sadhak_join_link = SadhakUniqueZoomRegistration::where('meeting_id',$zoom->meeting_id)
                                    ->where('user_detail_id',auth()->user()->user_detail_id)
                                    ->first();
        if ($user_sadhak_join_link) {
            return redirect()->away($user_sadhak_join_link->join_link);
        } 
        $request->session()->flash('message',"Sorry Id is not registered as sadhak.");
        return back();
    }
}
