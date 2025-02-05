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
import './partials/datatable.js';
import {Booking} from "./partials/booking";
import './partials/group.js'
import './portal/member-registration.js'

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

    window.FormRuleEnable = function() {
        if( $("div[data-enable-rule]").length >= 1) {
            $(document).find('input,select,textarea').attr('disabled','disabled').addClass('disabled');
            $(document).find("button[type='submit']").remove();
        }
    }

    FormRuleEnable();

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

    $(document).on('click', '.triggerClick', function (event){

        if ( ! $(this).attr('data-bs-target') || ! $($(this).attr('data-bs-target')).length) {
            console.error('Invalid Target Element.');
            return;
        }

        event.preventDefault();

        $($(this).attr('data-bs-target')).trigger('click');
    })

    $(document).on('click', '.js-toggle-view', function (event) {
        
        event.preventDefault();
        let target = $($(this).data('target'));

        if ($(this).data('multiple') == false) {

            $('.js-toggle-view').each(function (index, element) {
                let _target = $($(element).data('target'));
                
                if ($(_target).attr('id') != $(target).attr('id')) {
                    if (_target.length) {
                        _target.hide();
                    }
                }
                
            });
        }

        if($(target).length) {
            $(target).toggle();

            if ($(this).data('ajax-trigger') ) {
                let _ele = $(this).data('ajax-trigger');
                $(target).find(_ele).first().trigger('click');
            }
        }



    });

    $(document).on('click','.js-close-element',function(event) {

        if ( ! $($(this).data('bs-target')).length ) {
            console.error('Element Not found.');
            return;
        }

        if ( $(this).data('bs-type') === 'collapse') {
            console.log('Element: ' , $($(this).data('bs-target')));
            $($(this).data('bs-target')).removeClass('show').css({'display' : 'none !important'});
            return
        }

        $($(this).data('bs-target')).hide();

    })

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

    window.memberSearchFunction;
})
