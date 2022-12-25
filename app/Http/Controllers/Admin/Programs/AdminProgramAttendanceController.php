<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Live;
use App\Models\Program;
use App\Models\ProgramStudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminProgramAttendanceController extends Controller
{
    //

    public function index(Request $request, Program $program)
    {
        $program->load(["students" => fn ($query) => $query->with(['student'])]);
        $carbonToday = Carbon::now();
        $start_date = $carbonToday->subDays(11)->format('Y-m-d');
        $end_date = $carbonToday->today()->format("Y-m-d");
        if ($request->get('dates')) {

            $split_dates  =  explode(' - ', $request->get('dates'));
            $parseStartDate = Carbon::parse($split_dates[0]);
            $parseEndDate = Carbon::parse($split_dates[1]);

            $start_date == $parseStartDate->format("Y-m-d");
            $end_date = $parseEndDate->addDay()->format('Y-m-d');
        }

        $presentList = Live::where('program_id', $program->getKey())
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        return view('admin.programs.attendance.list', compact("program", "presentList"));
    }

    public function filterResult(Request $request, Program $program)
    {
        $program->load(["students" => function ($query) {
            $query->with(["attendances", 'section', "student"]);
        }]);
    }
}
