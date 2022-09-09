<?php

namespace App\Http\Controllers\Frontend\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Event\LiveEventRequest;
use App\Models\Live;
use App\Models\Program;
use App\Models\ProgramSection;
use App\Models\ProgramStudentAttendance;
use App\Models\WebsiteEvents;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
        // check if user already have joined.
        $attendance = ProgramStudentAttendance::where('live_id', $live->id)
            ->where('program_id', $program->id)
            ->where("student_id", auth()->id())
            ->latest()
            ->first();

        if ($attendance) {
            return redirect()->to($attendance->join_url);
        }
        // 
    }
}
