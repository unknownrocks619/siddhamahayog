import './bootstrap.js';
//================== partials ======================//
import './partials/ajax-form.js'
import './partials/ajax-modal';
import './partials/select2';
import './partials/voucher-modal';
import './partials/tinymce';
import './partials/programs';
import './partials/room.js';
import './partials/member';
import './partials/transaction';
import './partials/booking';
import {Booking} from "./partials/booking";


$(function () {
    "use strict";

    window.dharmasalaBooking = new Booking();

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

    /**
     * Header User Avatar dropdown
     */
    $('#avatarDropDown').click(function(event) {
        // target dropdown togger.
        let _eventElm = $(this).parent().find('ul.dropdown-menu');
        if ($(_eventElm).hasClass('show') ) {
            $(_eventElm).removeClass('show');
        } else {
            $(_eventElm).addClass('show');
        }
    })

    $(document).on('click', '.data-confirm', function (event) {
        event.preventDefault()
        let confirmTitle = $(this).data('confirm')
        let ele = this;
        Swal.fire({
            title: 'Confirm your Action !!',
            text: confirmTitle ?? "Once deleted, you will not be able to recover !",
            showConfirmButton: true,
            showCloseButton: true,
            showCancelButton: true
        }).then((action) => {
            if (action.isConfirmed === true) {
                // perform ajax query.
                if ($(ele).data('action')) {
                    $.ajax({
                        method: $(ele).data('method'),
                        url: $(ele).data('action'),
                        data: $(ele).data('values'),
                        success: function (response) {
                            handleOKResponse(response)
                        },
                        error: function (response) {
                            handleBadResponse(response);
                        }
                    })
                }

                if ($(ele).attr('href') && !$(ele).attr('href') != '') {

                    let param = { location: $(ele).attr('href') }
                    redirect(param);
                }
            }
        })
    })


    window.handleOKResponse = function (response) {
        if (response.status == 200) {
            messageBox(response.state, response.msg);
            if ((response.callback !== null || response.callback !== '')) {
                let fn = window[response.callback];

                if (typeof (fn) === 'function') {
                    return fn(response.params);
                }
                if (fn === undefined && typeof (window.memberRegistration[response.callback]) === 'function') {
                    return window.memberRegistration[response.callback](response.params);
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

    /**
     * Handle 422 Error
     * @param data
     */
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

    window.redirectTab = function (param) {
        if (typeof param.location !== 'undefined' || param.location !== null) {
            window.open(param.location,'_blank');
        }

        if ( typeof param.reload !== 'undefined' && param.reload === true) {
            location.reload();
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
    window.messageBox = function (status, message, icon = null) {
        if (!icon && status == false) {
            icon = "<i class='fa fa-warning'></i>";
        } else if (!icon && status == true) {
            icon = "<i class='fa fa-check-square'></i>";
        }
        $.notify(`${icon}<strong>${message}</strong>`, {
            type: (status) ? 'success' : 'danger',
            allow_dismiss: true,
            showProgressbar: true,
            timer: 0.1,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        });
    }

    /**
     *
     * @type {*|jQuery}
     */
    window.memberSearchFunction =  function() {
        $("#memberSearchField").keyup(function(event) {
            event.preventDefault();
            let _this = this;

            let _data = {
                member : $(this).val(),
            }
            $.ajax({
                url : $(_this).data("action"),
                data : {member : $(_this).val()},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method : "GET",
                success : function (response) {
                    $("#search_result").html(response);
                },
                error : function (response) {
                    if (response.status == 401)  {
                        // window.location.href = '/login';
                    }
                    // if (resonse.data.stats)
                }
            })
        });
    }

    window.memberSearchFunction;
})
