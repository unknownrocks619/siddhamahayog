<form method="post" action="{{ route('admin.program.admin_program_store_batch_modal',[$program->id]) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Add Batch</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Program Name
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class='form-control readonly'>
                        {{ $program->program_name }}
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
                        @foreach ($batches as $batch)
                            <option value="{{$batch->id}}">
                                {{ $batch->batch_name }}
                                -
                                {{ $batch->batch_year }} / {{ $batch->batch_month }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Add Batch</button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>