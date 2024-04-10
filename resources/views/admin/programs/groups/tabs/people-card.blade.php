@php
    $missingFamilyProfile = []
@endphp
<div class="col-3">
    <div class="card" id="groupPeople_{{$people->getKey()}}">
        <div class="card-alert"></div>
        <div class="card-header">
            @if($people->is_card_generated)
                <div class="bg-success text-white p-2 text-center">
                    Card Already Generated
                </div>
            @endif
            <div class="d-flex justify-content-between"  data-action="{{route('admin.program.admin_people_verification',['program' => $people->program_id,'group' => $people->group_id,'people' => $people])}}">
                <input type="checkbox" name="verify[]" value="{{$people->getKey()}}" @if($people->verified) checked @endif onchange="window.programGroup.userVerification(this)" />

                <h5 class="card-title">
                    {{$people->full_name}}
                </h5>
                @if(! $people->is_card_generated)
                    <a href="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">Generate Card</a>
                @endif
                @if($people->is_card_generated)
                    <a href="{{route('admin.program.amdmin_group_card_view',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">View Family Card</a>
                @endif

            </div>

            <div class="d-flex justify-content-between">
                <a href=""
                 data-bs-toggle='modal'
                 data-bs-role='button'
                 data-bs-target='#newFamily'
                 data-action="{{route('admin.modal.display',['view' => 'programs.groups.new-family','group' => $people->group_id,'member' => $people->member_id,'people' => $people])}}"
                 class="ajax-modal">
                    <i class="fas fa-plus"></i> Add Family
                </a>

                 <a href=""
                    data-bs-toggle='modal'
                    data-bs-role='button'
                    data-bs-target='#selectMember'
                    class="ajax-modal"
                    data-action="{{route('admin.modal.display',['view' => 'programs.groups.family-selection','group' => $people->group_id,'member' => $people->member_id,'people' => $people])}}">
                        <i class="fas fa-refresh"></i>
                        Update Family
                </a>
                
                <a href="{{route('admin.modal.display',['view' => 'programs.groups.dharmasala-booking','people' => $people->getKey(),'group' => $people->group_id])}}"
                    data-action="{{route('admin.modal.display',['view' => 'programs.groups.dharmasala-booking','people' => $people->getKey(),'group' => $people->group_id])}}"
                    data-bs-toggle='modal'
                    data-bs-role='button'
                    data-bs-target='#roomConfirmation'
                    class="ajax-modal">
                        <i class="fas fa-bed"></i> 
                        @if( ! $people->dharmasala_booking_id) Add Room @else Update Check In @endif
                </a>
            </div>
        </div>
        <div class="card-body">
            <h6 class="text-light">Family Info</h6>
            <div class="list-group">
                @foreach ($people->families as $family)
                    @if( ! $family->profile_id) @php $missingFamilyProfile[] = $family->full_name @endphp @endif
                    <label class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="">
                            <span @if(! $family->profile_id) class="text-danger" @endif>
                                {{$family->full_name}}
                            </span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="card-footer mt-2 bg-light">
            @if(count($missingFamilyProfile))
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            @if( ! $people->profile_id )
                                <li>
                                    <span class="text-danger">{{$people->full_name}} Profile Photo Is Missing</span>
                                </li>
                                @endif
                            @foreach ($missingFamilyProfile as $family)
                                <li>
                                    <span class="text-danger">{{$family}} Profile Photo Is Missing</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if($people->is_card_generated)
                <div class="row mt-2">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-danger btn-icon data-confirm"
                                data-method="get"
                                data-confirm="Card Has already been generated. Do you wish to reset the card and generate new ?"
                                data-action="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id,'reset' => true])}}" 
                                data-bs-original-titl="Re Generate Card">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
