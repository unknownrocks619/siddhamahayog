
@php
    $programID = request()->program;
    if (request()->program instanceof App\Models\Program) {
        $programID = request()->program->getKey();
    }
    $modalCallback = 'reload';

    if (request()->callback) {
        $modalCallback = request()->callback;
    }

    if (isset($callback) ) {
        $modalCallback = $callback;
    }

@endphp
<form method="post" class="ajax-form" action="{{route('admin.program.batches.admin_link_batch',['program' => $programID])}}">

    <div class="modal-header">
        <h4 class='header-title'>Assign Batch</h4>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2">

        @if(request()->program)
            <input type="hidden" name="program" value="{{$programID}}" />
            <input type="hidden" name="params['program']" value="{{$programID}}" />
            <input type="hidden" name="callback" value="{{$modalCallback}}">
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="batch_name">
                                Batch Name
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="batch" id="batch" class="form-control">
                                @foreach(\App\Models\Batch::get() as $batch)
                                    <option value="{{$batch->getKey()}}">{{$batch->batch_name}}({{$batch->batch_year}}-{{$batch->batch_month}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Add Batch
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    window.select2Options();
</script>
