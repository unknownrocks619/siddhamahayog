
window.ajaxReinitalize = function (element, options = {}) {

    if (!$(element).hasClass('no-select-2')) {

        if (!$(element).hasClass('ajax-select-2')) {

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
