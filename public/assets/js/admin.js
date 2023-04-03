

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $('.ajax-append').each(function () {
        $(this).append(`<input type='hidden' name='_token' value='${$('meta[name=csrf-token]').attr('content')}' />`);
    })
})

window.handleOKResponse = function (response) {
    if (response.status == 200) {
        messageBox(response.state, response.msg);

        if ((response.callback !== null || response.callback !== '')) {
            let fn = window[response.callback];

            if (typeof (fn) === 'function') {
                fn(response.params);
            }
        }
    }
}

window.handleBadResponse = function (response) {
    clearAllErrors();
    if (response.status == 422) {
        handle422Case(response.responseJSON);
    }
}

window.handle422Case = function (data) {
    messageBox(false, data.msg ? data.msg : data.message);
    $.each(data.errors, function (index, error) {
        let inputElement = $(`input[name="${index}"]`);
        let parentDiv = $(inputElement).closest('div.form-group');

        if (parentDiv.length) {
            let element = `<div class='text-danger ajax-response-error'>${error}</div>`
            parentDiv.append(element);
        }
    });
}

window.redirect = function (param) {

    if (typeof param.location !== 'undefined' || param.location !== null) {
        window.location.href = param.location
    }
}

window.reload = function () {
    window.location.reload();
}

window.messageBox = function (status, message, icon = null) {
    if (!message || message == null || message == undefined) {
        return;
    }
    if (!icon && status == false) {
        icon = "<i class='fa fa-warning'></i>";
    } else if (!icon && status == true) {
        icon = "<i class='fa fa-check-square'></i>";
    }


    $.notify(`${icon}<strong>${message}</strong>`, {
        type: (status) ? 'success' : 'danger',
        allow_dismiss: true,
        showProgressbar: true,
        autoHide: false,
        timer: 100,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }
    });
}

window.popModalWithHTML = function (params) {
    let _targetID = params.modalID;
    if (!$('#' + _targetID).length) {
        messageBox(false, 'Unable to complete your action.');
        return;
    }

    let _modalElement = $('#' + _targetID);
    $(_modalElement).find('#modal-content').empty().html(params.content);
    // now trigger modal pop.
    $("#" + _targetID).modal('toggle');

    if (params.clearButton) {
        $('.' + params.clearButton).prop('disable', false).text(params.label ?? 'Join Now');
    }
}

window.clearAllErrors = function () {
    $('.ajax-response-error').remove();
}
