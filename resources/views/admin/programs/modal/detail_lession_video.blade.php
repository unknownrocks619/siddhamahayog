<div class="modal-header bg-dark text-white">
    <h4 class="title" id="largeModalLabel">{{ $course->course_name }} - <small>Video List</small>
        <button type="button" class="bg-white text-lg close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </h4>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table class="table m-b-0 table-hover" id="lession_ajax_{{$course->id}}">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Total Watch</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script>
    $('#lession_ajax_{{$course->id}}').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{url()->full()}}',
        columns: [{
                data: 'status',
                name: "status"
            },
            {
                data: 'lession_name',
                name: 'lession_name'
            },
            {
                data: "video_link",
                name: "video_link"
            },
            {
                data: "total_watched",
                name: "total_watched"
            },
        ]
    });
</script>