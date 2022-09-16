@extends("layouts.portal.app")

@section("page_title")
Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">


@endsection


@section("content")
<!-- Main Content -->
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>{{ $program->program_name }} - Course Syllabus / Chapter</h2>
                    <small>
                        [<a href='#' data-target="#newCourse" data-toggle="modal">Create New Course</a>]
                    </small>
                </div>
            </div>
        </div>
        <div class="row clearfix">


            @if(Session::has('success'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                    <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                        x
                    </button>
                    <div class='d-flex align-items-center'>
                        <i class="bx bx-check"></i>
                        <span>{{ Session::get('success') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                    <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                        x
                    </button>
                    <div class='d-flex align-items-center'>
                        <i class="bx bx-check"></i>
                        <span>{{ Session::get('error') }}</span>
                    </div>
                </div>
            </div>
            @endif

            @foreach ($courses as $course)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>{{ $course->course_name }}</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Add Video</a></li>
                                    <li><a href="javascript:void(0);">Add Resources</a></li>
                                    <li><a href="javascript:void(0);">View Access List</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Current Status
                            <span class="badge @if($course->lock) badge-danger @else badge-success @endif  float-right">@if($course->lock) Locked @else Active @endif</span>
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.program.courses.admin_program_course_add_lession_modal',[$course->id]) }}" data-target="#addNewLession" data-toggle="modal" class='text-info'>Add Video</a>
                                <br />
                                <a href="{{ route('admin.program.courses.admin_program_course_add_resource_modal',[$course->id]) }}" data-target="#addNewLession" data-toggle="modal" class='text-info'>Add Materials</a>
                                <br />
                                <!-- <a href="" class='text-info'>Add Note</a> -->
                                @if($course->lock)
                                <br />
                                <a href="" class='text-info'>Access List</a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.program.courses.admin_program_video_list_lession_modal',[$course->id]) }}" data-target="#addNewLession" data-toggle="modal" class='text-muted'>View Videos</a>
                                <br />
                                <a href="{{ route('admin.program.courses.admin_program_course_list_lession_modal',[$course->id]) }}" data-target="#addNewLession" data-toggle="modal" class='text-muted'>View Materials</a>
                                <br />
                                <a href="" class='text-muted'>View User Note</a>
                                @if($course->lock)
                                <br />
                                <a href="" class='text-muted'>View Access List</a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-7">
                                <a class="btn btn-sm btn-info btn-block" href=''>Edit</a>
                            </div>
                            <div class="col-5">
                                <small class='text-danger'>Delete</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="newCourse" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_content">
            <form name="course_form" id="new_course_form" method="post" action="{{ route('admin.program.courses.admin_program_course_add',[$program->id]) }}">
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
                                <input type="text" name="course_title" required class='form-control' id="course_title" />
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
                                            <input type="radio" name="lock_course" id="lock_course_yes" value="yes">
                                            <label for="lock_course_yes" class='text-success'>
                                                Yes, Lock Course
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" checked name="lock_course" id="lock_course_no" value="no">
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
                                            <input type="radio" name="lock_resources" id="lock_resources_yes" value="yes">
                                            <label for="lock_resources_yes" class='text-success'>
                                                Yes, Lock Resource
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" checked name="lock_resources" id="lock_resources_no" value="no">
                                            <label for="lock_resources_no" class='text-danger'>
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
                            <button type="submit" class="btn btn-primary btn-block btn-sm ">Create New Course</button>
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


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript">
    $("#addNewLession").on("shown.bs.modal", function(event) {
        $.ajax({
            method: "get",
            url: event.relatedTarget.href,
            success: function(response) {
                $("#lession_modal_content").html(response);
            }
        })
    });
</script>
@endsection