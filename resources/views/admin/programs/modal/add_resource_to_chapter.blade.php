<form enctype="multipart/form-data" class="add_course_resource_form" name="course_form" id="new_resource" method="post"
    action="{{ route('admin.program.courses.admin_program_course_store_resource_modal', [$course->id]) }}">
    @csrf
    <div class="modal-header bg-dark text-white">
        <h4 class="title" id="largeModalLabel">{{ $course->course_name }} - <small>Add Resource</small></h4>
    </div>
    <div class="modal-body">
        <div class="row mb-2">
            <div class="col-md-12">
                <div id="errorShow"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Resource Title
                        <sup class="text-danger">
                            *
                        </sup>
                    </b>
                    <input type="text" name="resource_title" class='form-control' id="resource_title" />
                    <div id="resource_title_error" class='text-danger'></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Resource Type
                    </b>
                    <select class="form-control" name='resource_type'>
                        <option value='text'>Text</option>
                        <option value='pdf'>Application / PDF</option>
                        <option value='image' selected>Image</option>
                    </select>
                    <div id="resource_type_error" class='text-danger'></div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Resource File
                        <sub class="text-danger">Required Only if Resource type is PDF or Image</sub>
                    </b>
                    <input type="file" class="form-control" id='resourceFile' name="resource_file" placeholder="" />
                    <div id="resource_file_error" class='text-danger'></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <b>
                        Lock Resource After
                    </b>
                    <sub class='text-info'>(Number of Days)</sub>
                    <input name='lock_after_days' type="number" class='form-control' class="form-control"
                        value="0" />
                    <div id="lock_after_days_error" class='text-danger'></div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Resource Text
                        <sub class="text-danger">Required Only if Resource type is Text</sub>
                    </b>
                    <textarea id="resource_text" class="form-control" name="resource_text"></textarea>
                    <div id="resource_text_error" class='text-danger'></div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="close-button btn btn-danger btn-simple btn-round waves-effect"
            data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-block ">Create New Course</button>
    </div>
</form>

<script type="text/javascript">
    var ServerErrors = [];
    $(document).ready(function() {
        $("#resource_text").summernote();
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form.add_course_resource_form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('resource_file', $("#resourceFile")[0].files[0]);
        $(this).find('input').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.close-button').prop('disabled', false).trigger('click');
                window.resouceDataTableList.ajax.reload();
            }
        })
    })
</script>
