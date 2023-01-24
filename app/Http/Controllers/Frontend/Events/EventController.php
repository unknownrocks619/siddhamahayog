<?php

namespace App\Http\Controllers\Frontend\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Event\LiveEventJoinAsAdminRequest;
use App\Http\Requests\Frontend\Event\LiveEventRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\Live;
use App\Models\MemberNotes;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramSection;
use App\Models\ProgramStudentAttendance;
use App\Models\Ramdas;
use App\Models\WebsiteEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use CourseFeeCheck;

    protected $model = null;

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

    public function joinOpenEvent(LiveEventRequest $request, Program $program, Live $live)
    {
        $attendance = $this->checkAndUpdateAttendance($program, $live);
        $lock = $this->isLiveLock($live);
        if ($lock) {
            return $lock;
        }
        return $this->markAttendance($program, $live);
    }

    public function liveEvent(LiveEventRequest $request, Program $program, Live $live, ProgramSection $programSection)
    {

        if (!$program->program_active_student()) {
            session()->flash('error', "Live session for ` {$program->program_name}` is not available.");
            return back();
        }

        if (!$live->live) {
            session()->flash('error', 'Live session for `' . $program->program_name . "` is already over.");
            return back();
        }

        $attendance = $this->checkAndUpdateAttendance($program, $live);
        if ($attendance) {
            return $attendance;
        }


        $lock = $this->isLiveLock($live);
        if ($lock) {
            return $lock;
        }

        $access = true;
        if ($live->section_id) {
            $user_section = user()->section->program_section_id;
            $access = ($user_section == $live->section_id) ? true : false;
            if (!$access) {
                $access =  ($live->merge && isset($live->merge->$user_section)) ? true : false;
            }
        }
        if (!$access && $live->merge) {
            $access =  ($live->merge && isset($live->merge->$user_section)) ? true : false;
        }
        if (!$access) {
            session()->flash('error', "You are not allowed to join this session. Please contact support or create a support ticket to address this issue.");
            return back();
        }
        return $this->markAttendance($program, $live);
    }

    protected function checkAndUpdateAttendance(Program $program, Live $live)
    {
        $attendance = ProgramStudentAttendance::where('live_id', $live->id)
            ->where('program_id', $program->id)
            ->where("student", user()->id)
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
    }

    protected function markAttendance(Program $program, Live $live)
    {
        $attendance = new ProgramStudentAttendance;
        $attendance->program_id = $program->id;
        $attendance->student = auth()->id();
        $attendance->section_id = ($program->program_type == "open") ? $program->active_sections->id :  auth()->user()->section->program_section_id;
        $attendance->live_id = $live->id;
        $attendance->meeting_id = $live->meeting_id;
        $attendance->active = true;

        $last_name = ucfirst(trim(user()->last_name));
        if (user()->middle_name) {
            $last_name = ucfirst(trim(user()->middle_name)) . ' ' . ucfirst(trim(user()->last_name));
        }
        $settings = [
            'first_name' => ucfirst(trim(user()->first_name)),
            'last_name' => $last_name,
            'email' => "T_" . time() . "_rand_" . user()->getKey() . "@" . $live->domain,
            'auto_approve' => true
        ];

        if (user()->role_id == 1 || user()->role_id == 11) {

            $number = substr(time(), 7, 3);
            $settings = [
                'first_name' => "Ram",
                'last_name' => "Das ({$number})",
                'email' => Str::slug(trim(user()->first_name), "_") . time() . "_key_" . user()->getKey() . "@" . $live->domain,
                'auto_approve' => true
            ];

            $insertRamdasInfo = new Ramdas();
            $insertRamdasInfo->member_id = user()->getKey();
            $insertRamdasInfo->full_name = user()->full_name;
            $insertRamdasInfo->role_id = user()->role_id;
            $insertRamdasInfo->reference_number = $number;
        }
        $register_member = json_decode(register_participants($live->zoomAccount, $live->meeting_id, $settings, $live->domain));
        if (isset($register_member->code)) {
            session()->flash('error', "Unable to join session. " . $register_member->message);
            return back();
        }
        $attendance->join_url = $register_member->join_url; // register user and fetch account.
        $attendance->meta = [
            "zoom" => $register_member, //,
            "ip" => request()->ip(),
            "browser" => request()->header("User-Agent"),
            'additional_info' => [getUserLocation()]
        ];
        //

        try {
            //code...
            $attendance->save();

            if (isset($insertRamdasInfo)) {
                $insertRamdasInfo->meeting_id = $live->meeting_id;
                $insertRamdasInfo->save();
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            //throw $th;
            $notification = new MemberNotification;
            $notification->member_id = auth()->id();
            $notification->title = $program->program_name . " attendance";
            $notification->body = "Attendance couldn't be taken at the moment. If you are locked out from joining please inform support team.";
            $notification->type = "message";
            $notification->level = "info";
            $notification->seen = false;
            $notification->save();

            session()->flash('error', "Oops ! Something went wrong. Please try again later.");
            return back();
        }
        return redirect()->to($register_member->join_url);
    }

    protected function isLiveLock(Live $live)
    {
        if ($live->lock) {
            $message = ($live->lock_text) ?  $live->lock_text : "Sorry ! This meeting has been locked. Pelase contact support to get access.";
            session()->flash('error', $message);
            return back();
        }
    }

    public function join_as_admin(LiveEventJoinAsAdminRequest $request, Live $live)
    {
        return redirect()->to($live->admin_start_url);
    }
}
