import './bootstrap.js';
import './partials/ajax-form.js'
import './partials/ajax-modal';
import './partials/select2';
import './portal/member-registration.js'
import './portal/member-underlinks-table.js'

$(function () {
    "use strict";

    /**
     * If too many attempts prevent submission for 3 seconds.
     */

    /**
     * Ajax Setup
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.ajax-append').each(function () {
        $(this).append(`<input type='hidden' name='_token' value='${$('meta[name=csrf-token]').attr('content')}' />`);
    })

    $('.dropdown-toggle').click(function(event){
        event.preventDefault();
        let _parentCollapse = $(this).closest('.dropdown');
        let _dropDownMenu = $(_parentCollapse).find('.dropdown-menu');
        // $(_dropDownMenu).css({'margin-left':'-114px'});
        $(_dropDownMenu).toggle();
    });

    window.setLoading = function(type = 'add', element = '', hide=true) {

        if (typeof element === 'string') {
            element = $(element);
        }

        let loader = `<div class="spinner-border spinner-border-lg text-primary" role="status" style=""> <span class="visually-hidden">Loading...</span> </div>`;
        let _appendElement = `<div class='elementLoader' style="
                            position: absolute;
                            width: 100%;
                            height: 100%;
                            background: #fff;
                            z-index: 99;
                            opacity: 0.4;
                            display: flex;
                            justify-content: center;
                            align-items: center;"
                        >
            ${loader}
        </div>`;

        if (hide === true) {
            $(element).children().hide();
        }

        if (type === 'remove') {
            console.log('sfsf');
            $(element).find('.elementLoader').remove();
            $(element).children().show();
        } else {
            $(element).css({'position':'relative'});
            $(element).prepend(_appendElement);

        }

    }


    window.handleOKResponse = function (response) {
        if (response.status == 200) {
            let type = null;

            if (response.params && response.params.alert) {
                type = response.params.alert;
            }

            messageBox(response.state, response.msg,null,type);

            if ((response.callback !== null || response.callback !== '')) {
                let fn = window[response.callback];

                if (typeof (fn) === 'function') {
                    return fn(response.params);
                }
                /**
                 * For Member Registration
                 */
                if (fn === undefined && typeof (window.memberRegistration[response.callback]) === 'function') {
                    return window.memberRegistration[response.callback](response.params);
                }

                /**
                 * For Group Registration
                 */

                if (fn === undefined && typeof(window.programGroup[response.callback]) === 'function'){
                    return window.programGroup[response.callback](response.params);
                }

            }
        }
    }


    window.handleBadResponse = function (response) {

        clearAllErrors();

        if (response.status == 422) {
            handle422Case(response.responseJSON);
        }

        if (response.status == 429) {
            handle429Case(response.responseJSON);
        }
    }

    /**
     * Handle 422 Error
     * @param data
     */
    window.handle422Case = function (data) {
        let type = null;
        if (data.params && data.params.alert) {
            type = data.params.alert;
        }
        messageBox(false, data.msg ? data.msg : data.message,null,type);
        $.each(data.errors, function (index, error) {
            let inputElement = $(`input[name="${index}"]`);
            let parentDiv = $(inputElement).closest('div.form-group');

            if (parentDiv.length) {
                let element = `<div class='text-danger ajax-response-error'>${error}</div>`
                parentDiv.append(element);
            }
        });
    }

    $(document).on('click', '.js-toggle-view', function (event) {
        console.log('sfsf');
        event.preventDefault();
        let target = $($(this).data('target'));

        if($(target).length) {
            $(target).toggle();
        }

    });
    /**
     * Handle 429 Error
     * @param data
     */
    window.handle429Case = function (data) {
        Swal.fire(data.message);
    }

    window.redirect = function (param) {
        if (typeof param.location !== 'undefined' || param.location !== null) {
            window.location.href = param.location
        }
    }

    window.redirectTab = function (param) {
        if (typeof param.location !== 'undefined' || param.location !== null) {
            window.open(param.location,'_blank');
        }

        if ( typeof param.reload !== 'undefined' && param.reload === true) {
            location.reload();
        }
    }

    window.popModalWithHTML = function(params) {
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

    window.reload = function () {
        window.location.reload();
    }


    window.clearAllErrors = function () {
        $('.ajax-response-error').remove();
    }

    /**
     * Display message Box
     * @param status
     * @param message
     * @param icon
     */
    window.messageBox = function (status, message, icon = null,type=null) {

        if (!icon && status == false) {
            icon = "<i class='fa fa-warning'></i>";
        } else if (!icon && status == true) {
            icon = "<i class='fa fa-check-square'></i>";
        }
        if ( type && type =='swal') {
            Swal.fire({
                title: 'Message',
                text: message,
                showCloseButton: true,
            })

            return;
        }

        $.notify(`${icon}<strong>${message}</strong>`, {
            type: (status) ? 'success' : 'danger',
            allow_dismiss: true,
            showProgressbar: true,
            delay: 500,
            timer: 500,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            placement : {
                from: 'bottom',
                align: 'right',
            }
        });
    }

});
