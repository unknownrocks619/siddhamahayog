$(document).on('dblclick','.update-amount-fee-transaction', function (event) {
    event.preventDefault();
    if ($(this).attr('data-target-element')) {
        $(document).find($(this).attr('data-target-element').show());
        $(document).find($(this).attr('data-target-element').addClass());
    } else {
        $(document).find('.update-amount-fee-transaction').show();
        $(document).find('.update-amount-container').addClass('d-none');
    }
    let _wrapper = $(this).closest('.transactionWrapper');

    $(this).fadeOut('fast', function (){
        $(_wrapper).find('.update-amount-container').removeClass('d-none');
    })
})

$(document).on('click','.cancel-transaction-update', function (event) {
    event.preventDefault();
    let _wrapper = $(this).closest('.transactionWrapper');
    $(_wrapper).find('.update-amount-container').addClass('d-none');
    $(_wrapper).find('.update-amount-fee-transaction').show();
})

$(document).on('click','.update-transaction-update', function(event) {
    let _url = "/admin/programs/fee/transaction/update/amount/";
    let _wrapperSpan = $(this).closest('.transactionWrapper');
    _url = _url+$(_wrapperSpan).attr('data-wrapper-id');

    let _body = {
        amount : $(_wrapperSpan).find('input').val(),
        callback : 'ajaxDataTableReload',
        params : {
            'sourceID' : $(_wrapperSpan).attr('data-table-wrapper')
        }
    }

    if ($(this).attr('data-action') ) {
        _url = $(this).attr('data-action');
    }

    if ($(this).attr('data-params-key') ) {
        _body[$(this).attr('data-params-key')]  =  $(_wrapperSpan).find('input').val();
    }

    $.ajax({
        method : 'post',
        url : _url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : _body,
        success : function (response ){
            window.handleOKResponse(response)
        },
        error : function (response) {
            window.handleBadResponse(response);
        }
    })
});


