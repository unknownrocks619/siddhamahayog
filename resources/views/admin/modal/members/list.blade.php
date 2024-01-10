@php
    $program = \App\Models\Program::where('id',request()->program)->with('students')->first();
    $enrolledStudents = $program->students()->select('student_id')->get()->groupBy('student_id');
    $enrolledStudents = $enrolledStudents->count()
@endphp
<form method="post" class="ajax-form" action="{{ route('admin.program.live_program.merge.store',['program'=>$program]) }}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Existing Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_name">Search User To Add <sup class="text-danger">*</sup></label>
                    <input data-action="{{route('admin.members.admin_add_assign_member_to_program',request()->program)}}" type="text" placeholder="Search Member by Email or phone" name="member" id="memberSearchField" class="form-control" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_name">Program <sup class="text-danger">*</sup></label>
                    <span class="form-control bg-light">{{$program->program_name}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="search_result"></div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>

<script type="text/javascript">
    window.memberSearchFunction();
    // $("#member").keyup(function(event) {
    //     event.preventDefault();
    //     let _this = this;
    //     $.ajax({
    //         url : $(_this).data("action"),
    //         data : {member : $(_this).val()},
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         method : "GET",
    //         success : function (response) {
    //             $("#search_result").html(response);
    //         },
    //         error : function (response) {
    //             if (response.status == 401)  {
    //                 // window.location.href = '/login';
    //             }
    //             // if (resonse.data.stats)
    //         }
    //     })
    // });
</script>
