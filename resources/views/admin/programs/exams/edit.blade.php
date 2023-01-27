@extends("layouts.portal.app")

@section("content")
<section class="content">
    <div class="container-fluid">

        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Program `{{$program->program_name}}` -- <span class="text-danger">Exam Center</span></h2>
                </div>
            </div>
        </div>

        <form action="" class="questionForm"  method="post">
        <div class="row clearfix">
                <div class="col-md-7">
                    <x-alert></x-alert>
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>
                                    Add
                                </strong>
                                Questions
                            </h2>
                        </div>
                        <div class="body card-question-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="question">
                                            Question Title
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <input type="text" name="question" id="question" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="question_type">
                                            Question Type
                                        </label>
                                        <select name="question_type" id="question_type" class="form-control">
                                            <option value="subjective">Subjective</option>
                                            <option value="objective">Objective</option>
                                            <option value="boolean">True / False</option>
                                            <option value="figurative">Figurative</option>
                                            <option value="Audio">Audio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="marks">
                                            Total Marks
                                        </label>
                                        <input type="text" name="marks" id="marks" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control richtext border"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <button class="btn btn-primary js-queue-questions">
                                Add Question
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                    <div class="header">
                        <h2>
                            {{ $exam->title }}
                        </h2>
                    </div>
                    <div class="body js-question-lister" style="max-height:611px;overflow:scroll;">
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>

<x-modal modal='addExamTerm'>
    <form action="{{route('admin.exam.store',[$program->getKey()])}}" method="post">
        @csrf
        <div class="modal-header">
            <h4>
                Create New Exam Term
            </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="term">Exam Term
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="exam_title" id="term" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control richtext"></textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timer">Enable Timer</label>
                        <select name="timer" id="timer" class="form-control show-tick">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create Exam</button>
        </div>
    </form>
</x-modal>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
<script type="text/javascript" src='{{ asset('assets/js/question.js') }}'></script>
<script>
    $(document).ready(function() {
        $('.richtext').summernote({
            height: 275,
            popover: {
                image: [],
                link: [],
                air: []
            }
        })
    });
</script>
@endsection

@section("page_css")
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}">
@endsection
