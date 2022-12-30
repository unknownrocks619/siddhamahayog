<form method="post" data-key="{{ $programStudent->getKey() }}" class="ajax-form" action="{{ route('admin.program.enroll.admin_store_student_enroll_roll_number',$programStudent->getKey()) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Roll Number</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Student Name
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class='form-control readonly'>
                        {{ $programStudent->student->full_name }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Roll Number
                        <sup class='text-danger'>*</sup>
                    </b>
                    <input value="{{ $programStudent->roll_number }}" type="text" name="roll_number" id="roll_number" class="form-control" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Save Roll Number</button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>