<div class="modal-header  d-flex justify-content-between align-items-center">
    <h4 class="title mb-0" id="largeModalLabel">{{ $course->course_name }} - <small> Resources</small>
    </h4>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-warning " data-bs-target="#addNewLession" data-bs-toggle="modal"
                href="{{ route('admin.program.courses.admin_program_course_add_resource_modal', [$course->id]) }}">
                Add New Resource
            </a>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table class="table m-b-0 table-hover" id="lession_resource__ajax_{{ $course->id }}">
            <thead>
                <tr>
                    <th>Resource Name</th>
                    <th>Resource Type</th>
                    <th>Total View</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script>
    window.resouceDataTableList = $('#lession_resource__ajax_{{ $course->id }}').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url()->full() }}',
        columns: [{
                data: 'resource_title',
                name: "resource_title"
            },
            {
                data: 'resource_type',
                name: 'resource_type'
            },
            {
                data: "total_view",
                name: "total_view"
            },
            {
                data: "view",
                name: "view"
            },
        ],
        displayIndex: true,
        dataIndex: true,
        "ordering": false,
        paging: false,
    });

    $(document).on('click', 'a.remove-resource-content', function(event) {
        event.preventDefault();
        let action = $(this).attr('href');
        $(this).removeAttr('href').addClass('text-muted');
        $.ajax({
            method: "GET",
            url: action,
            success: function(response) {
                window.resouceDataTableList.ajax.reload();
            }
        })
    })
</script>
