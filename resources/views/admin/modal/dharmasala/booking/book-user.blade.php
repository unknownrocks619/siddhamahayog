@php
    $routeParams = [];
    $room = null;
    if ( request()->room ) {
        $room  = \App\Models\Dharmasala\DharmasalaBuildingRoom::where('id',request()->room)->first();
        $routeParams = [
                        'room' => $room->getKey(),
                    ];
        if ( $room->floor_id && $room->booking_id) {
            $routeParams['booking'] = $room->booking_id;
            $routeParams['floor'] = $room->floor_id;
        }

    }
@endphp

<form method="post" class="ajax-append ajax-form" action="{{route('admin.dharmasala.booking.create',$routeParams)}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Confirm Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            @if( ! $room )
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_number">Select Room<sup class="text-danger">*</sup></label>
                    <select name="room_number" id="room_number" data-method="get" data-action="{{route('admin.select2.dharmasala.room.list')}}" class="ajax-select-2 form-control"></select>
                </div>
            </div>
            @else
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_number">Selected Room<sup class="text-danger">*</sup></label>
                    <input value="{{$room->room_number}}" type="text" name="room_number" id="room_number" disabled class="disabled form-control"  />
                </div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_capacity">Amenities</label>
                    <input type="number" name="room_capacity" id="room_capacity" class="form-control">
                </div>
            </div>
        </div>
        <div class="row d-none" id="selected-result-input">

        </div>
        <div class="row my-3 border py-3" id="selectedUser">
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">
                    Select User
                </div>
                <input data-result="admin.modal.dharmasala.booking.users" data-action="{{route('admin.dharmasala.booking-user-list')}}" type="text" placeholder="Search Member by Email or phone" name="member" id="memberSearchField" class="form-control" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="search_result">
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @if(request()->ajax())
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        @endif
        <button type="submit" class="btn btn-primary">Confirm Booking</button>
    </div>
</form>
@if( request()->ajax() )
<script>
    window.memberSearchFunction();
    $(document).on('click','.btn-remove-user', function (event) {
        event.preventDefault();
        let _getMemberID = $(this).attr('data-member');
        $(this).closest('.selected-user').remove();

        // also remove from input
        $('#selected-result-input').find('.selected_member_'+_getMemberID).remove();
    });

</script>
@endif
