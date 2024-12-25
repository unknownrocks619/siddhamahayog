@php
    if ( ! isset ($member) ) {
        $member = null;
    }
@endphp
<div class="row mt-3">
    <div class="{{$dharmasala== true ? 'col-md-7' : 'col-md-12'}} mx-auto">

        @if($member)
            <input type="hidden" name="memberID" value="{{$member->getKey()}}" class="form-control d-none" />
            <input type="hidden" name="existing_member" value="1" class="form-control d-none" />
        @endif

        <div class="card">
            <div class="card-body">
                <!-- 1. Delivery Address -->
                <h4 class="mb-4 text-danger">Personal Info</h4>

                <div class="row g-3 m-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="first_name">
                                First Name
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" value="{{$member?->first_name}}" id="first_name" name="first_name" class="form-control" placeholder="First Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="middle_name">Middle Name</label>
                            <input type="text" value="{{$member?->middle_name}}" id="middle_name" name="middle_name" class="form-control" placeholder="Middle Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="last_name">
                                Last Name
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" id="last_name" value="{{$member?->last_name}}" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                </div>

                <div class="row g-3 m-3">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="date_of_birth">
                                Date of Birth
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="date" name="date_of_birth" value="{{$member?->date_of_birth}}" id="date_od_birth" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="phone">
                                Gender
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="male" @if($member?->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if($member?->gender == 'female') selected @endif>Female</option>
                                <option value="other" @if($member?->gender == 'other') selected @endif>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="phone_number">
                                Phone Number
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" id="phone_number" @if($member && $member->phone_number) disabled @endif value="{{$member?->phone_number}}" name="phone_number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row g-3 m-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gotra">Gotra
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" value="{{$member?->gotra}}" name="gotra" id="gotra" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="role" id="role" class="form-control select2">
                                @foreach(\App\Models\Role::$roles as $key => $role)
                                    @continue(in_array($key,array_merge(\App\Models\Role::CENTER_USER_ADD_LIST,\App\Models\Role::ADMIN_DASHBOARD_ACCESS,[\App\Models\Role::CENTER])))
                                    <option value="{{$key}}" @if($member?->role_id == $key || $key == \App\Models\Role::MEMBER ) selected @endif>{{$role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-3 m-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="country" id="country" class="form-control">
                                @foreach (\App\Models\Country::get() as $country)
                                    <option value="{{$country->getKey()}}" @if($country->getKey() == 153 || $member?->country == $country->getKey()) selected @endif>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City / State / Province
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" name="city" id="city" class="form-control" value="{{$member?->city}}">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="address">Street Address
                            <sup class="text-danger">*</sup>
                        </label>
                        <textarea name="address" class="form-control" id="address" rows="2" placeholder="1456, Mall Road">{{$member?->address?->street_address}}</textarea>
                    </div>
                </div>

                @if( ! $member )
                    <div class="row m-3 g-3">
                        <label class="form-check-label fs-4">
                            Enable Online Login
                            <sup class="text-danger">*</sup>
                        </label>

                        <div class="col mt-2">
                            <div class="form-check form-check-inline">
                                <input name="enable_login" onchange="window.memberRegistration.enableOnlineLogin(this)" class="form-check-input" type="radio" value="1" id="enable-online-login-yes" checked="">
                                <label class="form-check-label fs-4" for="enable-online-login-yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="enable_login" onchange="window.memberRegistration.enableOnlineLogin(this)" class="form-check-input" type="radio" value="0" id="enable-online-login-yes-no">
                                <label class="form-check-label fs-4" for="enable-online-login-no"> No </label>
                            </div>
                        </div>
                    </div>

                    <div class="row m-3 g-3 d-flex align-items-center bg-lighter">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email
                                </label>
                                <input type="text" name="email" id="email" @if($email) value="{{$email}}"  @endif @if($member) disabled @endif class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row m-3 g-3" id="passwordFields">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password">
                                            Password
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        Confirm Password
                                        <sup class="text-danger">*</sup>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirm" class="form-control" />
                                </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-start">
                                    <label class="form-check-label me-1">Email Password </label>
                                    <div class="form-check form-check-inline">
                                        <input name="email_user" class="form-check-input" type="radio" value="1" id="email-password-yes" checked="">
                                        <label class="form-check-label" for="email-password-yes"> Yes </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="email_user" class="form-check-input" type="radio" value="0" id="email-password-no">
                                        <label class="form-check-label" for="email-password-no"> No </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                @endif

                @if($member )
                    <div class="row m-3 g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="email" id="email" value="{{$member->email}}" disabled class="form-control">
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="card-footer ">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-light submit-button">
                            Register
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if($dharmasala == true)

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <h4 class="mb-4 text-danger">3. Room Verification</h4>
                        </div>
                    </div>

                    <div class="row gy-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="room_number" class="mb-2">Room Number</label>
                                <select name="room_number" id="room_number"
                                        class="form-control">
                                    @foreach (\App\Models\Dharmasala\DharmasalaBuildingRoom::where('is_available',true)->get() as $room)
                                        <option value="{{$room->getKey()}}">{{$room->room_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-3 mt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_card" class="d-flex justify-content-between align-items-center">
                                <span>
                                    ID Card
                                    @if( ! $member || !$member?->memberIDMedia)
                                        <sup class="text-danger">*</sup>
                                    @endif
                                </span>
                                    <span>
                                    <button type="button" onclick="window.memberRegistration.enableCamera(this,{'cameraID' : '#idCameraContainer',hideImage : '.id-card-preview-tag'})" class="btn btn-primary btn-icon">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </span>
                                </label>
                                <div  id="id_card_upload">
                                    <input type="file" name="id_card" id="id_card" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <img class="id-card-preview-tag @if( ! $member && !$member->memberIDMedia) d-none @endif img-fluid" style="max-height:300px;" src="@if($member && $member->memberIDMedia) {{\App\Classes\Helpers\Image::getImageAsSize($member->memberIDMedia->filepath,'s')}} @endif" />
                        <div class="col-md-12 text-end d-none videoContainer" id="idCameraContainer">
                            <video class="border" style="min-height: 300px; min-width: 100%"></video>
                            <div class="my-2 d-none" id="id_card_picture">
                                <input type="hidden" name="id_card_image" id="id_card" class="form-control id_card_image" />
                            </div>

                            <button class="btn btn-primary btn-sm" type="button" onclick="window.memberRegistration.captureImage(this,{parent: '#idCameraContainer', field : '.id_card_image',displayImage: '.id-card-preview-tag'})"> Capture Image</button>
                        </div>
                    </div>
                    <hr />
                    <!-- Live Photo -->
                    <h4 class="mt-3 text-danger">4. Live Photo
                        <sup class="text-danger">*</sup>
                    </h4>

                    <div class="row gy-3 m-3 live_web_cam_capture">
                        <div class="col-md-12">
                            <div id="cameraArea" class="border">
                                <video id="webcam" width="640" height="480" autoplay playsinline></video>
                            </div>
                            <h4 class="text-center">Webcam Preview</h4>
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" type="button" onclick="window.memberRegistration.enableCamera(this,{cameraID: '.live_web_cam_capture'})">
                                Start Camera
                            </button>
                            <button class="btn btn-danger capture-image" type="button" onclick="window.memberRegistration.captureImage(this,{parent:'.live_web_cam_capture',field : '.live_web_cam_image',parentHide : true})">
                                Capture Image
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div id="cameraCapture" class="border" style="min-height: 300px; min-width: 100%">
                                <img class="d-none img-fluid" style="max-height:300px;" src="" />
                                <input type="hidden" name="live_webcam_image" class="form-control live_web_cam_image" />

                            </div>
                            <h4 class="text-center">Captured Image</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-2 text-center"></div>
                        <div class="col-md-4 text-end d-none" id="idCameraContainer">
                            <div id="idCameraCapture" class="border" style="min-height: 300px; min-width: 100%"></div>
                            <h4 class="text-center">ID Card</h4>
                        </div>
                    </div>
                    <hr />
                    <!-- / Live Photo -->
                    <div class="d-flex justify-content between align-items-center">
                        <h4 class="my-4 text-danger">
                            5. Family & Friends
                        </h4>
                        <button type="button" class="btn btn-primary btn-icon" onclick="window.memberRegistration.addMoreMembers()"><i class="fas fa-plus"></i></button>
                    </div>
                    <div id="familyMembers"></div>
                </div>
            </div>
        </div>
    @endif
</div>

@if(request()->ajax())
    <script>
        $('.step_one_search_option').hide();
    </script>
@endif
