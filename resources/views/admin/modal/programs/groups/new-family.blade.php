@php
    $member = App\Models\Member::with(['emergency_contact' => function($query){
        $query->where('contact_type','family');
    }])->where('id',request()->get('member'))->first();
    $group = App\Models\ProgramGrouping::where('id',request()->get('group'))->first();
    $people = App\Models\ProgramGroupPeople::where('id',request()->get('people'))->first();
@endphp
<form method="post" class="ajax-form" action="{{route('admin.program.admin_add_family_group',['program' => $group->program_id,'group' => $group,'people' => $people])}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add New Family {{$member->full_name}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-2">
                    <button type="button" onclick="window.memberRegistration.programFamilyMember()" class="btn btn-primary ">
                        <i class="fas fa-plus me-1"></i> Add Family Member
                    </button>
                </div>
            </div>
        </div>
        <div class="row" id="familyMembers">
            <div class='col-md-12 wrapper-clone'>
                <div class='row'>
                    <div class="col-md-7 border-top mt-3">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="full_name">Full Name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="full_name[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="relation">Relation
                                    <sup class="text-danger">*</sup>
                                    </label>
                                    <input  type="text" value="" name="relation[]" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="">Gotra
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input  type="text" value="" name="gotra[]"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="">Phone Number
                                    <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" value="" name="phone_number[]"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="">Dikshya Type
                                    <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="dikshya_type[0][]" multiple class="form-control">
                                        <option value="" >None</option>
                                        <option value="sadhana">Sadhana</option>
                                        <option value="saranagati">Saranagati</option>
                                        <option value="tarak">Tarak</option>
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
                                        <img src="" alt="" class="media_image_display img-fluid  d-none">
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
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-label-secondary" data-bs-dismiss="modal">Save Family Member</button>
    </div>
</form>

<script>
    window.select2Options();
</script>