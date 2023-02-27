@extends('frontend.theme.portal')

@push('page_title')
    - {{ $program->program_name }} - {{ $exam->title }}
@endpush


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y"
        data-default="{{ route('user.account.programs.exam.fetch-start', [$program->getKey(), $exam->getKey()]) }}">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Available Questions</h5>
                    <div class="card-body">
                        <p>Quick Navigation</p>
                        <!-- Connections -->
                        @foreach ($exam->questions as $question)
                            <div class="d-flex mb-3">

                                <div class="flex-grow-1 row">
                                    <div class="col-12 mb-sm-0 mb-2">
                                        <h6 class="mb-0">
                                            <a href="#" class="question-title"
                                                data-question-index={{ $question->getKey() }}>
                                                {{ $question->question_title }}
                                            </a>
                                        </h6>
                                        <small class="text-muted type">{{ ucwords($question->question_type) }}</small>
                                        <small class="text-danger status">Draft</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- /Connections -->
                    </div>
                </div>
            </div>
            <div class="col-md-9 actual-question" data-action="">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="demo-inline-spacing">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-info" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow text-dark" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_script')
    <script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script type="text/javascript">
        class UserAnswer {

            _questions = [];
            _answers = [];
            getQuestionByIndex(index) {
                if (!$.isset(this._questions[index])) {
                    return;
                }
                return this._questions[index];
            }

            saveQuestionState(index, value) {
                this._questions[index] = value;
                return this._questions[index];
            }

            saveAnswerPerQuestion(index, value) {
                this._answers[index] = value;
            }

            getAnswerByIndex(index) {
                if ($.isset(this._answers[index])) {
                    return this._answers[index];
                }
                return [];
            }

            updateQuestionState(index, value) {
                if ($.isset(this._questions[index])) {
                    this._questions[index] = value;
                }
            }

            resetQuestionByIndex() {

            }

        }

        window.handleOKResponse = function(response) {
            if (response.status == 200) {
                messageBox(response.state, response.msg);

                if ((response.callback !== null || response.callback !== '')) {
                    let fn = window[response.callback];

                    if (typeof(fn) === 'function') {
                        fn(response.params);
                    }
                }
            }
        }


        window.handleBadResponse = function(response) {
            clearAllErrors();
            if (response.status == 422) {
                handle422Case(response.responseJSON);
            }
        }

        window.handle422Case = function(data) {
            messageBox(false, data.msg ? data.msg : data.message);
            $.each(data.errors, function(index, error) {
                let inputElement = $(`input[name="${index}"]`);
                let parentDiv = $(inputElement).closest('div.form-group');

                if (parentDiv.length) {
                    let element = `<div class='text-danger ajax-response-error'>${error}</div>`
                    parentDiv.append(element);
                }
            });
        }

        window.redirect = function(param) {
            if (typeof param.location !== 'undefined' || param.location !== null) {
                window.location.href = param.location
            }
        }

        window.reload = function() {
            window.location.reload();
        }


        window.messageBox = function(status, message, icon = null) {
            if (!message) {
                return;
            }
            if (!icon && status == false) {
                icon = "<i class='fa fa-warning'></i>";
            } else if (!icon && status == true) {
                icon = "<i class='fa fa-check-square'></i>";
            }
            $.notify(`${icon}<strong>${message}</strong>`, {
                type: (status) ? 'success' : 'danger',
                allow_dismiss: true,
                showProgressbar: true,
                timer: 100,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                placement: {
                    from: "bottom",
                    align: "right"
                },
            });
        }

        const question = new UserAnswer();
        $.isset = function(variable) {
            return (variable) && (typeof variable !== 'defined');
        }

        $.array_push = function(array, key, value) {
            if (!$.isset(array[key])) {
                array[key] = [];
            }

            array[key].push(value);
        }

        $.array_push_add = function(array, key, value) {
            if (!$.isset(array[key])) {
                array[key] = 0;
            }

            array[key] += parseInt(value);
        }

        $(document).ready(function() {
            defaultQuestion()
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        const defaultQuestion = function getDefaultQuestion(userData = {}) {
            $.ajax({
                type: 'POST',
                url: $('.container').data('default'),
                data: userData,
                success: function(response) {
                    handleOKResponse(response);
                },
                error: function() {
                    let fallBack = `<div class='card'>
                                        <div class='card-body'>
                                            <div class='text-center'>
                                                <h4 class='text-danger'>
                                                    Oops ! Somethingwent Wrong, Please try again.
                                                </h4>
                                                <button class='btn btn-primary reload-default'>Try Again.</button>
                                            </div>
                                        </div>
                                    </div>`
                    $('.actual-question').html(fallBack)
                }
            });
        }

        const saveAnswer = function saveUserAnswer(userData, url) {
            $.ajax({
                type: 'POST',
                url: url,
                data: userData,
                success: function(response) {
                    handleOKResponse(response);
                },
                error: function() {
                    let fallBack = `<div class='card'>
                                        <div class='card-body'>
                                            <div class='text-center'>
                                                <h4 class='text-danger'>
                                                    Oops ! Somethingwent Wrong, Please try again.
                                                </h4>
                                                <button class='btn btn-primary reload-default'>Try Again.</button>
                                            </div>
                                        </div>
                                    </div>`
                    $('.actual-question').html(fallBack)
                }
            });
        }

        $(document).on('click', '.reload-default', function(event) {
            event.preventDefault();
            defaultQuestion();
        })

        $(document).on('click', '.question-title', function(event) {
            event.preventDefault();
            let questions = question.getQuestionByIndex($(this).data('question-index'));

            if (questions) {
                displayQuestion({
                    html: questions
                })
                return;
            }
            formData = {
                "question": $(this).data('question-index')
            }
            return defaultQuestion(formData);

        })

        $(document).on('click', '.draft', function(event) {
            event.preventDefault();
            // get question
            let currentForm = $(this).closest('form');
            let wrapperElement = $(this).closest('div.card');
            let allFormElement = $(currentForm).find('.save-state');
            let answerState = [];

            $.each(allFormElement, function(index, element) {
                let key = $(element).data('name');
                let value = $(element).val();
                let stateContent = {}
                stateContent[key] = value;
                answerState.push(stateContent);
            });
            question.saveAnswerPerQuestion($(wrapperElement).find('div.card-body').data("question-id"),
                answerState);

        })

        $(document).on('submit', 'form.form-answer', function(event) {
            event.preventDefault();
            let url = $(this).attr('action');
            formData = $(this).serializeArray();
            saveAnswer(formData, url);

        });

        function addQuestion(index, value) {
            question.saveQuestionState(index, value);
        }

        function displayQuestion(htmlRender) {
            $('.actual-question').html(htmlRender.html);
            let questionWrapperElement = $('.actual-question');
            let questionIndex = $(questionWrapperElement).find('div.card-body')
            addQuestion($(questionIndex).data('question-id'), htmlRender.html);
            displayAnswer($(questionIndex).data('question-id'));
        }


        function displayAnswer(index) {
            answers = question.getAnswerByIndex(index);
            console.log('this is index: ', index);
            let wraper = $('div[data-question-id="' + index + '"]');
            if (answers.length >= 1) {
                $.each(answers, function(index, element) {
                    let inputElement = Object.keys(element)[0];
                    if ($(wraper).find('[name=' + inputElement + ']')) {
                        $(wraper).find('[name=' + inputElement + ']').val(element[inputElement]);
                    }
                })
            }
        }

        function booleanResponseAnswer(htmlRender) {
            $('.actual-question').html(htmlRender.html);
            question.updateQuestionState(htmlRender.question_index, htmlRender.html);
        }
    </script>
@endpush

@push('custom_css')
    <style type="text/css">
        .form-check-success .form-check-input:checked,
        .form-check-success .form-check-input[type=checkbox]:indeterminate {
            background-color: #71dd37;
            border-color: #71dd37;
            box-shadow: 0 2px 4px 0 rgb(113 221 55 / 40%);
        }

        .form-check-danger .form-check-input:checked,
        .form-check-danger .form-check-input[type=checkbox]:indeterminate {
            background-color: rgb(255, 62, 29) !important;
            border-color: rgb(255, 62, 29) !important;
            box-shadow: 0 2px 4px 0 rgb(113 221 55 / 40%);
        }
    </style>
@endpush
