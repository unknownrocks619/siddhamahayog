@php
    if (request()->progarm) {
        $program = request()->program;
    }

    if (isset($program) && $program instanceof \App\Models\Program) {
        $program = $program->getKey();
    }

    $volunteerDate = \App\Models\ProgramVolunteerAvailableDates::find(request()->availableDate);

@endphp
<form method="post" class="ajax-form" action="{{route('admin.program.volunteer.admin_volunteer_update_status',['program' => $program,'volunteer' => $volunteerDate->program_volunteer_id,'availableDates' =>$volunteerDate ])}}">
    <input type="hidden" name="type" value="approved" />
    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-5">
       <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    User will receive an sms notification with remarks and his reporting time.
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="remarks">Remarks / Instruction</label>
                    <textarea maxlength="160" name="remarks" id="remarks" class="form-control"></textarea>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="reportin_time">Reporting Time</label>
                    <input type="time" name="reportin_time" id="reportin_time" class="form-control">
                </div>
            </div>
       </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Accept
                </button>
            </div>
        </div>
    </div>
</form>
