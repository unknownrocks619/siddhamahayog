<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\ProgramHoliday;
use Illuminate\Http\Request;

class AdminProgramHolidayController extends Controller
{
    //

    public function index()
    {
        $holidays = ProgramHoliday::with(["program", "student"])->where('status',  'pending')->get();
        return view("admin.holiday.index", compact("holidays"));
    }

    public function show(ProgramHoliday $holiday)
    {
        return view("admin.holiday.detail", compact('holiday'));
    }

    public function update(Request $request, ProgramHoliday $holiday)
    {
        $holiday->status = $request->options;
        $holiday->response_text = $request->message;
        $holiday->response_by = auth()->id();
        try {
            $holiday->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Error: " . $th->getMessage());
            return back();
        }
        session()->flash('success', "Status updated");
        return redirect()->route("admin.holidays.holiday.index");
    }
}
