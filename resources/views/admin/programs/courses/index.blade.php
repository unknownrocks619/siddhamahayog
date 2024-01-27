@extends('layouts.admin.master')
@push('page_title') Program > Courses @endpush

@section('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a> / </span><span><a href="{{route('admin.program.admin_program_detail',['program' => $program])}}">{{$program->program_name}}</a> / </span> All
    </h4>
    <div class="block-header">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>
                                <strong>
                                    Courses
                                </strong>
                                Available
                            </h5>
                            <button data-bs-target="#newCourse" data-bs-toggle="modal" href="javascript:void(0);"
                                    class="btn btn-sm btn-warning">
                                Add New Course
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body" id='sortable-course'
                                data-action="{{ route('admin.program.courses.admin_program_redorder_course', [$program->getKey()]) }}">
                                @foreach ($courses as $course)
                                    <div class="border my-3 panel-group" id="accordion_{{ $course->getKey() }}"
                                        data-order="{{ $course->getKey() }}" role="tablist" aria-multiselectable="true">
                                        <div class="panel l-turquoise">
                                            <div class="panel-heading d-flex align-items-center justify-content-between" role="tab"
                                                id="headingOne_{{ $course->getKey() }}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                        data-parent="#accordion_{{ $course->getKey() }}"
                                                        href="#collapseOne_{{ $course->getKey() }}" aria-expanded="false"
                                                        aria-controls="collapseOne_1">
                                                        <span class="ti ti-arrows-move"></span>

                                                        {{ $course->course_name }}
                                                    </a>
                                                </h4>
                                                <div class="mt-2">
                                                    <div class="d-flex justify-content-end">
                                                        <button data-action="{{ route('admin.program.courses.admin_program_course_edit', ['course' => $course->getKey()]) }}"
                                                            class="btn btn-sm btn-info me-1 ajax-modal"  data-bs-target="#addNewLession"
                                                            data-bs-toggle="modal">
                                                            <x-pencil></x-pencil>
                                                        </button>

                                                        <a href="" data-method="post" data-action="{{route('admin.program.courses.admin_program_course_delete',['course'=>$course])}}" class="btn btn-danger btn-sm data-confirm">
                                                            <x-trash></x-trash>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>

                                            <div id="collapseOne_{{ $course->getKey() }}"
                                                class="panel-collapse in collapse show bg-dark" role="tabpanel"
                                                aria-labelledby="headingOne_{{ $course->getKey() }}" style="">
                                                <div class="card-body activities">

                                                    <div class="streamline b-accent">
                                                        <div class="sl-item">
                                                            <div class="sl-content">
                                                                <a href="{{ route('admin.program.courses.admin_program_video_list_lession_modal', [$program->getKey(), $course->id]) }}"
                                                                    class="text-info
                                                                    view-lessions-available">View
                                                                    Video
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="sl-item">
                                                            <div class="sl-content">
                                                                <a href="{{ route('admin.program.courses.admin_program_course_list_lession_modal', [$program->getKey(), $course->id]) }}"
                                                                    class="text-info view-lessions-available">View Resource
                                                                    / Material
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="sl-item">
                                                            <div class="sl-content">
                                                                <a href="#" class="text-info">View User Notes
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row my-1">
                            <div class="col-md-12 text-end">
                                <a class="btn btn-danger btn-icon" href="{{route('admin.program.admin_program_detail',['program' => $program])}}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body course-options">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="ajax-form" method="post"
                                            action="{{ route('admin.program.courses.admin_program_course_add', ['program' => $program]) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <b>
                                                                Course Name / Title
                                                                <sup class="text-danger">
                                                                    *
                                                                </sup>
                                                            </b>
                                                            <input type="text" name="course_title" required
                                                                class='form-control' id="course_title" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 my-3">
                                                        <div class="form-group">
                                                            <b>
                                                                Description
                                                            </b>
                                                            <textarea class='form-control' name='description' id="description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <b>
                                                                Lock Course
                                                            </b>
                                                            <div class="radio">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="radio" name="lock_course"
                                                                            id="lock_course_yes" value="yes">
                                                                        <label for="lock_course_yes" class='text-success'>
                                                                            Yes, Lock Course
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="radio" checked name="lock_course"
                                                                            id="lock_course_no" value="no">
                                                                        <label for="lock_course_no" class='text-danger'>
                                                                            No, Don't Lock Course
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <b>
                                                                Lock Resource
                                                            </b>
                                                            <div class="radio">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="radio" name="lock_resources"
                                                                            id="lock_resources_yes" value="yes">
                                                                        <label for="lock_resources_yes"
                                                                            class='text-success'>
                                                                            Yes, Lock Resource
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="radio" checked
                                                                            name="lock_resources" id="lock_resources_no"
                                                                            value="no">
                                                                        <label for="lock_resources_no"
                                                                            class='text-danger'>
                                                                            No, Don't Lock Resource
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-block ">Create New
                                                            Course</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Large Size -->
    <x-modal modal="newCourse">
        @include('admin.modal.syllabus.new-course',['program' => $program])
    </x-modal>
    <x-modal modal="addNewLession">
        <div class="modal-content" id="lession_modal_content">
            <div class="modal-body">
                <h3>Please Wait loading resources.</h3>
            </div>
        </div>
    </x-modal>
@endsection

@section('modal')
@endsection


@push('page_script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script type="text/javascript">
        $(document).on('click', ".view-lessions-available", function(event) {
            event.preventDefault();
            $.ajax({
                method: "get",
                url: $(this).attr('href'),
                success: function(response) {
                    $(".course-options").html(response);
                }
            })
        })
        $(document).on("shown.bs.modal", '#addNewLession', function(event) {
            $.ajax({
                method: "get",
                url: event.relatedTarget.href,
                success: function(response) {
                    $("#lession_modal_content").html(response);
                }
            })
        });
        $(document).on('click', '.delete', function(event) {
            event.preventDefault();
            $.ajax({
                method: "post",
                url: $(this).data('href'),
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success: function(response) {}
            })
            $(this).closest('div.parent-Delete').fadeOut('fast');

        })
        $("#sortable-course").sortable({
            attribute: 'data-order',
            stop: function(event, ui) {
                var sortableID = $("#sortable-course").sortable("toArray", {
                    attribute: 'data-order',
                });

                $.ajax({
                    method: "POST",
                    url: $("#sortable-course").data('action'),
                    data: {
                        sortableID
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    },
                    success: function(response) {

                    }
                })
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: 'textarea',
                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                toolbar_mode: 'floating',
            });
        });
    </script>
@endpush
