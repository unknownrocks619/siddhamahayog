@extends('frontend.theme.portal')

@push('page_title')
    - {{ $program->program_name }} - {{ $exam->title }}
@endpush


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y"
        data-default="route('user.account.programs.exam.fetch-start',[$program->getKey(),$exam->getKey()])">
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
                                        <h6 class="mb-0">{{ $question->question_title }}</h6>
                                        <small class="text-muted">{{ ucwords($question->question_type) }}</small>
                                        <small class="text-danger">Draft</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- /Connections -->
                    </div>
                </div>
            </div>
            <div class="col-md-9 actual-question">
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
    <script type="text/javascript">
        $(document).ready(function() {
            defaultQuestion()
        })

        const defaultQuestion = function getDefaultQuestion() {
            $.ajax({
                type: 'POST',
                url: $('.container').data('default'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                success: function(response) {
                    $('.actual-question').html(response);
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
    </script>
@endpush
