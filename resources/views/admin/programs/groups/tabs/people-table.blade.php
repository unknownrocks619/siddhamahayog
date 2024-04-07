@php
    $missingFamilyProfile = []
@endphp

<tr id="groupPeople_{{$people->getKey()}}" data-action="{{route('admin.program.admin_people_verification',['program' => $people->program_id,'group' => $people->group_id,'people' => $people])}}">
    <th>
        <input @if($people->verified) checked @endif onchange="window.programGroup.userVerification(this)" type="checkbox" name="verify[]" value="{{$people->getKey()}}" />
    </th>
    <td>
        @if($people->is_card_generated)
            <span class="fas fa-start"></span>
        @endif
        {{$people->full_name}}
        <br />
        @if(! $people->is_card_generated)
            <a href="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">Generate Card</a>
        @endif
        @if($people->is_card_generated)
            <a href="{{route('admin.program.amdmin_group_card_view',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">View Family Card</a>
        @endif
    </td>
    <td>
        <div class="list-group">
            @forelse ($people->families as $family)
                @if( ! $family->profile_id) @php $missingFamilyProfile[] = $family->full_name @endphp @endif
                <label class="list-group-item">
                        <span @if(! $family->profile_id) class="text-danger" @endif>
                            {{$family->full_name}}
                        </span>
                </label>
            @empty
                No Family Member
            @endforelse
        </div>
    </td>
    <td class="@if(count($missingFamilyProfile)) bg-danger text-white @else bg-success text-white @endif" >
        @if(count($missingFamilyProfile))
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        @if( ! $people->profile_id )
                            <li>
                                <span >{{$people->full_name}} Profile Photo Is Missing</span>
                            </li>
                        @endif
                        @foreach ($missingFamilyProfile as $family)
                            <li>
                                <span>{{$family}} Profile Photo Is Missing</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <span class="badge label-bg-success">OK</span>
        @endif

    </td>
    <td>
        <a href=""
                 data-bs-toggle='modal'
                 data-bs-role='button'
                 data-bs-target='#newFamily'
                 data-action="{{route('admin.modal.display',['view' => 'programs.groups.new-family','group' => $people->group_id,'member' => $people->member_id,'people' => $people,'layoutView' => 'table'])}}"
                 class="ajax-modal border-end border-1">
                    <i class="fas fa-plus"></i> Add Family
                </a>

                 <a href=""
                    data-bs-toggle='modal'
                    data-bs-role='button'
                    data-bs-target='#selectMember'
                    class="ajax-modal ms-1 border-1 border-end"
                    data-action="{{route('admin.modal.display',['view' => 'programs.groups.family-selection','group' => $people->group_id,'member' => $people->member_id,'people' => $people,'layoutView' => 'table'])}}">
                        <i class="fas fa-refresh"></i>
                        Update Family
                </a>
                
                <a href="{{route('admin.modal.display',['view' => 'programs.groups.dharmasala-booking','people' => $people->getKey(),'group' => $people->group_id])}}"
                    data-action="{{route('admin.modal.display',['view' => 'programs.groups.dharmasala-booking','people' => $people->getKey(),'group' => $people->group_id,'layoutView' => 'table'])}}"
                    data-bs-toggle='modal'
                    data-bs-role='button'
                    data-bs-target='#roomConfirmation'
                    class="ajax-modal ms-2">
                        <i class="fas fa-bed"></i> 
                        @if( ! $people->dharmasala_booking_id) Add Room @else Update Check In @endif
                </a>
        @if($people->is_card_generated)
            <button class="btn btn-danger btn-icon data-confirm ms-2 border-left border-1"
                    data-method="get"
                    data-confirm="Card Has already been generated. Do you wish to reset the card and generate new ?"
                    data-action="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id,'reset' => true])}}" 
                    data-bs-original-titl="Re Generate Card">
                <i class="fas fa-refresh"></i>
            </button>
        @endif
    </td>
</tr>
