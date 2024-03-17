@php
    $member = App\Models\Member::with(['emergency_contact' => function($query){
        $query->where('contact_type','family');
    }])->where('id',request()->get('member'))->first();
    $group = App\Models\ProgramGrouping::where('id',request()->get('group'))->first();
@endphp
<form method="post" class="ajax-form" action="#">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Select Family </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            @foreach ($member->emergency_contact ?? [] as $familyMember)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_name">Program <sup class="text-danger">*</sup></label>
                        <span class="form-control bg-light">{{$program->program_name}}</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Add Family To Member</button>
    </div>
</form>