@extends('layouts.portal.app')

@section('page_title')
    Program
@endsection

@section('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <strong>
                                        Courses
                                    </strong>
                                    Available
                                </h2>
                                <ul class="header-dropdown">
                                    <li class="dropdown">
                                        <button data-target="#newCourse" data-toggle="modal" href="javascript:void(0);"
                                            class="btn btn-sm btn-warning">
                                            Add New Course
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="body" id='sortable-course'
                                data-action="{{ route('admin.program.courses.admin_program_redorder_course', [$program->getKey()]) }}">
                                @foreach ($courses as $course)
                                    <div class="border my-3 panel-group" id="accordion_{{ $course->getKey() }}"
                                        data-order="{{ $course->getKey() }}" role="tablist" aria-multiselectable="true">
                                        <div class="panel l-turquoise">
                                            <div class="panel-heading d-flex justify-content-between" role="tab"
                                                id="headingOne_{{ $course->getKey() }}">
                                                <h2 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                        data-parent="#accordion_{{ $course->getKey() }}"
                                                        href="#collapseOne_{{ $course->getKey() }}" aria-expanded="false"
                                                        aria-controls="collapseOne_1">
                                                        <span class="zmdi zmdi-arrows mx-2"></span>

                                                        {{ $course->course_name }}
                                                    </a>
                                                </h2>
                                                <div class="mt-2">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('admin.program.courses.admin_program_course_edit', [$course->id]) }}"
                                                            class="btn btn-sm btn-info" data-target="#addNewLession"
                                                            data-toggle="modal">
                                                            <x-pencil></x-pencil>
                                                        </a>

                                                        <a href="" class="btn btn-danger btn-sm">
                                                            <x-trash></x-trash>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseOne_{{ $course->getKey() }}"
                                                class="panel-collapse in collapse show bg-dark" role="tabpanel"
                                                aria-labelledby="headingOne_{{ $course->getKey() }}" style="">
                                                <div class="panel-body activities">

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
                        <div class="card">
                            <div class="header text-end text-right">
                                <h2>
                                    <Strong>
                                        ...
                                    </Strong>
                                </h2>
                            </div>
                            <div class="body course-options">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form name="course_form" id="new_course_form" method="post"
                                            action="{{ route('admin.program.courses.admin_program_course_add', [$program->id]) }}">
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
                                                            class="btn btn-primary btn-block btn-sm ">Create New
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
    </section>
@endsection

@section('modal')
    <!-- Large Size -->
    <div class="modal fade" id="newCourse" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal_content">
                <form name="course_form" id="new_course_form" method="post"
                    action="{{ route('admin.program.courses.admin_program_course_add', [$program->id]) }}">
                    @csrf
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Add New Course</h4>
                    </div>
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
                                    <input type="text" name="course_title" required class='form-control'
                                        id="course_title" />
                                </div>
                            </div>
                            <div class="col-md-12">
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
                                                <input type="radio" name="lock_course" id="lock_course_yes_modal"
                                                    value="yes">
                                                <label for="lock_course_yes_modal" class='text-success'>
                                                    Yes, Lock Course
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="radio" checked name="lock_course"
                                                    id="lock_course_no_modal_single" value="no">
                                                <label for="lock_course_no_modal_single" class='text-danger'>
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
                                                <input type="radio" name="lock_resources" id="lock_resources_yes_modal"
                                                    value="yes">
                                                <label for="lock_resources_yes_modal" class='text-success'>
                                                    Yes, Lock Resource
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="radio" checked name="lock_resources"
                                                    id="lock_resources_no_modal" value="no">
                                                <label for="lock_resources_no_modal" class='text-danger'>
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
                                <button type="submit" class="btn btn-primary btn-block btn-sm ">Create New
                                    Course</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addNewLession" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role='document'>
            <div class="modal-content" id="lession_modal_content">
                <div class="modal-body">
                    <h3>Please Wait loading resources.</h3>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page_script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
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
@endsection
