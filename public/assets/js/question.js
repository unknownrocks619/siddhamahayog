$.isset = function (variable) {
    return (variable) && (typeof variable !== 'undefined');
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr('content')
    }
})

$(document).on('submit', 'form.ajax-form', function (event) {
    event.preventDefault();
    $('.form-success-text').remove();
    let form = this;
    $.ajax({
        type: "POST",
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serializeArray(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        },
        success: function (response) {
            $('.js-question-lister').html(response)
            let question = $(form).filter('div.footer');
            $(form).closest('div').find('div.footer').append('<span class="text-success form-success-text"> Success !!</span>');
            $(form)[0].reset();
            $('select').find('option :eq(0)').attr('selected', true);
        },
        error: function (response) {
            console.log('response error: ');
        }
    })
})

window.updateLister = function (index, items) {
    let background = '#fff';
    let color = '#000';
    if (index % 2) {
        background = '#ccc';
        let color = '#fff';
    }

    let selectedDiv = $(`.js-question-lister .js-item[data-index="${index}"]`);
    $(selectedDiv).empty();
    let template = `<div class='col-md-12'>
                            <h5><span data-title='${items.question}'>${items.question}</span> -  <span data-question-type='${items.question_type}'>[${items.question_type}]</span></h5>
                        </div>
                        <div class='col-md-12 mt-3'> <div class='blockquote'>${items.description}</div></div >
                        <div class='col-md-4 mt-3' style="font-size:20px;">
                            Marks: <span data-marks='${items.marks}' class='p-3 border ' style='border-radius: 50px;font-weight:bolder'>${items.marks}</span>
                            <span class='ms-3 ps-3'>
                                <a href='' class='js-delete-question'>
                                    <x-trash>Delete</x-trash>
                                </a>
                            </span>
                        </div>
                        <div class='col-md-4 mt-3' style="font-size:20px;">
                            <span class='ms-3 ps-3'>
                                <a href='' data-edit-index='${index}' class='js-edit-question'>
                                    Edit
                                </a>
                            </span>
                        </div>`
    $(selectedDiv).html(template);
}

window.questionLister = function (items, index) {

    let background = '#fff';
    let color = '#000';
    if (index % 2) {
        background = '#ccc';
        let color = '#fff';
    }
    // console.log('to text: ', TextEncoder(items.description))
    let template = `<div class='row mb-3  pb-4 border-bottom js-item' data-index='${index}' style='background:${background};color: ${color}'>
                        <div class='col-md-12'>
                            <h5><span data-title='${items.question}'>${items.question}</span> -  <span data-question-type='${items.question_type}'>[${items.question_type}]</span></h5>
                        </div>
                        <div class='col-md-12 mt-3'> <div class='blockquote'>${items.description}</div></div >
                        <div class='col-md-4 mt-3' style="font-size:20px;">
                            Marks: <span data-marks='${items.marks}' class='p-3 border ' style='border-radius: 50px;font-weight:bolder'>${items.marks}</span>
                            <span class='ms-3 ps-3'>
                                <a href='' class='js-delete-question'>
                                    <x-trash>Delete</x-trash>
                                </a>
                            </span>
                        </div>
                        <div class='col-md-4 mt-3' style="font-size:20px;">
                            <span class='ms-3 ps-3'>
                                <a href='' data-edit-index='${index}' class='js-edit-question'>
                                    Edit
                                </a>
                            </span>
                        </div>
    `
    $(".js-question-lister").append(template);
}

$(document).on('change', 'select[name=question_type]', function (event) {

    $(".row_by_q_type").remove();
    let template = null;
    if ($(this).find(':selected').val() == 'boolean') {
        template = `
            <div class='row mt-3 row_by_q_type'>
                <div class='col-md-12'>
                    <span class='fs-3 h3'>
                        Please Choose Correct Answer
                    </span>
                </div>
                <div class='col-md-4 mt-2'>
                    <input type='radio' name='boolean_answer' value='1' /> True
                </div>
                <div class='col-md-4 mt-2'>
                    <input type='radio' name='boolean_answer' value='0' /> False
                </div>
            </div>
        `
    } else if ($(this).find(':selected').val() == "objective") {

        template = `
            <div class='row mt-3 row_by_q_type'>
                <div class='col-md-12'>
                    <span class='fs-3 h3'>
                        Provide Option and Correct Answer
                    </span>
                </div>
                <div class='col-md-12'>
                    <div class="row">
                        <div class='col-md-4 mt-2'>
                            <label>Options</label>
                            <input type='text' name='subjective_answer[]' value='' class='form-control' />
                        </div>
                        <div class='col-md-4 mt-2'>
                            <label>Correct Answer</label>
                            <select class='form-control' name='solution[]'>
                                <option value='1'>Yes</option>
                                <option value='0' selected>No</option>
                            </select>
                        </div>
                        <div class='col-md-2'>
                        <label class='w-100 d-block'>&nbsp;</label>
                            <button type='button' class='btn btn-sm btn-info js-subjective-plus'>
                                Add Options
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `

    }
    $('.card-question-body').append(template);
})

$(document).on('click', '.js-subjective-plus', function (event) {
    event.preventDefault();
    let template = `
                    <div class='col-md-12'>
                        <div class="row mt-2">
                            <div class='col-md-4 mt-2'>
                                <label>Options</label>
                                <input type='text' name='subjective_answer[]' value='' class='form-control' />
                            </div>
                            <div class='col-md-4 mt-2'>
                                <label>Correct Answer</label>
                                <select class='form-control' name='solution[]'>
                                    <option value='1'>Yes</option>
                                    <option value='0' selected>No</option>
                                </select>
                            </div>
                            <div class='col-md-2'>
                            <label class='w-100 d-block'>&nbsp;</label>
                                <button type='button' class='btn btn-sm btn-danger js-subjective-remove'>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    `
    $('.row_by_q_type').append(template);
})

$(document).on('click', '.js-subjective-remove', function (event) {
    $(this).closest('.row').remove();
});

$(document).on('click', '.js-delete-question', function (event) {
    event.preventDefault();
    let button = this;
    $.ajax({
        url: $(this).data('action'),
        type: 'POST',
        data: '_method=DELETE',

        success: function (response) {
            // console.log($(button).closest('div.card'));
            $(button).closest('div.card').fadeOut('medium', function () {
                $(this).remove();
            });

        },
        error: function (response) {
            console.log(' Error: Unable to remove question.');
        }
    })
})

$(document).on('click', '.js-question-edit-question', function (event) {
    event.preventDefault();
    $(".footer-success").remove();
    $.ajax({
        url: $(this).data('action'),
        type: 'GET',
        success: function (response) {
            $("#questionForm").empty().html(response);
            $('.richtext').summernote({
                height: 275,
                popover: {
                    image: [],
                    link: [],
                    air: []
                }
            });

        },
        error: function (response) {
            console.log(' Error: Unable to remove question.');
        }
    })
})

// $(document).on('click', '.js-update-question', function (event) {
//     event.preventDefault();
//     $.ajax({
//         url: $(this).data('action'),
//         type: "POST",

//         success: function (response) {
//             $('.js-question-lister').html(response);
//         }
//     })
// });


