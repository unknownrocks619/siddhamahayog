<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h4 class="title" id="largeModalLabel">{{ $course->course_name }} (Videos)
        </h4>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{ route('admin.program.courses.admin_program_course_add_lession_modal', [$course->id]) }}"
                class="btn btn-warning" data-bs-target='#addNewLession' data-bs-toggle='modal'>
                Add Video To Course
            </a>
        </div>
    </div>

</div>

<div class="card-body">
    <div class="col-md-12">
        <div class="table-responsive">
            <table
                data-action="{{ route('admin.program.courses.admin_program_redorder_lession', [$program->getKey(), $course->getKey()]) }}"
                class="table m-b-0 table-hover" id="lession_ajax_{{ $course->id }}">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Title</th>
                        <th>
                            Upload Date
                        </th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="newCourse" tabindex="-1" role="dialog">
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
                                            <input type="radio" name="lock_course" id="lock_course_yes"
                                                value="yes">
                                            <label for="lock_course_yes" class='text-success'>
                                                Yes, Lock Course
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" checked name="lock_course" id="lock_course_no"
                                                value="no">
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
                                            <input type="radio" name="lock_resources" id="lock_resources_yes"
                                                value="yes">
                                            <label for="lock_resources_yes" class='text-success'>
                                                Yes, Lock Resource
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" checked name="lock_resources" id="lock_resources_no"
                                                value="no">
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
                <div class="modal-footer d-flex">
                    <button type="button" class="close-button btn btn-danger btn-simple btn-round waves-effect"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-block ">Create New
                        Course</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<script>
    window.dataTableList = $('#lession_ajax_{{ $course->id }}').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.program.courses.admin_program_video_list_lession_modal', ['program' => $course->program_id, 'course' => $course->getKey()]) }}",
        columns: [{
                data: 'status',
                name: "status"
            },
            {
                data: 'lession_name',
                name: 'lession_name'
            },
            {
                data: "uploaded_date",
                name: 'uploaded_date'
            }, {
                data: "video_link",
                name: "video_link"
            },
            {
                data: "action",
                name: "action"
            },
        ],
        displayIndex: true,
        dataIndex: true,
        ordering: false,
        paging: true,


    });
    $("table").sortable({
        items: "tr.sortable-row",
        stop: function(event, ui) {
            let sortableID = $("table").sortable("toArray", {
                items: 'tr.sortable-row',
                attribute: 'data-order'
            });

            $.ajax({
                method: "POST",
                url: $("table").data('action'),
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

    $(document).on('click', '.remove-video-link', function(event) {
        event.preventDefault();
        let hrefLink = $(this).attr('href');
        $(this).removeAttr('href').addClass('text-muted');
        $.ajax({
            method: "GET",
            url: hrefLink,
            success: function() {
                window.dataTableList.ajax.reload();
            }
        })
    })
</script>
