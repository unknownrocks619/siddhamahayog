<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\GuestAccess;
use App\Models\Program;
use Illuminate\Http\Request;

class AdminProgramGuestListController extends Controller
{
    //

    public function index(Program $program)
    {
        $guestLists = GuestAccess::where('program_id', $program->getKey())->with(['liveProgram'])->get();
        return view('admin.programs.guests.index', compact('program', 'guestLists'));
    }

    public function store(Request $request, Program $program)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => "required",
            'access_code' => 'required'
        ]);

        $guestAccess = new GuestAccess();
        $guestAccess->first_name = ucfirst($request->first_name);
        $guestAccess->middle_name = ucfirst($request->middle_name);
        $guestAccess->last_name = ucfirst($request->last_name);

        $guestAccess->access_code = $request->access_code;
        $guestAccess->remarks = $request->remarks;
        $guestAccess->program_id = $program->getKey();

        // meeting ID:
        $meetingDetail = $program->liveProgram()->latest()->first();
        $guestAccess->meeting_id = $meetingDetail->meeting_id;

        try {
            $guestAccess->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(['errors' => [], 'message' => $th->getMessage()], 406);
        }

        return response(['errors' => [], 'message' => "New Guest List Created."], 200);
    }

    public function delete(Program $program, GuestAccess $guest)
    {

        $guest->delete();

        session()->flash('success', "Access Token Deleted.");
        return back();
    }
}
