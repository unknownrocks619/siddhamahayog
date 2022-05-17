<?php

namespace App\Http\Controllers\Admin\Zoom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\ZoomAccount;
use App\Models\ZoomMeeting;
use Illuminate\Http\JsonResponse;

class AdminZoomMeetingController extends Controller
{
    /**
     * Display all available zoom accounts created in db
     */
    public function meetings() {
        $meetings = ZoomMeeting::with(["account"])->latest()->paginate();
        return view("admin.zoom.meetings.meeting",compact("meetings"));
    }

    public function create_meeting() {
        return view("admin.zoom.meetings.create-meeting");
    }

    public function edit_zoom_meeting(ZoomMeeting $meeting){
        if ($meeting->meeting_type == "scheduled") {
            $meeting->scheduled_date = date("Y-m-d",strtotime($meeting->scheduled_timestamp));
            $meeting->scheduled_time = date("H:i",strtotime($meeting->scheduled_timestamp));
        }

        if ($meeting->meeting_type == "reoccuring") {
            $meeting->reoccuring = $meeting->repetition_setting;
            $meeting->reoccuring_meeting_timing = $meeting->scheduled_timestamp;
        }

        if ($meeting->lock) {
            $meeting->meeting_lock = "yes";
            $meeting->meeting_interval = $meeting->lock_setting;
        } else {
            $meeting->meeting_lock = "no";
        }

        $meeting->country_lock = ($meeting->country_specified) ? "yes" : "no"; 
        $meeting->zoom_account = $meeting->zoom_accounts_id;
        unset($meeting->zoom_accounts_id);
        unset($meeting->country_specified);
        unset($meeting->lock);
        unset($meeting->lock_settings);
        unset($meeting->created_at);
        unset($meeting->updated_at);
        unset($meeting->deleted_at);
        unset($meeting->daily_register);
        return view("admin.zoom.meetings.edit-meeting",compact("meeting"));
    }

    public function remove_account() {

    }
}
