<?php

namespace App\Http\Controllers\Frontend\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Event\LiveEventRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\Live;
use App\Models\MemberNotes;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramSection;
use App\Models\ProgramStudentAttendance;
use App\Models\WebsiteEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use CourseFeeCheck;
    /**
     * Dispaly Event Detail Page.
     * @param String $slug
     * @return view
     */
    public function event($slug)
    {
        $event = WebsiteEvents::where('slug', $slug)->firstOrFail();
        return view('frontend.page.event', compact('event'));
    }

    public function calendar()
    {
        return view("frontend.user.calendar.index");
    }

    public function liveEvent(LiveEventRequest $request, Program $program, Live $live, ProgramSection $programSection)
    {
        if ($program->program_type == "paid" && !$this->checkFeeDetail($program, "admission_fee")) {
            $notification = new MemberNotification;
            $notification->member_id = auth()->id();
            $notification->title =  'Unable to access ' . $program->program_name;
            $notification->body = "You are not authorized to join the session because of your pending dues. Please clear all the dues to access the content without distrubance or contact support for more information.";
            $notification->type = "message";
            $notification->level = "info";
            $notification->seen = false;
            $notification->save();
            session()->flash("error", 'Unable to join session, Your payment is due.');
            return back();
        }
        // dd($live->zoomAccount);
        // check if user already have joined.
        $attendance = ProgramStudentAttendance::where('live_id', $live->id)
            ->where('program_id', $program->id)
            ->where("student", auth()->id())
            ->where('meeting_id', $live->meeting_id)
            ->latest()
            ->first();
        if ($attendance) {
            $meta = (array)$attendance->meta;
            $meta[date("Y-m-d H:i:s")] = "Re-joined";
            $attendance->meta = $meta;
            $attendance->save();
            return redirect()->to($attendance->join_url);
        }

        if ($live->lock) {
            $message = ($live->lock_text) ?  $live->lock_text : "Sorry ! This meeting has been locked. Pelase contact support to get access.";
            session()->flash('error', $message);
            return back();
        }
        $attendance = new ProgramStudentAttendance;
        $attendance->program_id = $program->id;
        $attendance->student = auth()->id();
        $attendance->section_id = auth()->user()->section->program_section_id;
        $attendance->live_id = $live->id;
        $attendance->meeting_id = $live->meeting_id;
        $attendance->active = true;

        $register_member = json_decode(register_participants($live->zoomAccount, $live->meeting_id));
        if (isset($register_member->code)) {
            session()->flash('error', "Unable to join session. " . $register_member->message);
            return back();
        }
        $attendance->join_url = $register_member->join_url; // register user and fetch account.
        $attendance->meta = [
            "zoom" => $register_member, //,
            "ip" => $request->ip(),
            "browser" => $request->header("User-Agent")
        ];
        // 

        try {
            //code...
            $attendance->save();
        } catch (\Throwable $th) {
            //throw $th;
            $notification = new MemberNotification;
            $notification->member_id = auth()->id();
            $notification->title = $program->program_name . " attendance";
            $notification->body = "Attendance couldn't be taken at the moment. If you are locked out from joining please inform support team.";
            $notification->type = "message";
            $notification->level = "info";
            $notification->seen = false;
            $notification->save();
        }
        return redirect()->to($register_member->join_url);
    }
}
