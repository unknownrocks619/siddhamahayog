export class MemberRegistration {

    additionalMembers = [];
    videoElement = null;
    email = null;
    enableOnlineLogin(elm){
        console.log('hello world');
        let _passwordField = $('#passwordFields');

        if ($(elm).val() == 1) {
            _passwordField.removeClass('d-none')
            _passwordField.find('input[type="password"]').attr('required','required');
        } else {
            _passwordField.addClass('d-none')
            _passwordField.find('input[type="password"]').removeAttr('required');
        }

    }
    addMoreMembers(){
        let _memberRow = `<div class="row border-bottom">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="full_name">Full Name <sup class="text-danger">*</sup></label>
                                                    <input type="text" name="connectorFullName[]" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="relation">Relation <sup class="text-danger">*</sup></label>
                                                    <input type="text" name="relation[]" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="phone_number">Phone Number</label>
                                                    <input type="text" name="relationPhoneNumber[]"
                                                           class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group relation_video_wrapper">
                                            <div class="border">
                                                <video width="100%" style="height: auto;" autoplay playsinline></video>
                                                <img src="" class="d-none img-fluid w-100" style="max-height:480px;" />
                                                <input type="hidden" name="relationImage[]" class="relation_image_capture" >
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="text-end camera-action-button record btn btn-primary btn-icon" type="button" onclick="window.memberRegistration.enableCamera(this,{cameraID:'.relation_video_wrapper'})">
                                                    <i class="fas fa-camera"></i>
                                                </button>
                                                <button type="button" onclick="window.memberRegistration.captureImage(this,{parent:'.relation_video_wrapper',field: '.relation_image_capture'})" class="d-none camera-action-button camera-action-button image btn btn-primary btn-icon">
                                                    <i class="fas fa-image"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                </div>`

        $("#familyMembers").append(_memberRow);

    }

    programFamilyMember(){
        let _memberRow = `
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
                                                    <label for="relation">Relation</label>
                                                    <input type="text" name="relation[]" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="form-group">
                                                    <label for="">Gotra</label>
                                                    <input type="text" name="gotra[]"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="form-group">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" name="phone_number[]"  class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-4">
                                                <div class="form-group">
                                                    <label for="">Dikshya Type</label>
                                                    <select name="dikshya_type[]" class="form-control">
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
                                                        <video id="webcam" width="640" height="480" autoplay playsinline></video>
                                                        <input type="hidden" name="live_family_image[]" class="d-none form-control media_profile_image">

                                                        <button
                                                            type="button"
                                                            class="btn btn-primary btn-icon text-end"
                                                            onclick="window.memberRegistration.captureImage(this,{parent:'.ProfileImageWrapper',field : '.media_profile_image',parentHide : true,})">

                                                            <i class="fas fa-image"></i>
                                                        </button>
                                                        <img src="" alt="" class="media_image_display img-fluid d-none">
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
                        `

        $("#familyMembers").append(_memberRow);

    }

    removeProgramFamilyMember(elm) {
        $(elm).closest('.wrapper-clone').remove();
    }

    enableCamera(elm,params={}) {
        let _this = this;

        if (! navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            Swal.fire({
                title: 'Media plugin Error',
                text: "User media is not supported in this browser",
                icon : 'error'
            })
            return;
        }

        let _videoWrapper = $(elm).closest(params.cameraID);

        if ( ! _videoWrapper.length ) {
           _videoWrapper = $(params.cameraID);
        }
        console.log('ideo camera opera', _videoWrapper);

        $(_videoWrapper).find('video').removeClass('d-none');
        _this.videoElement = $(_videoWrapper).find('video')[0];
        $(_videoWrapper).find('button').removeAttr('disabled').removeClass('d-none');
        $(_videoWrapper).removeClass('d-none');


        // reset previous Image / input.
        $(_videoWrapper).find('img').removeAttr('src').addClass('d-none');
        $(_videoWrapper).find('input').val('');

        // hide image if requested.
        if ($(_videoWrapper).find(params.hideImage).length && params.hideImage) {
            $(_videoWrapper).find(params.hideImage).addClass('d-none');
        } else if (params.hideImage) {
            $(params.hideImage).addClass('d-none')
        }

        // Enable camera Stream.
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream)=> {

                _this.videoElement.srcObject = stream;
                _this.videoElement.play();
            })
            .catch((error) => {

                Swal.fire({
                    title: 'Media / Webcam Error',
                    text: "Error accessing camera:",
                    icon : 'error'
                })
                console.error('Error accessing camera:', error);
            });
    }

    captureImage(elm,params ={}) {

        let _wrapperElement = $(elm).closest(params.parent);
        const canvas = document.createElement('canvas');

        canvas.width = this.videoElement.videoWidth;
        canvas.height = this.videoElement.videoHeight;
        canvas.getContext('2d')
                .drawImage(this.videoElement, 0, 0, canvas.width, canvas.height);

        const image = canvas.toDataURL('image/png',1);
        console.log(_wrapperElement);
        this.postRecord('/admin/dharmasala/bookings/upload-capture-media',{'image': image}).then(function(response) {
            // Assign image path to field.
            if (response.data.params && response.data.params.path) {
                $(_wrapperElement).find(params.field).val(response.data.params.path);
            } else {
                $(_wrapperElement).find(params.field).val(image);
            }
            $(params.field).trigger('change');

        }).catch((error)=>{
            Swal.fire({
                title: 'Media Error',
                text: "Error Saving Media. Please check your file permission.",
                icon : 'error'
            })

            console.error(error);
            $(_wrapperElement).find(params.field).val(image);

        });

        if (params.displayImage) {
                $(params.displayImage).attr('src',image).removeClass('d-none');
        } else {
            $(_wrapperElement).find('img').attr('src',image).removeClass('d-none');
        }

        canvas.remove();

        $(_wrapperElement).find('video').addClass('d-none')
        $(elm).addClass('d-none').attr('disabled','disabled')

        if (this.videoElement.srcObject) {
            // Get the stream tracks
            const tracks = this.videoElement.srcObject.getTracks();
            // Stop each track
            tracks.forEach(track => track.stop());
            // Reset the video source
            this.videoElement.srcObject = null;
        }

        if (! params.parentHide ) {
            $(_wrapperElement).addClass('d-none')
        }
    }

    postRecord(_url , body={}) {
        return axios.post(_url,body,{
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        })
    }

    verifyEmail(params={}) {
        let _this = this;
        _this.email = $("input[name='search_field']").val();
        params.userKeyword = _this.email;
        this.postRecord('/admin/members/partials-validate',params).then((response)=>{
            window.handleOKResponse(response.data)
        });
    }

    newRegistration(params={}) {
        let _this = this;
        this.postRecord('/admin/members/partials-validate?new-registration=true',params).then((response)=>{
            window.handleOKResponse(response.data)
        });
    }
    validatePartials(params) {
        $('#postVerificationPage').html(params.view)
    }
}
window.memberRegistration = new MemberRegistration();
