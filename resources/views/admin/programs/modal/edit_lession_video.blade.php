<form name="course_form" id="update_lession_video" method="post"
    action="{{ route('admin.videos.update.admin_video', [$video->id]) }}">
    @csrf
    <div class="modal-header bg-dark text-white">
        <h4 class="title" id="largeModalLabel">{{ $video->lession_name }} - <small>Update Video Detail</small></h4>
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
                    <input type="text" value="{{ $video->lession_name }}" name="lession_name" required
                        class='form-control' id="lession_name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Description
                    </b>
                    <textarea class='form-control tiny-mce' name='description' id="description">{{ $video->video_description }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Total Video Duration
                        <sup class="text-danger">*</sup>
                    </b>
                    <input value="{{ $video->total_duration }}" type="text" required class="form-control"
                        name="total_video_duration" placeholder="HH:MM:SS" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Video Publish Date
                    </b>
                    <input type="date" value="{{ $video->lession_date }}" class="form-control"
                        name="video_publish_date" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Lock Video After
                    </b>
                    <sup class='text-danger'>(Number of Days)</sup>
                    <input type="number" name="video_lock_after" value="{{ $video->lock_after }}" class='form-control'
                        class="form-control" value="0" />
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
            <div class="col-md-8">
                <div class="form-group">
                    <b>
                        Vimeo Video Link
                    </b>
                    <sup class="text-danger">*</sup>
                    <input required value="{{ $video->video_link }}" type="url" name="vimeo_video_url"
                        id="vimeo_video_url" class="form-control" />

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <b>Thumbnail</b>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="close-button btn btn-danger btn-simple btn-round waves-effect"
            data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-block ">Update
            Lession Detail</button>
    </div>
</form>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });


    $("#update_lession_video").submit(function(event) {
        $("#update_lession_video").find('button').prop('disabled', true);
        $("#update_lession_video").find('input').prop('readonly', true);
        event.preventDefault();
        $.ajax({
            method: $(this).attr("method"),
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
</script>
