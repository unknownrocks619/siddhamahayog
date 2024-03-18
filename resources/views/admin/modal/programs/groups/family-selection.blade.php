@php
    $member = App\Models\Member::with(['emergency_contact' => function($query){
        $query->where('contact_type','family');
    }])->where('id',request()->get('member'))->first();
    $group = App\Models\ProgramGrouping::where('id',request()->get('group'))->first();
    $people = App\Models\ProgramGroupPeople::where('id',request()->get('people'))->first();
@endphp
<form method="post" class="ajax-form" action="{{route('admin.program.admin_update_family_group',['program' => $group->program_id,'group' => $group,'people' => $people])}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Select Family For {{$member->full_name}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="list-group">
                @forelse ($member->emergency_contact ?? [] as $familyMember)
                @php
                    // check if this family is already included in the 
                    $familyExists = App\Models\ProgramGroupPeople::where('member_id',$familyMember->getKey())
                                                        ->where('is_parent',false)
                                                        ->where('id_parent',$people->getKey())
                                                        ->where('group_id',$group->getKey())
                                                        ->exists();
                @endphp         
                <label class="list-group-item">
                    <input class="form-check-input me-1" @if($familyExists) checked @endif name="families[]" type="checkbox" value="{{$familyMember->getKey()}}">
                        {{$familyMember->contact_person}}
                </label>
                @empty
                    <h5 class="text-muted">No family Member Found. Please add family Member</h5>
                @endforelse
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-label-secondary" data-bs-dismiss="modal">Update Family Member</button>
    </div>
</form>