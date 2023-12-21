<form method="post" action="{{ route('admin.program.batches.admin_batch_students_update',[$program->id,$member->id]) }}">
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
                        Select Batch
                        <sup class='text-danger'>*</sup>
                    </b>
                    <select name="batch" id="batch" class="form-control">
                        @foreach ($program->batches as $batch)
                        <option value="{{$batch->batch->id}}">
                            {{ $batch->batch->batch_name }}
                            -
                            {{ $batch->batch->batch_year }} / {{ $batch->batch->batch_month }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Update Batch</button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>