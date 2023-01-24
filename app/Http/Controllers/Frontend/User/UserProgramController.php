<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Program\LeaveCreateRequest;
use App\Http\Requests\Frontend\User\Program\LeaveStoreRequest;
use App\Models\Program;
use App\Models\ProgramHoliday;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class UserProgramController extends Controller
{

    //
    public function index()
    {
        $programs = ProgramStudent::where('student_id', auth()->id())
            ->with(["program", 'section', 'batch'])
            ->latest()->get();
        return view('frontend.user.program.index', compact('programs'));
    }

    public function requestLeaveList(LeaveCreateRequest $request, Program $program)
    {
        $programStudent = ProgramStudent::where('program_id', $program->getKey())->where('student_id', user()->getKey())->where('active', true)->exists();

        if (!$programStudent) {
            return view('frontend.user.program.cancelled', compact('program'));
        }

        $leave_requests = ProgramHoliday::where('program_id', $program->id)->where('student_id', auth()->id())->latest()->get();
        return view("frontend.user.program.leave-request-list", compact("program", "leave_requests"));
    }

    public function requestLeaveCreate(LeaveCreateRequest $request, Program $program)
    {
        $programStudent = ProgramStudent::where('program_id', $program->getKey())->where('student_id', user()->getKey())->where('active', true)->exists();

        if (!$programStudent) {
            return view('frontend.user.program.cancelled', compact('program'));
        }

        return view("frontend.user.program.leave-request-create", compact("program"));
    }

    public function requestLeaveStore(LeaveStoreRequest $request, Program $program)
    {
        $programStudent = ProgramStudent::where('program_id', $program->getKey())->where('student_id', user()->getKey())->where('active', true)->exists();

        if (!$programStudent) {
            return view('frontend.user.program.cancelled', compact('program'));
        }

        $leaveRequest = new ProgramHoliday;
        $leaveRequest->program_id = $program->id;
        $leaveRequest->student_id = auth()->id();
        $leaveRequest->reason = $request->message;
        $leaveRequest->start_date = $request->holiday_start_date;
        $leaveRequest->end_date = $request->holiday_end_date;
        $leaveRequest->status = "pending";


        try {
            $leaveRequest->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to submit your request");
            return back()->withInput();
        }

        session()->flash("success", "Your request has been submitted successfully.");
        return redirect()->route('user.account.programs.program.request.index', [$program->id]);
    }
}
