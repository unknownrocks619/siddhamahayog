
window.ajaxReinitalize = function (element, options = {}) {

    if (!$(element).hasClass('no-select-2')) {

        if (!$(element).hasClass('ajax-select-2')) {

            if ($(element).closest('[data-dropdown]').length) {

                options.dropdownParent = '#'+$(element).closest('[data-dropdown]').attr('data-dropdown')
            }

            if ($(element).data('format-template') ) {
                options.templateResult = function(item) {
                    let _functionName = $(element).data('format-template');
                    console.log('function name: ', _functionName);
                    return window[_functionName](item);
                };
            }
            $(element).select2(options);
        } else {

            let action = $(element).data('action');
            options.ajax = {
                url: action,
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    return query;
                },
                results: function (data) {
                    return { results: data };
                }
            }
            if ($(element).closest('[data-dropdown]').length) {

                options.dropdownParent = '#'+$(element).closest('[data-dropdown]').attr('data-dropdown')
            }
            console.log('options: ', options);
            $(element).select2(options)

        }
    }
}


window.select2Options = function(){
    if ($('select').length) {
        $.each($('select'), function (index, element) {
            if (!$(element).hasClass('no-select-2')) {
                window.ajaxReinitalize(element);
            }
        });
    }
}

window.select2Options()

$(document).on('change', '.update-from-select', function (event) {
    event.preventDefault();
    let url = $(this).data('action');
    let params = {
        'record': $(this).find(':selected').val()
    }
    let method = $(this).data('method') ?? 'get';

    $.ajax({
        method: method,
        url: url,
        data: params,
        success: function (response) {
            window.handleOKResponse(response);
        },
        erorr: function (response) {
            window.handleBADResponse(response);
        }
    })
})

$(document).on('change', 'select[name="slider_layout"]', function (event) {
    event.preventDefault();
    let _sliderValue = $(this).find(':selected').val();
    $(".slider_row").addClass('d-none');

    if ($('.' + _sliderValue).length) {
        $('.' + _sliderValue).removeClass('d-none');
    }
})

$(document).on('change','#building_selection_to_room', function() {

    let _floorElement = $('#floor_selection_to_room');
    if (! _floorElement.length ) {
        return true;
    }

    // otherwise change the list option according to building options.
    _floorElement.empty();
    let _buildingID = $(this).find(':selected').val();
    let _buildingName = $(this).find(':selected').text();

    _floorElement.removeAttr('data-action');

    _floorElement.attr('data-action','/admin/select2/select2/list/floor/'+_buildingID)

    _floorElement.select2({
        placeholder : 'Select Floor for ' + _buildingName,
        ajax: {
            url : _floorElement.attr('data-action'),
            dataType: 'json'
        }
    });

})

window.changeCountry = function(elm, targetElm = '') {
    if (targetElm !== '') {
        $(targetElm).toggle();
        return;
    }

    $('.country-verification').hide();

    if ($(elm).find(':selected').val() != '153') {
        $('.country-other').show();
        $('#email_option').removeAttr('checked');
    } else {
        $('.country-nepal').show();

    }
}


window.formatCountry = function (item) {

    let url = "https://flagsapi.com/" + item.title + "/flat/64.png";
    let img = $("<img>", {
        class: "img-flag me-2 py-1",
        width: 45,
        src: url
    });

    let span = $("<span>", {
        text: " " + item.text,
        class: "fs-4"
    });
    span.prepend(img);
    return span;

}