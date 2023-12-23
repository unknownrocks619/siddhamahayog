
<form method="post" class="ajax-form" action="{{route('admin.program.sections.admin_store_section',['program' => request()->program])}}">

    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-5">
        @if(request()->program)
            <input type="hidden" name="params['program']" value="{{request()->program}}" />
            <input type="hidden" name="callback" value="assignSectionToProgram">
        @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="section_name">
                            Section Name
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="section_name" id="section_name" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" name="default" value="1" type="checkbox" id="defaultSection">
                            <label class="form-check-label" for="defaultSection">Make Default Section</label>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Save & Add Section
                </button>
            </div>
        </div>
    </div>
</form>
