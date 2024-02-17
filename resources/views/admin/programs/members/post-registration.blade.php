
<div class="card">
        <div class="card-body">
            @php /**  @todo Remove Registration Code After Hanumand Yagya  **/ @endphp

            <div class="row my-5">
                <div class="col-md-12 fs-2 alert alert-danger text-center">
                    Registration Code: {{$member->getKey()}}
                </div>
            </div>
            <div class="row d-none">
                <div class="col-md-12">
                    <input type="hidden" name="memberID" value="{{$member->getKey()}}" class="form-control d-none" />
                    <input type="hidden" name="exisiting_member" value="1" class="form-control d-none" />
                    <input type="hidden" name="program_enroll" value="1" class="form-control d-none" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="program_name">Select Program
                            <sup class="text-danger">*</sup>
                        </label>

                        <select name="program" id="program_name" class="form-control">
                            <option value="" disabled>Select Program</option>
                            @foreach (App\Models\Program::get() as $program)
                                <option @if($program->getKey() == 5) selected @endif value="{{$program->getKey()}}">{{$program->program_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <span for="id_card" class="d-flex justify-content-between mb-2">
                            <span>
                                ID Card
                                {{-- <sup class="text-danger">*</sup> --}}
                            </span>
                            <span onclick="window.memberRegistration.enableCamera(this,{cameraID: '.id_card_camera_wrapper',hideImage : '.id_card_display'})" class="btn btn-icon btn-primary">
                                <i class="fas fa-camera"></i>
                            </span>
                        </span>
                        <input type="file" name="id_card" id="id_card" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <span for="profile" class="d-flex justify-content-between mb-2">
                            <span>
                                Profile Picture
                                {{-- <sup class="text-danger">*</sup> --}}
                            </span>

                            <span
                            onclick="window.memberRegistration.enableCamera(this,{cameraID: '#ProfileImageWrapper',hideImage : '.media_image_display'})"
                            class="btn btn-icon btn-primary">
                                <i class="fas fa-camera"></i>
                            </span>
                        </span>
                        <input type="file" name="profile_image" id="profile" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mt-4 ">
                <div class="col-md-6 text-end">
                    <div id="IDCardImageWrapper" class=" d-none id_card_camera_wrapper">
                        <input type="hidden" name="id_card_image" class="d-none id_card_image_link">
                        <video id="webcam" width="640" height="480" autoplay playsinline></video>
                            <button type="button" class="btn btn-primary btn-icon text-end"
                            onclick="window.memberRegistration.captureImage(this,{parent:'.id_card_camera_wrapper',field : '.id_card_image_link',parentHide : false,displayImage : '.id_card_display'})"
                        >
                            <i class="fas fa-image"></i>
                        </button>
                    </div>
                    <img src="@if($member?->memberIDMedia){{\App\Classes\Helpers\Image::getImageAsSize($member?->memberIDMedia->filepath,'m')}}@endif" alt="" class="id_card_display img-fluid @if( ! $member?->memberIDMedia) d-none @endif" style="max-width: 640px;">
                </div>
                <div class="col-md-6 text-end">
                    <div id="ProfileImageWrapper" class="d-none">
                        <video id="webcam" width="640" height="480" autoplay playsinline></video>
                        <input type="hidden" name="live_webcam_image" class="d-none form-control media_profile_image">

                        <button
                            type="button"
                            class="btn btn-primary btn-icon text-end"
                            onclick="window.memberRegistration.captureImage(this,{parent:'#ProfileImageWrapper',field : '.media_profile_image',parentHide : false,displayImage : '.media_image_display'})">

                            <i class="fas fa-image"></i>
                        </button>

                    </div>
                    <img src="@if($member?->profileImage){{\App\Classes\Helpers\Image::getImageAsSize($member?->profileImage->filepath,'m')}}@endif" alt="" class="media_image_display @if(!$member?->profileImage) d-none @endif" style="max-width: 640px;">

                </div>
            </div>

            <!-- Payment Option -->

            <div class="row my-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="voucher_type">Voucher Type
                            <sup class="text-danger">*</sup>
                        </label>
                        <select onchange="window.selectElementChange(this,'voucher_type')"  name="voucher_type" id="voucher_type" class="form-control">
                            <option selected value="voucher_entry">Voucher Entry</option>
                            <option value="voucher_upload">Bank Voucher</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 voucher_type voucher_entry">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="voucher_number">Voucher Number
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="voucher_number" id="voucher_number" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="voucher_type_upload">Upload Voucher</label>
                                <input type="file" name="voucher" id="voucher_type_upload" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-none voucher_type voucher_upload">
                    <div class="form-group">
                        <label for="voucher_number">Bank Voucher Upload
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="file" name="bank_voucher" id="voucher_number" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount">Amount
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="amount" id="amount" class="form-control" />
                    </div>
                </div>
            </div>

            <!-- / Payment Option -->
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Payment Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
