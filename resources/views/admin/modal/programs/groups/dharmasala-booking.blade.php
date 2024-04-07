<?php
$isInformationMissing = false;
$people = \App\Models\ProgramGroupPeople::with(['families' => function ($query) {
    $query->with('profile','dharmasala');
},'dharmasala'])->find(request()->get('people'));
$group = \App\Models\ProgramGrouping::where('id',request()->get('group'))->first();

$profileID = null;
$rooms = App\Models\Dharmasala\DharmasalaBuildingRoom::with(['building','floor'])->get();

$currentView = 'card';

if (isset($view) ) {
    $currentView = $view;
}

?>
<form action="{{route('admin.program.admin_group_dharamasal',['program' => $group->program_id,'group'=>$group,'people' => $people])}}" method="post" class="ajax-form">
    <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel1">Allot Room to Group {{$people->full_name}}</h5>
        <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body" id="modalParent{{$people->getKey()}}">
        <!-- Dharmasala Room Information -->
        <div class="row mb-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12" data-dropdown="modalParent{{$people->getKey()}}">
                        <div class="form-group">
                            <label for="room_number" class="fs-5">
                                Select Room Number
                                <sup class="text-danger">*</sup>
                            </label>
                            <select  name="room_number" id="room_number" class="form-control fs-5">
                                @foreach ($rooms as $room)
                                    <option value="{{$room->getKey()}}" @if($people->dharmasala?->room_id == $room->getKey()) selected @endif>
                                        {{ $room->building?->building_name}} - {{$room->room_number}} ({{$room->floor?->floor_name}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mt-4">
                        <div class="form-group">
                            <label class="fs-5" for="check_in_date">Check In Date
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="date" name="check_in_date" @if($people->dharmasala?->check_in) value="{{$people->dharmasala?->check_in}}" @endif id="check_in_date" class="form-control fs-5">
                        </div>
                    </div>

                    <div class="col-md-6 mt-4">
                        <div class="form-group">
                            <label class="fs-5" for="check_out_date">
                                Check Out Date
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="date" name="check_out_date"  @if($people->dharmasala?->check_out) value="{{$people->dharmasala?->check_out}}" @endif  id="check_out_date" class="form-control fs-5">
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
                            <span class="form-control fs-5">{{$people->full_name}}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="main_phone_number">
                                Phone Number
                            </label>
                            <span class="form-control fs-5">
                                {{$people->phone_number}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="main_address">
                                Full Address
                            </label>
                            <span class="form-control fs-5">{{$people->address}} </span>
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
                <img src="{{App\Classes\Helpers\Image::getImageAsSize($people->IDCard->filepath,'s')}}" class="img-fluid"/>

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
                <div class="row mt-3 border-bottom pb-3">
                    <div class="col-md-1 ">
                        <span class="btn btn-icon btn-danger ms-2">#{{$loop->iteration}}</span>
                        <div class="input-group-text border-0">
                            <input data-target=".family_check_row_{{$family->getKey()}}" class="form-check-input mt-0 fs-5 family_check_indate" type="checkbox" value="1" checked name="includeFamily[{{$family->getKey()}}]" aria-label="Checkbox for following text input">
                        </div>
                    </div>
                    <div class="col-md-7">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="main_full_name">Full Name</label>
                                    <span class="form-control fs-5">{{$family->full_name}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="main_phone_number">
                                        Phone Number
                                    </label>
                                    <span class="form-control fs-5">
                                        {{$family->phone_number}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="main_address">
                                        Relation
                                    </label>
                                    <span class="form-control fs-5">{{$family->parent_relation}} </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 d-none family_check_row_{{$family->getKey()}}">
                            <div class="row my-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="room_number" class="fs-5">
                                            Select Room Number
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select  name="family_room_number[{{$family->getKey()}}]" id="room_number_{{$family->getKey()}}" class="form-control fs-5">
                                            @foreach ($rooms as $room)
                                                <option value="{{$room->getKey()}}">
                                                    {{ $room->building?->building_name}} - {{$room->room_number}} ({{$room->floor?->floor_name}})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fs-5" for="family_check_{{$family->getKey()}}">Check In Date</label>
                                    <input type="date" name="family_check_in_date[{{$family->getKey()}}]" id="family_check_{{$family->getKey()}}" class="form-control fs-5">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fs-5" for="family_check_out_{{$family->getKey()}}">Check Out Date</label>
                                    <input type="date" name="family_check_out_date[{{$family->getKey()}}]" id="family_check_out_{{$family->getKey()}}" class="form-control fs-5">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        @if( ! $family->profile_id)
                        @php($isInformationMissing==true)
                            <h4 class="text-danger">Please Upload User Photo to Confirm Booking</h4>
                        @else
                            <img src="{{App\Classes\Helpers\Image::getImageAsSize($family->profile->filepath,'s')}}" class="img-fluid"/>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                @if($isInformationMissing)
                    <span class="text-danger mr-5">Some of the required information is missing from group.
                        Do you still wish to force room registration ?
                    </span>
                @endif
                <button class="btn btn-primary">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</form>
<script>

$('.family_check_indate').change(function() {

    let _targetElm = $($(this).attr('data-target'));
    if ( $(this).is(':checked') ) {
        $(_targetElm).addClass('d-none');
    } else {
        $(_targetElm).removeClass('d-none');
    }

})

window.select2Options();
</script>
