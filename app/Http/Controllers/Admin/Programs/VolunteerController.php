<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Admin\Datatables\ProgramDataTablesController;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramVolunteer;
use App\Models\ProgramVolunteerAvailableDates;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(Program $program) {
        $request = request()->capture();
        
        if ($request->ajax() ) {
            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            return (new ProgramDataTablesController())->programVolunteerList($request,$program,$searchTerm);

        }

        return view('admin.programs.volunteer.list',['program' => $program]);
    }

    public function show(Program $program, ProgramVolunteer $volunteer) {
        $member = Member::find($volunteer->member_id);

        return view('admin.programs.volunteer.view',['program' => $program, 'volunteer' => $volunteer,'member' => $member]);
    }

    public function updateStatus(Request $request, Program $program, ProgramVolunteer $volunteer, ?ProgramVolunteerAvailableDates $availableDates) {

        /**
         * Apporved 
         */
        $request->validate([
            // 'type'  => 'nullable|in:rejected,approved',
            // 'remarks'   => 'required_if:type,approved'
        ]);

        if ( $availableDates?->getKey() ) {

            $type = $request->post('type');
            if ( ! $type ) {
                $type = $request->type;
            }
            $availableDates->status = $type;
            $availableDates->remarks = $request->post('remarks');
            $availableDates->reporting_time = $request->post('reporting_time');
            $availableDates->save();

            /**
             * Send SMS.
             */
            if ($request->post('alert_sms') ) {
                // 
            }

        } else {

            ProgramVolunteerAvailableDates::where('program_volunteer_id',$volunteer->getKey())
                                            ->whereIn('id',$request->post('dates'))
                                            ->update([
                                                        'status' => $request->post('remarks') && $request->post('type') ? 'approved' : 'rejected',
                                                        'remarks'   => $request->post('remarks'),
                                            ]);
        }

        return $this->json(true,'Volunteer Status Updated.');
    }
}
