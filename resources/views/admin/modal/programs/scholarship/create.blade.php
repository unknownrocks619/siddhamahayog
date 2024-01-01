<form method="post" class="ajax-form ajax-append" action="{{ route('admin.program.scholarship.store',['program'=>$program]) }}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Scholarship Management</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div  data-dropdown="quickUserView" class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_name">Program Name <sup class="text-danger">*</sup></label>
                    <span class="form-control disabled bg-light">{{$program->program_name}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="scholarship_type">Scholarship Type <sup class="text-danger">*</sup></label>
                    <select name="scholarship_type" id="scholarship_type" class="form-control">
                        <option value="" selected disabled>Please select Scholarship Type</option>
                        @foreach(\App\Models\Scholarship::TYPES as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="student">User</label>
                    <select name="student" id="student" class="form-control">
                        @foreach ($members as $member)
                            @continue(! $member->student)
                            <option value="{{$member->student->getKey()}}">{{$member->student->full_name}} ({{$member->student->email}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="remarks">
                        Remarks
                        <sup class="text-danger">*</sup>
                    </label>
                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
