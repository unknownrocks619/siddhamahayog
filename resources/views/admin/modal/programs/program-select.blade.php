<form method="post" class="ajax-form" action="{{ route('admin.program.enroll.admin_student_enroll_in_program',request()->member) }}">

    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2">
        <!-- Select User -->
        <div class="mb-4 pb-2">
            <label for="select2Basic" class="form-label fs-4">Select Program to Enroll</label>
            <div class="position-relative">
                <div class="position-relative">
                    <div class="position-relative">
                        <select name="program_name" id="select2Basic" class="form-select form-select-lg share-project-select " data-allow-clear="true">
                            @foreach(\App\Models\Program::with(['students'])->where('status','active')->get() as $program)
                                @if(request()->member && $program->students()->where('student_id', request()->member)->exists())
                                    @php continue; @endphp
                                @endif
                                <option value="{{$program->getKey()}}">{{$program->program_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Enroll User
                </button>
            </div>
        </div>
    </div>
</form>
