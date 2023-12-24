
<form method="post" class="ajax-form" action="{{route('admin.batch.admin_batch_store')}}">

    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2">

        @if(request()->program)
            <input type="hidden" name="program" value="{{request()->program}}" />
            <input type="hidden" name="params['program']" value="{{request()->program}}" />
            <input type="hidden" name="callback" value="@if(request()->callback){{request()->callback}}@else{{'assignBatchToProgram'}}@endif">
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="batch_name">
                        Batch Name
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="batch_name" id="batch_name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="year">
                        Year
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" placeholder="YYYY" name="year" id="batch_name" class="form-control">
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="month">
                        Month
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="month" id="month" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                   Save & Add Batch
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    window.select2Options();
</script>
