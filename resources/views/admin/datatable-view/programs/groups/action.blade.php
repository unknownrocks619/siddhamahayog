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
            <a href="#" class="text-danger data-confirm ms-2 border-left border-1"
                    data-method="get"
                    data-confirm="Card Has already been generated. Do you wish to reset the card and generate new ?"
                    data-action="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id,'reset' => true])}}" 
                    data-bs-original-titl="Re Generate Card">
                <i class="fas fa-refresh"></i>
                Regenerate
            </a>
        @endif
        <a href="#" class="text-danger data-confirm ms-2 border-left border-1"
            data-method="post"
            data-confirm="You are about to perform delete action. This will also remove all families associated with this user. Note: All generated card will be instantly invalid."
            data-action="{{route('admin.program.admin_remove_member_from_group',['people' => $people,'program' => $people->program_id,'group' => $people->group_id,'reset' => true])}}" 
            data-bs-original-titl="Re Generate Card">
            <i class="fas fa-trash"></i>
            Delete
        </a>
