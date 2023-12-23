$(function() {
    window.assignBatchToProgram = function(params) {
        let _targetElement = params.targetElm;

        if ( ! _targetElement ) {
            _targetElement = $('#batch-select');
        }
        _targetElement.append(`<option value="${params.items.id}" selected>${params.items.text}</option>`)

        if ($('div.modal').hasClass('show') ) {
            $('div.modal.show').find('[data-bs-dismiss]').trigger('click').trigger('change');
        }
    }

    window.assignSectionToProgram = function(params) {
        let _targetElement = params.targetElm;

        if ( ! _targetElement ) {
            _targetElement = $('#section-select');
        }
        _targetElement.append(`<option value="${params.items.id}" selected>${params.items.text}</option>`)
        console.log('hello');
        if ($('div.modal').hasClass('show') ) {
            $('div.modal.show').find('[data-bs-dismiss]').trigger('click').trigger('change');
        }
    }
});
