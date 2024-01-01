@php
$program = \App\Models\Program::where('id',request()->program)->first();
$lives = \App\Models\Live::where('program_id',$program->getKey())->where('live',true)->get();
$liveSections = $program->liveProgram()->where('section_id','!=',NULL)->get();
$liveSectionsIDS = $liveSections->groupBy('section_id')->toArray();
@endphp
<form method="post" class="ajax-form" action="{{ route('admin.program.live_program.merge.store',['program'=>$program]) }}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Merge Program Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_name">Program Name <sup class="text-danger">*</sup></label>
                    <span class="form-control disabled bg-light">{{$program->program_name}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="active_section">Active Section <sup class="text-danger">*</sup></label>
                    <select name="active_section" id="active_section" class="form-control">
                        @if ( ! $liveSections->count() )
                            <option value="" selected disabled>All Section Are Live</option>
                        @else
                            @foreach ($liveSections as $liveSection)
                                <option value="{{$liveSection->section_id}}">{{$liveSection->programSection->section_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="to_merge">Select Section to Merge <sup class="text-danger">*</sup></label>
                    @php $sections = $program->sections()->get();@endphp
                    <select name="merge_with" id="to_merge" class="form-control">
                        @if( !  $sections->count() )
                            <option value="" selected disabled>No Active Section Available</option>
                        @else
                            @foreach ($sections as $section)
                                @if ( ! $lives->where('section_id',$section->getKey())->first()) )
                                    <option value="{{$section->getKey()}}">{{$section->section_name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
