<form name="course_form" id="course_new_lession" method="post"
    action="{{ route('admin.program.courses.admin_program_course_store_lession_modal', [$course->id]) }}">
    @csrf
    <div class="modal-header bg-dark text-white">
        <h4 class="title text-white" id="largeModalLabel">{{ $course->course_name }} - <small>Add Video</small></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Lession Name
                        <sup class="text-danger">
                            *
                        </sup>
                    </b>
                    <input type="text" name="lession_name" required class='form-control' id="lession_name" />
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="form-group">
                    <b>
                        Description
                    </b>
                    <textarea class='form-control tiny-mce' name='description' id="description"></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <b>
                        Total Video Duration
                        <sup class="text-danger">*</sup>
                    </b>
                    <input type="text" required class="form-control" name="total_video_duration"
                        placeholder="HH:MM:SS" />
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <b>
                        Video Publish Date
                    </b>
                    <input type="date" class="form-control" name="video_publish_date" />
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <b>
                        Lock Video After
                    </b>
                    <sup class='text-danger'>(Number of Days)</sup>
                    <input type="number" name="video_lock_after" class="form-control" value="0" />
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <b>
                        Video Source
                    </b>
                    <input type="text" readonly class='form-control' class="form-control" value="Vimeo" />
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Vimeo Video Link
                    </b>
                    <sup class="text-danger">*</sup>
                    <input required type="url" name="vimeo_video_url" id="vimeo_video_url" class="form-control" />

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="close-button btn btn-danger btn-simple btn-round waves-effect"
            data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-block ">Create New Course</button>
    </div>
</form>
<script type="text/javascript">
    $('form#course_new_lession').submit(function(event) {
        $(this).find('input').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        event.preventDefault();
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                $(".close-button").prop('disabled', false).trigger('click');
                window.dataTableList.ajax.reload();
            }
        })
    })
    window.setupTinyMce();
</script>
