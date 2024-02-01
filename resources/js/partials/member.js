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

        $(_videoWrapper).find('video').removeClass('d-none');
        _this.videoElement = $(_videoWrapper).find('video')[0];
        $(_videoWrapper).find('button').removeAttr('disabled').removeClass('d-none');
        $(_videoWrapper).removeClass('d-none');

        // reset previous Image / input.
        $(_videoWrapper).find('img').removeAttr('src').addClass('d-none');
        $(_videoWrapper).find('input').val('');

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
        $(_wrapperElement).find(params.field).val(image);


        this.postRecord('/admin/dharmasala/bookings/upload-capture-media',{'image': image}).then(function(response) {

            // Assign image path to field.
            if (response.data.params && response.data.params.path) {
                $(_wrapperElement).find(params.field).val(response.data.params.path);
            }

        }).catch((error)=>{
            Swal.fire({
                title: 'Media Error',
                text: "Error Saving Media. Please check your file permission.",
                icon : 'error'
            })

            console.error(error);
        });

        $(_wrapperElement).find('img').attr('src',image).removeClass('d-none');

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
