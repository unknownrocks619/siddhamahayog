@php
    $routeParams = [];
    $building = null;
    $floor = null;
    if (request()->building) {
        $building = \App\Models\Dharmasala\DharmasalaBuilding::where('id',request()->building)->first();
        $routeParams['building'] = $building->getKey();
    }

    if (request()->floor) {
        $floor = \App\Models\Dharmasala\DharmasalaBuildingFloor::where('id',request()->floor)->first();
        $routeParams['floor'] = $floor->getKey();
    }

@endphp
<form method="post" class="ajax-append ajax-form" action="{{route('admin.dharmasala.rooms.create',$routeParams)}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Room Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_number">Room Number<sup class="text-danger">*</sup></label>
                    <input type="text" name="room_number" id="room_number" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_capacity">Room Capacity</label>
                    <input type="number" name="room_capacity" id="room_capacity" class="form-control">
                </div>
            </div>
        </div>

        <div class="row mt-3">
                @if( ! $building )
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="building_selection_to_room">Building</label>
                            <select
                                    data-action="{{route('admin.select2.dharmasala.building.list')}}"
                                    name="building"
                                    id="building_selection_to_room"
                                    class="form-control ajax-select-2">
                                <option value="">Please Select Building</option>
                                @foreach(\App\Models\Dharmasala\DharmasalaBuilding::get() as $dharmashalaBuilding)
                                    <option value="{{$dharmashalaBuilding->getKey()}}">{{$dharmashalaBuilding->building_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
               @endif
                @if ( ! $floor )
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="floor_selection_to_room">Floor</label>
                            <select name="floor" id="floor_selection_to_room" class="form-control no-select-2">
                                <option value="">Please Select Building First</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="enable_booking">Enable Booking</label>
                    <select name="enable_booking" id="enable_booking" class="form-control">
                        @foreach (\App\Models\Dharmasala\DharmasalaBuildingRoom::ROOM_STATUS as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_type">Room Type</label>
                    <select name="room_type" id="room_type" class="form-control">
                        @foreach(\App\Models\Dharmasala\DharmasalaBuildingRoom::ROOM_TYPES as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_category">Room Category</label>
                    <select name="room_category" id="room_category" class="form-control">
                        @foreach (\App\Models\Dharmasala\DharmasalaBuildingRoom::ROOM_CATEGORY as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="online_booking">Enable Online Booking</label>
                    <select name="online_booking" id="online_booking" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>

        @if(App\Models\DharmasalaAmenity::count())
            <div class="row mt-5" data-dropdown="addRoom">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="amenities">Amenities</label>
                        <select multiple name="amenities[]" id="amenities" class="form-control">
                            @foreach(App\Models\DharmasalaAmenity::get() as $amenity)
                                <option value="{{$amenity->getKey()}}">{{$amenity->amenity_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add New Room</button>
    </div>
</form>

@if(request()->ajax())
    <script>
        window.select2Options();
    </script>
@endif