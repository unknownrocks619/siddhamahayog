import CryptoJS from "crypto-js";

var encKey = undefined;

$(function(){

    if ($('form.ajax-form-login').length) {
        encKey = $('form.ajax-form-login').attr('enc');
        $('form.ajax-form-login').removeAttr('enc')
    }
    
})

$(document).on('submit', 'form.ajax-form', function (event) {
    event.preventDefault();

    let form = this;

    disableAllButtons(form);

    $.ajax({

        method: $(form).attr('method'),
        url: $(form).attr('action'),
        data: $(form).serializeArray(),
        success: function (response) {
            handleOKResponse(response);

            if (window.modalElement) {
                window.modalElement.hide();
            }
            enableAllButtons(form);

        },
        error: function (response) {
            handleBadResponse(response);
            enableAllButtons(form);
        }
    })
});

$('form.ajax-form-login').on('submit',function (event) {

    event.preventDefault();

    if (typeof CryptoJS === 'undefined' || encKey === undefined) {
        console.log('Application Not Installed.');
        alert('Application Error.');
        return;
    }
    
    let form = this;
    let formData = $(form).serializeArray();


    /** Encrypt data */
    let iv = CryptoJS.lib.WordArray.random(16);

    // Remove 'base64' part from the .env's APP_KEY
    let key = CryptoJS.enc.Base64.parse(encKey);

    let options = {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7,
    };

    // I'm using JSON.stringify(data) instead of just data
    let encrypted = CryptoJS.AES.encrypt(formData[1]['value'], key, options);
    encrypted = encrypted.toString();

    iv = CryptoJS.enc.Base64.stringify(iv);

    let result = {
        iv: iv,
        value: encrypted,
        mac: CryptoJS.HmacSHA256(iv + encrypted, key).toString(),
    };

    result = JSON.stringify(result);
    result = CryptoJS.enc.Utf8.parse(result);

    formData[1]['value'] = CryptoJS.enc.Base64.stringify(result);

    disableAllButtons(form);

    $.ajax({

        method: $(form).attr('method'),
        url: $(form).attr('action'),
        data: formData,
        success: function (response) {

            handleOKResponse(response);

            if (window.modalElement) {
                window.modalElement.hide();
            }
            enableAllButtons(form);

        },
        error: function (response) {
            handleBadResponse(response);
            enableAllButtons(form);
        }
    })
});

$(document).on('submit', 'form.ajax-component-form', function (event) {
    event.preventDefault();

    let form = this;
    disableAllButtons(form);

    $.ajax({
        method: $(form).attr('method'),
        url: $(form).attr('action'),
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            handleOKResponse(response);
            enableAllButtons(form);
            if (window.modalElement) {
                window.modalElement.hide();
            }

        },
        error: function (response) {
            handleBadResponse(response);
            enableAllButtons(form);
        }
    })
});



window.disableAllButtons = function (element = null) {
    if (!element) {
        $(document).find("button").prop('disabled', true);
        return;
    }

    $(element).find('button').prop('disabled', true)
}

window.enableAllButtons = function (element = null) {
    if (!element) {
        $(document).find("button").prop('disabled', false);
        return;
    }

    $(element).find('button').prop('disabled', false)
}

window.ajaxDataTableReload = function (params) {
    let _documentTable = $('#'+params.sourceID).DataTable().ajax.reload();

}
