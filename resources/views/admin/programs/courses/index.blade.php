@extends('layouts.admin.master')
@push('page_title')
    Program > Courses
@endpush

@section('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('main')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light"><a href="{{ route('admin.program.admin_program_list') }}">Programs</a> /
            </span><span><a
                    href="{{ route('admin.program.admin_program_detail', ['program' => $program]) }}">{{ $program->program_name }}</a>
                / </span> All
        </h4>
        <div>
            <a href="{{ route('admin.program.admin_program_detail', ['program' => $program]) }}"
                class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left me-1"></i>
            </a>
            <button data-bs-target="#newCourse" data-bs-toggle="modal" href="javascript:void(0);" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add New Course
            </button>
        </div>
    </div>

    <div class="block-header"
        data-action="{{ route('admin.program.courses.admin_program_redorder_course', [$program->getKey()]) }}"
        id='sortable-course'>
        @foreach ($courses as $course)
            <div class="row bg-white mb-2" data-order="{{ $course->getKey() }}">
                <div class="col-md-12 py-1 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-icon btn-outline-primary border-0" role="button">
                            <span class="ti ti-arrows-move"></span>
                        </a>
                        <h5 class="mb-0">
                            {{ $course->course_name }}
                        </h5>
                    </div>
                    <div>
                        <button data-target='#courseView_{{ $course->getKey() }}'
                            class="btn btn-primary btn-sm js-toggle-view" data-multiple='false'
                            data-ajax-trigger=".view-lessions-available">
                            <i class="fas fa-eye"></i>
                        </button>

                        <button
                            data-action="{{ route('admin.program.courses.admin_program_course_edit', ['course' => $course->getKey()]) }}"
                            class="btn btn-sm btn-info me-1 ajax-modal" data-bs-target="#addNewLession">
                            <i class="fas fa-pencil"></i>
                            {{-- <x-pencil></x-pencil> --}}
                        </button>
                        <a href="" data-method="post"
                            data-action="{{ route('admin.program.courses.admin_program_course_delete', ['course' => $course]) }}"
                            class="btn btn-danger btn-sm data-confirm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div style="display: none" id="courseView_{{ $course->getKey() }}"
                        class="row border border-1 border-primary mb-2">
                        <div class="col-md-12 px-0">
                            <div class="nav-align-top nav-tabs-shadow mb-6">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button
                                            data-action="{{ route('admin.program.courses.admin_program_video_list_lession_modal', [$program->getKey(), $course->id]) }}"
                                            type="button" class="nav-link waves-effect active view-lessions-available"
                                            role="tab" data-bs-toggle="tab"
                                            data-bs-target="#course_jusitified_{{ $course->getKey() }}_video"
                                            aria-controls="course_jusitified_{{ $course->getKey() }}_video"
                                            aria-selected="true"><span class="d-none d-sm-block">
                                                Videos
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            data-action="{{ route('admin.program.courses.admin_program_course_list_lession_modal', [$program->getKey(), $course->id]) }}"
                                            type="button" class="nav-link waves-effect view-lessions-available"
                                            role="tab" data-bs-toggle="tab"
                                            data-bs-target="#course_jusitified_{{ $course->getKey() }}_resource"
                                            aria-controls="course_jusitified_{{ $course->getKey() }}_resource"
                                            aria-selected="false" tabindex="-1"><span class="d-none d-sm-block">
                                                Resources / Materials</span><i
                                                class="ti ti-user ti-sm d-sm-none"></i></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link waves-effect" role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#course_jusitified_{{ $course->getKey() }}_note"
                                            aria-controls="course_jusitified_{{ $course->getKey() }}_note"
                                            aria-selected="false" tabindex="-1"><span class="d-none d-sm-block">
                                                Notes</span><i class="ti ti-message-dots ti-sm d-sm-none"></i></button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show"
                                        id="course_jusitified_{{ $course->getKey() }}_video" role="tabpanel">

                                    </div>
                                    <div class="tab-pane fade" id="course_jusitified_{{ $course->getKey() }}_resource"
                                        role="tabpanel">

                                    </div>
                                    <div class="tab-pane fade" id="course_jusitified_{{ $course->getKey() }}_note"
                                        role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 alert alert-danger">Coming Soon</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
    <!-- Large Size -->
    <x-modal modal="newCourse">
        @include('admin.modal.syllabus.new-course', ['program' => $program])
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
        $('.view-lessions-available').click(function(event) {
            event.preventDefault();
            let _this = this;
            let _url = $(this).attr('href');
            if ($(this).is('button')) {
                _url = $(this).data('action');
            }
            $($(_this).attr('data-bs-target')).empty();
            $.ajax({
                method: "get",
                url: _url,

                success: function(response) {
                    $($(_this).attr('data-bs-target')).html(response);
                    // $(".course-options").html(response);
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
