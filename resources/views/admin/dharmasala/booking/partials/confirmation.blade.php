@php use App\Models\Dharmasala\DharmasalaBooking; @endphp
@php
    /** @var  DharmasalaBooking $booking */
    $disabled = false;
    if(in_array($booking->status,[
                                DharmasalaBooking::CHECKED_IN,
                                DharmasalaBooking::CHECKED_OUT,
                                DharmasalaBooking::RESERVED,
                                DharmasalaBooking::BOOKING])) {
        $disabled = true;
    }
@endphp
<div class="card">
    <div
        class="card-header @if($disabled) d-flex justify-content-between  @endif">
        <h4 class="mb-0">
            Check In For `{{ $booking->full_name }}`
        </h4>
        @if($disabled)
            <span>
                <a href="#" id="enableFields" onclick="window.dharmasalaBooking.enableAllBookingFields(this,'{{$booking->getKey()}}')"><i class="fas fa-pencil"></i> Enable Edit</a>
            </span>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="room_number">
                        Room Number
                        <sup class="text-danger">*</sup>
                    </label>
                    <select @if($disabled) disabled @endif onchange="window.dharmasalaBooking.updateBookingInfo(this,{{$booking->getKey()}})"
                            name="room_number" id="room_number" class="form-control">
                        <option value="" disabled selected>Please Select Room Number</option>
                        @foreach (App\Models\Dharmasala\DharmasalaBuildingRoom::get() as $dharmasalaRoom)
                            <option
                                @if($booking->room_number && $dharmasalaRoom->getKey() == $booking->room_id)
                                    selected
                                @elseif( ! $booking->room_number && $booking->id_parent && $booking->parentBooking?->room_number && $dharmasalaRoom->getKey() == $booking->parentBooking?->room_id) selected
                                @endif
                                value="{{$dharmasalaRoom->getKey()}}">{{ $dharmasalaRoom->room_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="check_in">
                        Check In
                        <sup class="text-danger">*</sup>
                    </label>
                    <input @if($disabled) disabled @endif type="datetime-local"
                           onchange="window.dharmasalaBooking.updateBookingInfo(this,{{$booking->getKey()}})"
                           value="{{$booking->check_in ? $booking->check_in .' '. $booking->check_in_time : date("Y-m-d H:i")}}"
                           name="check_in" id="check_in" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="check_in">Check Out</label>
                    <input @if($disabled) disabled @endif type="datetime-local"
                           onchange="window.dharmasalaBooking.updateBookingInfo(this,{{$booking->getKey()}})"
                           name="check_out"
                           @if($booking->check_out) value="{{$booking->check_out .' '.$booking->check_out_time}}"
                           @endif id="check_out" class="form-control">
                </div>
            </div>
        </div>

        @if( ! $booking->id_parent && $booking->getChildBookings->count())
            <div class="row my-3">
                <div class="col-md-12">
                    <b>Total Number People: </b>
                    {{$booking->getChildBookings->count()}} People
                </div>
            </div>
        @endif

        @if($booking->id_parent )
            <div class="row my-3">
                <div class="col-md-12">
                    <b>Contact Person</b>
                    {{$booking->parentBooking->full_name}}
                </div>
            </div>
        @endif

        <div class="row border-top">
            <div class="col-md-12">
                <h5>Live Image</h5>
                <div class="row gy-3 m-3 live_photo_web_cam_capture d-none">
                    <div class="col-md-12">
                        <div class="border w-100">
                            <video id="webcam" width="100%" height="280" autoplay playsinline></video>
                        </div>
                        <h4 class="text-center">Webcam Preview</h4>
                        <button @if($disabled) disabled @endif class="btn btn-danger capture-image"
                                type="button"
                                onclick="window.dharmasalaBooking.captureImage(this,'{{$booking->getKey()}}',{parent:'.live_photo_web_cam_capture',field : '.id_card_image',displayImage: '.live_profile_display_image'})">
                            Capture Image
                        </button>
                    </div>
                    <input @if($disabled) disabled @endif onchange="window.dharmasalaBooking.updateBookingInfo(this,'{{$booking->getKey()}}')"
                           type="hidden" name="captured_id_card" class="live_media_image form-control d-none">
                </div>
                @if($booking->profileImage)
                    <img src="{{App\Classes\Helpers\Image::getImageAsSize($booking->profileImage->filepath,'m')}}"
                         class="img-fluid live_profile_display_image"/>
                @else
                    <img src="{{asset('no-image.png')}}" class="img-fluid live_profile_display_image"/>
                @endif
            </div>
            <div class="col-md-12 my-2 text-end">
                <button @if($disabled) disabled @endif class="btn btn-icon btn-primary">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
        </div>

        <div class="row border-top">
            <div class="col-md-12">
                <h5>ID Card</h5>
                <div class="row gy-3 m-3 live_web_cam_capture d-none">
                    <div class="col-md-12">
                        <div id="cameraArea" class="border w-100">
                            <video id="webcam" width="100%" height="280" autoplay playsinline></video>
                        </div>
                        <h4 class="text-center">Webcam Preview</h4>
                        <button @if($disabled) disabled @endif class="btn btn-danger capture-image" type="button"
                                onclick="window.dharmasalaBooking.captureImage(this,'{{$booking->getKey()}}',{parent:'.live_web_cam_capture',field : '.id_card_image',displayImage: '.id-card-display-image'})">
                            Capture Image
                        </button>
                    </div>
                    <input @if($disabled) disabled @endif onchange="window.dharmasalaBooking.updateBookingInfo(this,'{{$booking->getKey()}}')"
                           type="hidden" name="captured_id_card" class="id_card_image form-control d-none">
                </div>
                @if($booking->idCardImage)
                    <img src="{{App\Classes\Helpers\Image::getImageAsSize($booking->idCardImage->filepath,'m')}}"
                         class="img-fluid w-100 id-card-display-image"/>
                @else
                    <img src="{{asset('no-image.png')}}" class="img-fluid w-100 id-card-display-image"/>
                @endif

            </div>
            <div class="col-md-12 my-2">
                <div class="form-group d-flex justify-content-between">
                    <span>
                        Upload ID Card
                        @if(! $booking->id_parent)
                            <sup class="text-danger">*</sup>
                        @endif
                    </span>
                    <span>
                        <button @if($disabled) disabled @endif class="btn btn-icon btn-primary"
                                onclick="window.dharmasalaBooking.enableCamera(this,'{{$booking->getKey()}}',{cameraID: '.live_web_cam_capture',hideImage : '.id-card-display-image'})">
                            <i class="fas fa-camera"></i>
                        </button>
                    </span>
                </div>
                <input @if($disabled) disabled @endif type="file" name="uploadIDCard" id="uploadIDCard"
                       onchange="window.dharmasalaBooking.uploadMedia(this,'{{$booking->getKey()}}',{preview: '.id-card-display-image'})"
                       class="form-control">
            </div>
        </div>
    </div>
</div>

@if(request()->ajax())
    <script>
        window.dharmasalaBooking.setBooking("{{$disabled}}")
    </script>
@endif
