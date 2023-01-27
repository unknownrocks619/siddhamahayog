<form method="post" action="{{ route('admin.program.sections.admin_update_students_update',[$program->getKey(),$member->getKey()]) }}">
    @method("PUT")
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Update Batch for `{{ $member->full_name }}`</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Program Name
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class='form-control readonly bg-light'>
                        {{ $program->program_name }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Member Name
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class='form-control readonly bg-light'>
                        {{ $member->full_name }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Select Section
                        <sup class='text-danger'>*</sup>
                    </b>
                    <select name="section" id="section" class="form-control">
                        @foreach ($program->sections as $section)
                        <option value="{{$section->getKey()}}">
                            {{ $section->section_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Update Section</button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>
