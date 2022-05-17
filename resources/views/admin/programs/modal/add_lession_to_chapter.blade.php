<form name="course_form" id="new_lession" method="post" action="{{ route('admin.program.courses.admin_program_course_store_lession_modal',[$course->id]) }}">
    @csrf
    <div class="modal-header bg-dark text-white">
        <h4 class="title" id="largeModalLabel">{{ $course->course_name }} - <small>Add Video</small></h4>
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
                        Total Video Duration
                        <sup class="text-danger">*</sup>
                    </b>
                    <input type="text" required class="form-control" name="total_video_duration" placeholder="HH:MM:SS" />                      
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Video Publish Date
                    </b>
                    <input type="date" class="form-control" name="video_publish_date" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Lock Video After
                    </b>
                    <sup class='text-danger'>(Number of Days)</sup>
                    <input type="number" class='form-control' class="form-control" value="0" />
                </div>
            </div>
            <div class="col-md-6">
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
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block btn-sm ">Create New Course</button>
            </div>
        </div>
    </div>
</form>