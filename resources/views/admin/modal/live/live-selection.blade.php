@php
    $program = \App\Models\Program::where('id',request()->program)->first();
@endphp
<div class="modal-header">
    <h3 class="modal-title">
        Going Live for <span class="text-danger">`{{$program->program_name}}`</span>
    </h3>
    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax-form" action="{{ route('admin.program.store_live',$program->getKey()) }}" method="post">
    <div class="modal-body p-2">
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="zoom-selection">
                        Select Zoom Account
                        <sup class="text-danger">
                            *
                        </sup>
                    </label>
                    <select name="zoom_account" id="zoom-selection" class="form-control">
                        @foreach (\App\Models\ZoomAccount::get() as $zoomAccount)
                            <option value="{{$zoomAccount->getKey()}}" @if($program->zoom == $zoomAccount->getKey()) selected @endif>{{$zoomAccount->account_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_section">
                        Program Section
                        <sup class="text-danger">*</sup>
                    </label>
                    <select class="form-control" name="section" id="section">
                        <option value="">Select Section </option>
                        @foreach ($program->sections as $section)
                            <option value="{{ $section->id }}"> {{ $section->section_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">
                    Start Live Session
                </button>
            </div>
        </div>
    </div>
</form>
