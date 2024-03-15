
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
                <input type="hidden" name="family_confirmation" value="1" class="form-control d-none" />
                <input type="hidden" name="program_enroll" value="1" class="form-control d-none" />

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="program_name" class="fs-3">Please Confirm Family Information
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="mt-2">
                        <button type="button" onclick="window.memberRegistration.programFamilyMember()" class="btn btn-primary ">
                            <i class="fas fa-plus me-1"></i> Add Family Member
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="row" id="familyMembers">
            @foreach ($member->emergency_contact()->with('profileImage')->where('contact_type','family')->get() as $familyMember)
                <div class='col-md-12 wrapper-clone'>
                    <div class='row'>
                        <div class="col-md-7 border-top mt-3">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="full_name">Full Name
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input @if($familyMember->confirmed_family) readonly @endif type="text" value="{{$familyMember->contact_person}}" name="full_name[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="relation">Relation
                                        <sup class="text-danger">*</sup>
                                        </label>
                                        <input  @if($familyMember->confirmed_family) readonly @endif type="text" value="{{$familyMember->relation}}" name="relation[]" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="form-group">
                                        <label for="">Gotra
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input  @if($familyMember->confirmed_family) readonly @endif type="text" value="{{$familyMember->gotra}}" name="gotra[]"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="form-group">
                                        <label for="">Phone Number
                                        <sup class="text-danger">*</sup>
                                        </label>
                                        <input  @if($familyMember->confirmed_family) readonly @endif type="text" value="{{$familyMember->phone_number}}" name="phone_number[]"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="form-group">
                                        <label for="">Dikshya Type
                                        <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="dikshya_type[{{$loop->index}}][]" multiple class="form-control">
                                            <option value="" @if(! $familyMember->dikshya_type) selected @endif>None</option>
                                            <option @if( in_array('sadhana',explode(',',$familyMember->dikshya_type))) selected @endif value="sadhana">Sadhana</option>
                                            <option @if( in_array('saranagati',explode(',',$familyMember->dikshya_type)))  selected @endif value="saranagati">Saranagati</option>
                                            <option @if( in_array('tarak',explode(',',$familyMember->dikshya_type)))  selected @endif value="tarak">Tarak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  border-top mt-3">
                            <div class="row mt-3">
                                <div class="col-md-12 ProfileImageWrapper">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label for="family_photo">
                                                ID Photo
                                            </label>
                                            <span
                                        onclick="window.memberRegistration.enableCamera(this,{cameraID: '.ProfileImageWrapper',hideImage : '.media_image_display'})"
                                        class="btn btn-icon btn-primary">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                        </div>
                                        <input type="file" class="form-control" name="family_photo[]" id="family_photo">

                                        <div class="col-md-12 text-end border mt-1">
                                            <video id="webcam" width="640" height="480" class="d-none" autoplay playsinline></video>
                                            <input type="hidden" name="live_family_image[]" class="d-none form-control media_profile_image">

                                            <button
                                                type="button"
                                                class="btn btn-primary btn-icon text-end d-none"
                                                onclick="window.memberRegistration.captureImage(this,{parent:'.ProfileImageWrapper',field : '.media_profile_image',parentHide : true,})">

                                                <i class="fas fa-image"></i>
                                            </button>
                                            <img @if($familyMember->profileImage) src="{{\App\Classes\Helpers\Image::getImageAsSize($familyMember->profileImage?->filepath,'m')}}" @else src="" @endif alt="" class="media_image_display img-fluid @if( ! $familyMember->profileImage) d-none @endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-2  border-top mt-3 d-flex justify-content-end align-items-center'>
                            <button class='btn btn-danger btn-icon' type='button' onclick='window.memberRegistration.removeProgramFamilyMember(this)'><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">
                    Finish
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.select2Options();
</script>
