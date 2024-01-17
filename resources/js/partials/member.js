export class MemberRegistration {

    additionalMembers = [];
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="full_name">Full Name <sup class="text-danger">*</sup></label>
                                            <input type="text" name="connectorFullName[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="relation">Relation <sup class="text-danger">*</sup></label>
                                            <input type="text" name="relation[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" name="relationPhoneNumber[]"
                                                   class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="border">
                                                <video width="640" height="480" autoplay playsinline></video>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="text-end camera-action-button record btn btn-primary btn-icon">
                                                    <i class="fas fa-camera"></i>
                                                </button>
                                                <button class="text-end d-none camera-action-button stop btn btn-danger btn-icon">
                                                    <i class="fas fa-stop"></i>
                                                </button>
                                                <button class="d-none camera-action-button camera-action-button image btn btn-primary btn-icon">
                                                    <i class="fas fa-image"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>`

        $("#familyMembers").append(_memberRow);

    }
}
console.log('hello form member page.');
window.memberRegistration = new MemberRegistration();
