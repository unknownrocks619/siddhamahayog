<?php

namespace App\Http\Controllers\API\Zoom;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Zoom\API\ZoomAPIRequest;
use App\Http\Resources\ZoomAPIResource;
use App\Http\Resources\ZoomMeetingAPIResource;
use App\Models\MeetingProgram;
use Illuminate\Http\Request;
use App\Models\ZoomAccount;
use App\Models\ZoomMeeting;

class ZoomAPIController extends Controller
{
    //

    public function zoom_account_list() {
        return ZoomAPIResource::collection(ZoomAccount::all());
    }

    public function store_zoom_meeting(ZoomAPIRequest $request) {
        return ($request->all());

        $zoom_meeting = new ZoomMeeting;

        $zoom_meeting->zoom_accounts_id = $request->zoom_account;
        $zoom_meeting->meeting_name = $request->meeting_name;
        $zoom_meeting->slug = Str::slug($request->meeting_name,"-");
        $zoom_meeting->meeting_type = $request->meeting_type;

        if ($zoom_meeting->meeting_type == "instant") {
            $zoom_meeting->daily_register = false;
            // create new meeting as well. or we can do this 
        }

        $zoom_meeting->timezone = $request->timezone;
        $zoom_meeting->completed = false;

        if ($zoom_meeting->meeting_type == "scheduled"){
            $zoom_meeting->scheduled_timestamp = $request->scheduled_date . " " . $request->scheduled_time;
        }
        if ($zoom_meeting->meeting_type == "reoccuring") {
            $zoom_meeting->repetition_setting = $request->reoccuring;
            $zoom_meeting->scheduled_timestamp = $request->reoccuring_meeting_timing;
        }
        $zoom_meeting->live = false;
        $zoom_meeting->lock = ($request->meeting_lock == "yes") ? true : false;
        if ( $zoom_meeting->lock ) {
            $zoom_meeting->lock_setting = $request->meeting_interval;
        }
        $zoom_meeting->remarks = $request->remarks;
        $zoom_meeting->created_by = auth()->id();
        $zoom_meeting->country_specified = ($request->country_lock == "yes") ? true :false;
        // 


        try {
            //code...
            $zoom_meeting->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            
        } catch (\Error $er) {
            dd("Error: ".$er->getMessage());
        }
        if ($request->program) {
            $zoom_program = new MeetingProgram;
            $zoom_program->meeting_id = $zoom_meeting->id;
            $zoom_meeting->program_id = $request->program;
            $zoom_meeting->is_live = false;
            $zoom_meeting->save();
        }
    
    

        return response(["success"=>true,"message"=>"New Meeting Created and stored."],200);
    }

    public function update_zoom_meeting(ZoomAPIRequest $request, ZoomMeeting $meeting) {
        $meeting->zoom_accounts_id = $request->zoom_account;
        $meeting->meeting_name = $request->meeting_name;
        $meeting->slug = Str::slug($request->meeting_name,"-");
        $meeting->meeting_type = $request->meeting_type;

        if ($meeting->meeting_type == "instant") {
            $meeting->daily_register = false;
            // create new meeting as well. or we can do this 
        }

        $meeting->timezone = $request->timezone;
        $meeting->completed = false;

        if ($meeting->meeting_type == "scheduled"){
            $meeting->scheduled_timestamp = $request->scheduled_date . " " . $request->scheduled_time;
        }
        if ($meeting->meeting_type == "reoccuring") {
            $meeting->repetition_setting = $request->reoccuring;
            $meeting->scheduled_timestamp = $request->reoccuring_meeting_timing;
        }
        $meeting->lock = ($request->meeting_lock == "yes") ? true : false;
        if ( $meeting->lock ) {
            $meeting->lock_setting = $request->meeting_interval;
        }
        $meeting->remarks = $request->remarks;
        try {
            //code...
            $meeting->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            
        } catch (\Error $er) {
            dd("Error: ".$er->getMessage());
        }
        return response(["success"=>true,"message"=>"Meeting Information updated."],200);

    }
}
