<form class="ajax-form" name="course_form" id="update_course_content_{{ $course->getKey() }}" method="post"
    action="{{ route('admin.program.courses.admin_program_course_update', [$course->id]) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Update Course -- {{ $course->course_name }}</h4>
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
                    <input type="text" value="{{ $course->course_name }}" name="course_title" required
                        class='form-control' id="course_title" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Description
                    </b>
                    <textarea class='form-control course_description tiny-mce' name='description' id="course_description">{{ $course->description }}</textarea>
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

                                <input @if ($course->lock) checked @endif type="radio"
                                    name="lock_course" id="lock_course_yes_edit_modal" value="yes">
                                <label for="lock_course_yes_edit_modal" class='text-success'>
                                    Yes, Lock Course
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input @if (!$course->lock) checked @endif type="radio"
                                    name="lock_course" id="lock_course_no_edit_modal" value="no">
                                <label for="lock_course_no_edit_modal" class='text-danger'>
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
                                <input @if ($course->enable_resource) checked @endif type="radio"
                                    name="lock_resources" id="lock_resources_yes_edit_modal" value="yes">
                                <label for="lock_resources_yes_edit_modal" class='text-success'>
                                    Yes, Lock Resource
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input @if (!$course->enable_resource) checked @endif type="radio"
                                    name="lock_resources" id="lock_resources_no_edit_modal" value="no">
                                <label for="lock_resources_no_edit_modal" class='text-danger'>
                                    No, Don't Lock Resource
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="close-button btn btn-danger btn-simple btn-round waves-effect"
            data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-block btn-sm ">Update Course Detail</button>
    </div>
</form>


<script>
    $("textarea.course_description").summernote();

    $('#update_course_content_{{ $course->getKey() }}').submit(function(event) {
        event.preventDefault();
        $(this).find('input').prop('readonly', true);
        $(this).find('button').prop('disabled', false);
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr("action"),
            data: $(this).serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('.close-button').prop('disabled', false).trigger('click');
                window.location.reload();
            }
        })
    })
</script>
