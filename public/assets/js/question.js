$.isset = function (variable) {
    return (variable) && (typeof variable !== 'undefined');
}

class QuestionBank {

    collections = [];
    index = 0
    insertQuestion() {
        let formElements = $('form.questionForm');
        let items = $(formElements).serializeArray();

        let coll = {}
        $.each(items, function (index, item) {
            console.log('items', item);
            coll[item.name] = item.value;
        })
        window.questionLister(coll, this.index)
        this.collections.push(coll);
        this.index++;
    }

    updateQuestion(index) {
        let formElements = $('form.questionForm');
        let items = $(formElements).serializeArray();
        let coll = {}
        $.each(items, function (index, item) {
            coll[item.name] = item.value;
        })
        console.log('current coll', coll);
        window.updateLister(index, coll)
        this.collections[index] = coll;
    }

    addQuestion(index, items) {
        this.collections[index] = items;
    }

    deleteQuestion(index) {
        let gcollection = [];
        $.each(this.collections, function (_cindex, items) {
            if (index != _cindex) {
                gcollection[_cindex] = items
            }
        });
        console.log('collection', gcollection);
        this.collections = gcollection;
    }
}

window.updateLister = function (index, items) {
    let background = '#fff';
    let color = '#000';
    if (index % 2) {
        background = '#ccc';
        let color = '#fff';
    }

    let selectedDiv = $(`.js-question-lister .js-item[data-index="${index}"]`);
    $(selectedDiv).empty();
    let template = `
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
    `
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

$(document).on('click', '.js-edit-question', function (event) {
    event.preventDefault();

    if ($.isset(window.QBBank.collections[$(this).data('edit-index')])) {
        let selectedQuestion = window.QBBank.collections[$(this).data('edit-index')];

        if (selectedQuestion.question_type == 'subjective') {
            subjectAnswerEdit(selectedQuestion);
        }
        currentItem = this;
        $(".js-queue-questions").fadeOut('medium', function () {
            let parent = $(this).closest('.footer');
            let updateButton = `
                <div class='row js-update-question-row'>
                    <div class='col-md-4'>
                        <button class='btn btn-danger btn-sm js-update-question-cancel'>Cancel Edit</button>
                    </div>
                    <div class='col-md-8 text-right'>
                        <button type='button' data-update-index='${$(currentItem).data('edit-index')}' class='btn btn-warning js-update-question'>Update Question</button>
                    </div>
                </div>
                `
            $(parent).append(updateButton);
        })
    } else {
        conosle.log('not found: ', $(this));
    }

})

$(document).on('click', '.js-update-question', function (event) {
    event.preventDefault();
    console.log('clicked here.', $(this).data('update-index'));
    QBBank.updateQuestion($(this).data('update-index'));
    $('form.questionForm')[0].reset();
    $('.richtext').summernote('reset')
    $(".js-update-question-row").fadeOut('medium', function () {
        $(this).remove();
        $('.js-queue-questions').fadeIn('fast');
    })
})

$(document).on('click', '.js-update-question-cancel', function (event) {
    event.preventDefault();
    $('form.questionForm')[0].reset();
    $('.richtext').summernote('reset');
    $(".js-update-question-row").fadeOut('medium', function () {
        $(this).remove();
        $('.js-queue-questions').fadeIn('fast');
    })
})

function subjectAnswerEdit(question) {
    let formElem = $('form.questionForm');
    $(formElem).find('input[name=question]').val(question.question);
    $(formElem).find('input[name=marks]').val(question.marks);
    $(formElem).find('textarea.richtext').summernote('code', question.description);
}

$(document).on('click', '.js-delete-question', function (event) {
    event.preventDefault();
    let parent = $(this).closest('.js-item');
    $(parent).fadeOut('medium');
    QBBank.deleteQuestion($(this).closest('.js-item').data('index'));
});

window.QBBank = new QuestionBank();

$(document).on('click', '.js-queue-questions', function (event) {
    event.preventDefault();
    QBBank.insertQuestion();
    $('form.questionForm')[0].reset();
    $('.richtext').summernote('reset');
})


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
