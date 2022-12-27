<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudentAttendance;
use App\Models\UnpaidAccess;
use Illuminate\Http\Request;

class AdminProgramUnpaidAccessController extends Controller
{
    //

    public function index(Program $program)
    {
        $unpaidlists = UnpaidAccess::where('program_id', $program->getKey())
            ->with(['student'])
            ->get();

        return  view('admin.programs.unpaidaccess.index', compact('unpaidlists', 'program'));
    }

    public function joinedMeta(Program $program, Member $member)
    {
        $attendances = ProgramStudentAttendance::where('program_id', $program->getKey())
            ->where('student', $member->getKey())
            ->get();

        return view('admin.programs.unpaidaccess.joined-data', compact('attendances'));
    }

    public function resetMeta(UnpaidAccess $access)
    {

        $access->total_joined = 0;

        $access->save();

        session()->flash('success', 'User information was reset.');
        return back();
    }
}
