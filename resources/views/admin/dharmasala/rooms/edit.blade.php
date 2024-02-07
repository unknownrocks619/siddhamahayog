@php
    $buildings = [];
    $floors = [];
    if ($room->building_id) {
        $buildings = \App\Models\Dharmasala\DharmasalaBuilding::where('id',$room->building_id)->get();
    }

    if ($room->floor_id) {
        $floors = \App\Models\Dharmasala\DharmasalaBuildingFloor::where('id',$room->floor_id)->get();
    }

@endphp
@extends('layouts.admin.master')

@push('page_title','Dharmasala > Room > Edit')

@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Dharmasala / <a href="{{route('admin.dharmasala.rooms.list')}}">Rooms</a> </span> / Edit-{{$room->room_number}}
    </h4>
    <!-- Responsive Datatable -->
    <div class="row my-1">
        <div class="col-md-12 text-end">
            <a href="{{route('admin.dharmasala.rooms.list')}}" class="btn btn-icon btn-danger" ><i class="fas fa-arrow-left"></i> </a>
        </div>
    </div>
    <form action="{{route('admin.dharmasala.room.edit',['room'=>$room])}}" method="post" class="ajax-form">
        <div class="card">
            <div class="card-body">
                <div class="row div col-md-12 alert alert-danger">
                    Please Note: Chaning the room number will not change already allocated information in booking table.
                    If you want to udpate Room information for already booked user, please use booking table to edit their details.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="room_number">Room Number<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{$room->room_number}}" name="room_number" id="room_number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="room_capacity">Room Capacity</label>
                            <input type="number" value="{{$room->room_capacity}}" name="room_capacity" id="room_capacity" class="form-control">
                        </div>
                    </div>
                </div>
        
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="building_selection_to_room">Building</label>
                            <select
                                    data-action="{{route('admin.select2.dharmasala.building.list')}}"
                                    name="building"
                                    id="building_selection_to_room"
                                    class="form-control ajax-select-2">
                                <option value="">Please Select Building</option>
                                @foreach($buildings as $dharmashalaBuilding)
                                    <option value="{{$dharmashalaBuilding->getKey()}}" @if($room->building_id == $dharmashalaBuilding->getKey()) selected @endif>{{$dharmashalaBuilding->building_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="floor_selection_to_room">Floor</label>
                            <select name="floor" id="floor_selection_to_room" class="form-control no-select-2">
                                <option value="">Please Select Building First</option>
                                @foreach($floors as $floor)
                                    <option value="{{$floor->getKey()}}" @if($room->floor_id == $floor->getKey()) selected @endif>{{$floor->floor_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="amenities">Amenities</label>
                                <select multiple name="amenities[]" id="amenities" class="form-control">
                                    @foreach(App\Models\DharmasalaAmenity::get() as $amenity)
                                        <option value="{{$amenity->getKey()}}" @if(in_array($amenity->getKey(), $room->amenities ?? [])) selected @endif>{{$amenity->amenity_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Update Room Information</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection