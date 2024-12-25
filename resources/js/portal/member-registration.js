import Swal from "sweetalert2";

export default class membershipRegistration {

    registrationType = 'user';
    registrationToken = null;
    registrationVerified = false;
    registrationURL = '';
    readonlyValue = ['country','source','email_option','phone','email'];

    configs = {
                'country' : '153',
                'source' : 'web',
                'email_option' : 0,
                'gender' : 'male'
            }

    constructor(type = 'user') {

        this.registrationType = type;

        if ( $(document).find('#memberRegistration').is('form') ) {
            this.registrationURL =  $(document).find('#memberRegistration').attr('action');
        } else {
            let _parentWrapper =  $(document).find('#memberRegistration');
            this.registrationURL = $(_parentWrapper).find('form').attr('action');
            
        }

    }

    verifyRegistrationProcess(elm,membership=null) {

        let _this = this;
        window.setLoading('add',elm,false);
        
        $.ajax({
            url : _this.registrationURL,
            data : _this.configs,
            method : 'post',
            headers : {
                'X-REGISTRATION-TOKEN' : _this.registrationToken,
                'X-MEMBERSHIP-TOKEN'     : membership ?? 'NO-REGISTRATION'
            },
            success : function (response) {
                
                // display OTP display form.
                if (response.params.validation == 'verification' && response.params.view) {
                    $(elm).empty();
                    $(elm).append(response.params.view)
                } else if (response.params.view) {

                    $(elm).empty().append(response.params.view)
                }
                _this.configs['verificationType'] = response.params.verificationType;

                
                if (response.params.validationToken != undefined ) {
                    _this.registrationToken = response.params.validationToken;
                }

                _this.configs['verificationValue'] = response.params.verificationValue;
                _this.registrationURL = response.params.verificationURL;
                
                if (response.params.validation != 'undefined') {
                    _this.validation = response.params.validation;
                    _this.configs['validation'] = response.params.validation;
                }

                _this.autoFillForms();
                window.setLoading('remove',elm)

                if (response.params.validation == 'completed') {
                    Swal.fire(response.msg);
                    setTimeout(() => {
                        window.handleOKResponse(response);    
                    }, 2000);
                    
                }
                
                
            },
            error : function (response) {

                if (response.status == 429 ) {
                    $(elm).find('input').addClass('tooManyAttempts').attr('disabled','diabled');
                    setTimeout(() => {
                        $('.tooManyAttempts').removeClass('tooManyAttempts').removeAttr('disabled');
                    }, 60*100);
                }
                window.setLoading('remove',elm)
                window.handleBadResponse(response);
            }
        })
    }

    autoFillForms() {
        let _this = this;

        $.each(window.registration.configs, function(index,item) {
            let _element = $('#memberRegistration').find('[name="'+index+'"]');

            if ( ! _element.length ) {
                return;
            }


            if ( $(_element).is('input')) {

                $(_element).val(window.registration.configs[index]);
                $(_element).attr('onClick','window.registration.setAttribute(this)')

            } else if ($(_element).is('select') ) {

                $(_element).find('option[value="'+window.registration.configs[index]+'"]').prop('selected');
                $(_element).attr('onClick','window.registration.setAttribute(this)')

            }

            if ( _this.readonlyValue.includes(index) && _this.validation == 'validated' && _this.configs[index] != '') {
                $(_element).attr('disabled','disabled')
            }

        });

        let _getElement =  $('#memberRegistration').find('input, select, textarea');
        _getElement.each(function(index,item) {
            
            if (  $(item).is(':disabled') ) {
                return;
            }

            if ($(item).is('input') || $(item).is('select') || $(item).is('textarea')) {
                $(item).attr('onchange','window.registration.setAttribute(this)');
            }

        })
    }

    verifyOTP(elm) {
        let _form = $(elm).closest('form');
        window.setLoading('add',_form,false);


        if (this.configs['otp'] == undefined || this.configs['otp'].length !== 8 ) {
            Swal.fire('Invalid OTP Code.');
            window.setLoading('add',_form,false);
            return;
        }

        let _this = this;

        $.ajax({
            type : 'post',
            url : _this.registrationURL,
            data : _this.configs,
            headers : {
                'X-REGISTRATION-TOKEN' : _this.registrationToken,
            },
            success : function (response){

                $(_form).empty().append(response.params.view);
            },
            error : function (error) {

            }

        });

    }

    resendOTP(elm) {
        let _this = this;
        let _form = $(elm).closest('form');
        window.setLoading('add',_form,false);

        $.ajax({
            url : $(elm).attr('href'),
            type : 'post',
            headers : {
                'X-REGISTRATION-TOKEN' : _this.registrationToken,
            },
            data : _this.configs,
            success : function (response) {
                let _url = $(elm).attr('href');
                $(elm).text(response.params.msg).addClass('text-success').removeAttr('href').removeAttr('onclick');
                setTimeout(() => {
                        $(elm)
                        .attr('onclick','event.preventDefault(); window.registration.resendOTP(this)')
                        .attr('href',_url)
                        removeClass('text-success');
                    }, 120000);

                window.setLoading('remove',_form,false);
            },
            error : function (error) {

                if (error.status == 422 && error.responseJSON.status == 403) {

                    Swal.fire(error.responseJSON.msg);

                    $(elm).removeAttr('href').removeAttr('onclick').addClass('text-danger');

                    setTimeout(() => {
                        $(elm)
                        .attr('onclick','event.preventDefault(); window.registration.resendOTP(this)')
                        .attr('href',_url)
                        removeClass('text-danger');
                    }, 120000);
                    window.setLoading('remove',_form,false);
                } else {
                    window.handleBadResponse(error);
                    window.setLoading('remove',_form,false);
                }
            }
        })
    }

    setAttribute(elm) {

        if (this.configs['validation'] != 'undefined' && this.configs['validation'] == 'validated') {

            if (this.readonlyValue.includes($(elm).attr('name'))) {
                let _fieldName = $(elm).attr('name');

                if (this.configs[_fieldName] != undefined  && this.configs[_fieldName] != '' ) {
                    return;
                }
            }
        }


        window.setLoading('add',$(elm).closest('#memberRegistration'),false);

        if ( $(elm).hasClass('disable-attribute') ) {
            return;
        }

        let name = $(elm).attr('name');
        let value = $(elm).val();

        if ($(elm).attr('type') === 'checkbox' ) {

            value = $(elm).is(':checked') ? 1 : 0;
        }

        if ( $(elm).is('select') ) {
            value = $(elm).find(':selected').val();

        }
        this.configs[name] = value;

        window.setLoading('remove',$(elm).closest('#memberRegistration'),false);

    }

}

if ( $(document).find('#memberRegistration').length ) {

    window.registration = new membershipRegistration;
}
