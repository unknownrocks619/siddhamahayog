window.selectElementChange = function (elm,target_class) {

    let _selectedMode = $(elm).find(':selected').val();

    $('.'+target_class).addClass('d-none');
    $('.'+_selectedMode).removeClass('d-none');
}
