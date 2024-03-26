<?php
$isInformationMissing = false;
$people = \App\Models\ProgramGroupPeople::with(['families' => function ($query) {
    $query->with('profile');
}])->find(request()->get('people'));
$group = \App\Models\ProgramGrouping::where('id',request()->get('group'))->first();

$profileID = null;
$rooms = App\Models\Dharmasala\DharmasalaBuildingRoom::with(['building','floor'])->get();
?>
    <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel1">Allot Room to Group {{$people->full_name}}</h5>
        <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

<div class="modal-body">
    <!-- Dharmasala Room Information -->
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="room_number">
                            Select Room Number
                            <sup class="text-danger">*</sup>
                        </label>
                        <select name="room_number" id="room_number" class="form-control">
                            @foreach ($rooms as $room)
                                <option value="{{$room->getKey()}}">
                                    {{ $room->building?->building_name}} - {{$room->room_number}} ({{$room->floor?->floor_name}})
                                </option>
                            @endforeach
                        </select>
                    </div>        
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="check_in_date">Check In Date
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="date" name="check_in_date" id="check_in_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="check_out_date">
                            Check In Date
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="date" name="check_out_date" id="check_out_date" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <!-- Avaibility Info -->
        <div class="col-md-4">
            
        </div>
    </div>

    <!-- People & Family Information -->
    <div class="row border-top pt-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="main_full_name">Full Name</label>
                        <span class="form-control fs-4">{{$people->full_name}}</span>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_phone_number">
                            Phone Number
                        </label>
                        <span class="form-control fs-4">
                            {{$people->phone_number}}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_address">
                            Full Address
                        </label>
                        <span class="form-control fs-4">{{$people->address}} </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-end">
            @if( ! $people->profile_id)
                @php($isMissingInformation=true)
                <h4 class="text-danger">Please Upload User Photo to Confirm Booking</h4>
            @else
                <img src="{{App\Classes\Helpers\Image::getImageAsSize($people->profile->filepath,'s')}}" class="img-fluid"/>
            @endif
        </div>
        <div class="col-md-3 text-end d-flex justify-content-center align-items-center">
            @if( ! $people->member_id_card)
            @php($isMissingInformation=true)
                <h4 class="text-danger">ID Card Not Found</h4>
            @else
            <img src="{{App\Classes\Helpers\Image::getImageAsSize($people->profile->filepath,'s')}}" class="img-fluid"/>

            @endif
        </div>
    </div>

    @if ($people->families()->count())
        <!-- Family -->
        <div class="row mt-3">
            <div class="col-md-12 bg-light text-center">
                <h4>Family Information</h4>
            </div>
        </div>
        @foreach ($people->families as $family)
            <div class="row mt-3">
                <div class="col-md-1 ">
                    <span class="btn btn-icon btn-danger">#{{$loop->iteration}}</span>
                    <div class="input-group-text border-o">
                        <input class="form-check-input mt-0 fs-4" type="checkbox" value="" aria-label="Checkbox for following text input">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="main_full_name">Full Name</label>
                                <span class="form-control fs-4">{{$family->full_name}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="main_phone_number">
                                    Phone Number
                                </label>
                                <span class="form-control fs-4">
                                    {{$family->phone_number}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="main_address">
                                    Relation
                                </label>
                                <span class="form-control fs-4">{{$family->parent_relation}} </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    @if( ! $family->profile_id)
                    @php($isMissingInformation=true)
                        <h4 class="text-danger">Please Upload User Photo to Confirm Booking</h4>
                    @else
                        <img src="{{App\Classes\Helpers\Image::getImageAsSize($people->profile->filepath,'s')}}" class="img-fluid"/>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="modal-footer">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            @if($isMissingInformation==true)
                <span class="text-danger mr-5">Some of the required information is missing from group. 
                    Do you still wish to force room registration ?
                </span>
            @endif
            <button class="btn btn-primary">
                Save Dharmasala Info
            </button>
        </div>
    </div>
</div>