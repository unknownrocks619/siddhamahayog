<div class="row mt-2">
    <div class="col-md-12">
        <div class="form-group">
            <label for="batch">Batch
                <sup class="text-danger">
                    *
                </sup>
            </label>
            <select name="batch" id="batch" class="form-control">
                @foreach ($program->batches as $batch)
                <option value="{{ $batch->batch->id }}">{{ $batch->batch->batch_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


<div class="row mt-2">
    <div class="col-md-12">
        <div class="form-group">
            <label for="sections">Section
                <sup class="text-danger">*</sup>
            </label>
            <select name="section" id="section" class="form-control">
                @foreach ($program->sections as $secetion)
                <option value="{{ $secetion->id }}">{{ $secetion->section_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>