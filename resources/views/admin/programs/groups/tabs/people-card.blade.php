@php
    $missingFamilyProfile = []
@endphp
<div class="col-md-4">
    <div class="card" id="groupPeople_{{$people->getKey()}}">
        <div class="card-alert"></div>
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">
                    {{$people->full_name}}
                </h5>
                <a href="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">Generate Card</a>
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
                        <i class="fas fa-bed"></i> Add Room
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
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li>
                            @if( ! $people->profile_id )
                                <span class="text-danger">{{$people->full_name}} Profile Photo Is Missing</span>
                            @endif
                        </li>
                        @foreach ($missingFamilyProfile as $family)
                            <li>
                                <span class="text-danger">{{$family}} Profile Photo Is Missing</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
