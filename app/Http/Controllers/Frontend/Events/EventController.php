<?php

namespace App\Http\Controllers\Frontend\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Event\LiveEventJoinAsAdminRequest;
use App\Http\Requests\Frontend\Event\LiveEventRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\AttendanceDateSheet;
use App\Models\Live;
use App\Models\Member;
use App\Models\MemberNotes;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramSection;
use App\Models\ProgramStudentAttendance;
use App\Models\Ramdas;
use App\Models\Role;
use App\Models\User;
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


    public function liveEventAjax(LiveEventRequest $request, Program $program, Live $live, ProgramSection $programSection)
    {
        $studentDetail = $program->program_active_student();

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
        if (! in_array(user()->role_id, Role::ADMIN_DASHBOARD_ACCESS)) {
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
        }

        if ($request->has('apiRequest')) {

            if (! $access) {
                return false;
            }
        }

        if (!$access) {
            session()->flash('error', "You are not allowed to join this session. Please contact support or create a support ticket to address this issue.");
            return back();
        }

        return $this->markAttendance($program, $live);
    }

    public function liveEvent(LiveEventRequest $request, Program $program, $live, ProgramSection $programSection)
    {
        $studentDetail = $program->program_active_student();
        // get live based on user section.
        $live = Live::where('program_id', $program->getKey())
            ->where('live', true)
            ->where(function ($query) use ($studentDetail, $request) {
                if (!$studentDetail->allow_all) {
                    $query->where('section_id', $studentDetail->program_section_id);
                } elseif ($request->has('select_section')) {
                    $query->where('section_id', $request->get('select_section'));
                }
            })
            ->first();
        if (!$live) {

            $live = Live::where('program_id', $program->getKey())
                ->where('live', true)
                ->where('section_id', NULL)
                ->latest()
                ->first();
        }


        if (!$studentDetail || !$live) {
            return $this->json(false, "Live session for `{$program->program_name}` is not available.");
        }
        if ($live->section_id) {

            if ($studentDetail->allow_all && !$request->has('select_section')) {
                $renderHtml = view('frontend.user.modals.multiple-join-section', compact('program', 'live'))->render();
                return $this->json(true, 'Please select your desired section.', 'popModalWithHTML', ['modalID' => 'responsiveContent', 'content' => $renderHtml]);
            }

            /**
             * Need to validate
             * if allowed.
             */
            if ($studentDetail->allow_all && $request->has('join_as') && $request->get('join_as')) {
                return $this->json(true, '', 'redirect', ['location' => $live->admin_start_url]);
            }

            if ($studentDetail->allow_all && $request->has('select_section') && $request->get('select_section')) {
                $studentDetail->section_id  = $request->get('select_section');
                $live->section_id = $request->get('select_section');
            }
        }

        $attendance = $this->checkAndUpdateAttendance($program, $live, true, $studentDetail);

        if ($attendance) {

            return $attendance;
        }

        if ($live->lock) {
            return $this->json(false, $live->lock_text ?? 'Sorry ! This meeting has been locked. Pelase contact support to get access.');
        }

        $access = true;


        $user_section = ($studentDetail->allow_all && $request->has('select_section'))  ? $live->section_id :  $studentDetail->program_section_id;
        if ($live->section_id) {
            $access = ($user_section == $live->section_id) ? true : false;

            if (!$access) {
                $access =  ($live->merge && isset($live->merge->$user_section)) ? true : false;
            }
        }
        if (!$access && $live->merge) {
            $access =  ($live->merge && isset($live->merge->$user_section)) ? true : false;
        }

        if (!$access) {
            return $this->json(false, "You are not allowed to join this session. Please contact support or create a support ticket to address this issue.");
        }

        return $this->markAttendance($program, $live, true);
    }

    public function checkAndUpdateAttendance(Program $program, Live $live, bool $ajaxResponse = false, $userSection = null, Member $user = null)
    {
        $attendance = ProgramStudentAttendance::where('live_id', $live->id)
            ->where('program_id', $program->id)
            ->where("student", ($user) ? $user->getKey() : user()->id)
            ->where('meeting_id', $live->meeting_id)
            ->latest()
            ->first();

        if ($attendance) {

            $meta = (array)$attendance->meta;
            $meta[date("Y-m-d H:i:s")] = "Re-joined";
            $attendance->meta = $meta;
            $attendance->save();

            if ($ajaxResponse) {
                return $this->json(true, '', 'redirect', ['location' => $attendance->join_url]);
            }
            return redirect()->to($attendance->join_url);
        }
    }

    public function markAttendance(Program $program, Live $live, bool $ajaxResponse = false, Member $user = null)
    {

        $user = ($user) ? $user : user();
        $attendance = new ProgramStudentAttendance;
        $attendance->program_id = $program->getKey();
        $attendance->student = $user->getKey();
        $attendance->section_id = ($program->program_type == "open") ? $program->active_sections?->id ?? 0 : (($live->section_id) ? $live->section_id : $user->section?->program_section_id);
        $attendance->live_id = $live->id;
        $attendance->meeting_id = $live->meeting_id;
        $attendance->active = true;

        $date = date('Y-m-d');
        $dateID = AttendanceDateSheet::select(['id'])->where('attendance_date', $date)->first();
        $attendance->attendance_date_id = $dateID->getKey();


        $last_name = ucfirst(trim($user->last_name));
        if ($user->middle_name) {
            $last_name = ucfirst(trim($user->middle_name)) . ' ' . ucfirst(trim($user->last_name));
        }
        $settings = [
            'first_name' => ucfirst(trim($user->first_name)),
            'last_name' => $last_name,
            'email' => "T_" . time() . "_rand_" . $user->getKey() . "@" . $live->domain,
            'auto_approve' => true
        ];

        if ($user->role_id == 1 || $user->role_id == 11) {

            $number = substr(time(), 7, 3);
            $settings = [
                'first_name' => "Ram",
                'last_name' => "Das ({$number})",
                'email' => Str::slug(trim($user->first_name), "_") . time() . "_key_" . $user->getKey() . "@" . $live->domain,
                'auto_approve' => true
            ];

            $insertRamdasInfo = new Ramdas();
            $insertRamdasInfo->member_id = $user->getKey();
            $insertRamdasInfo->full_name = $user->full_name;
            $insertRamdasInfo->role_id = $user->role_id;
            $insertRamdasInfo->reference_number = $number;
        }
        $register_member = register_participants($live->zoomAccount, $live->meeting_id, $settings, $live->domain);
        if (isset($register_member['code'])) {
            session()->flash('error', "Unable to join session. " . $register_member['message']);
            return back();
        }
        $attendance->join_url = $register_member['join_url']; // register user and fetch account.
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
            //throw $th;
            $notification = new MemberNotification;
            $notification->member_id = $user->getKey();
            $notification->title = $program->program_name . " attendance";
            $notification->body = "Attendance couldn't be taken at the moment. If you are locked out from joining please inform support team.";
            $notification->type = "message";
            $notification->level = "info";
            $notification->seen = false;
            $notification->save();

            if ($ajaxResponse) {
                return $this->json(false, "Oops ! Something went wrong. Please try again later.");
            }
            session()->flash('error', "Oops ! Something went wrong. Please try again later.");
            return back();
        }

        if ($ajaxResponse) {
            return $this->json(true, '', 'redirect', ['location' => $register_member['join_url']]);
        }
        return redirect()->to($register_member['join_url']);
    }

    public function isLiveLock(Live $live)
    {
        if ($live->lock) {
            $message = ($live->lock_text) ?  $live->lock_text : "Sorry ! This meeting has been locked. Pelase contact support to get access.";
            session()->flash('error', $message);
            return back();
        }
    }

    public function join_as_admin(LiveEventJoinAsAdminRequest $request, Live $live, bool $ajaxResponse = false)
    {

        if ($ajaxResponse) {
            return $live->admin_start_url;
        }
        return redirect()->to($live->admin_start_url);
    }
}
