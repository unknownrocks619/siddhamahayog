<form method="post" action="{{ route('admin.program.admin_program_store_batch_modal',[$program->id]) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Go Live</h4>
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
                        Select Group / Section
                        <sup class='text-danger'>*</sup>
                    </b>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Start Session</button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>