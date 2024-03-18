<div class="col-md-4">
    <div class="card" id="groupPeople_{{$people->getKey()}}">
        <div class="card-alert"></div>
        <div class="card-header">
            <h5 class="card-title">{{$people->full_name}}</h5>

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

                <a href="" 
                    data-bs-toggle='modal' 
                    data-bs-role='button' 
                    data-bs-target='#room-confirmation' 
                    class="ajax-modal">
                        <i class="fas fa-bed"></i> Add Room
                </a>
            </div>
        </div>
        <div class="card-body">
            <h6 class="text-light">Family Info</h6>
            <div class="list-group">
                @foreach ($people->families as $family)
                <label class="list-group-item">
                    <input class="form-check-input me-1" type="checkbox" value="">
                        {{$family->full_name}}
                </label>
                @endforeach
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
