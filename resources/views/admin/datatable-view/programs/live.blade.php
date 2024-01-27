<button
        @if(!in_array(auth()->user()->role_id,\App\Models\Program::GO_LIVE_ACCESS)) disabled="disabled" @endif
        class='ajax-modal btn btn-success mb-1 @if(!in_array(auth()->user()->role_id,\App\Models\Program::GO_LIVE_ACCESS)) disabled @endif'
        data-action='{{route('admin.modal.display',['view' => 'live.live-selection','program' => $row->getKey()])}}'
        data-bs-toggle='modal'
        data-bs-target='#liveSessionModal'>Go Live</button>

@if ( $row->liveProgram->count())
    <br />
    @foreach ($row->liveProgram as $live_program)
        @if($live_program->merge)
            @foreach ((array) $live_program->merge as $mergeInfo )
                <button class="btn btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-original-title="{{$mergeInfo->name}} Merged with {{$live_program->sections->section_name}}" title="{{$mergeInfo->name}} Merged with {{$live_program->sections->section_name}}">
                    <i class="fas fa-exclamation"></i>
                </button>
            @endforeach
        @endif
        <button
            @if(!in_array(auth()->user()->role_id,\App\Models\Program::GO_LIVE_ACCESS)) disabled="disabled" @endif
            class="mb-1 btn btn-danger btn-sm data-confirm @if(!in_array(auth()->user()->role_id,\App\Models\Program::GO_LIVE_ACCESS)) disabled @endif"
            data-title="Confirm Your Action"
            data-confirm="You are about to end the session. The user will no longer be able to join. This will not affect the Zoom session."
            data-method="post"
            data-action="{{route('admin.program.live_program.end', [$live_program->id])}}">
            @if (! $live_program->section_id) {
                End Live Session
            @else
                End {{$live_program->sections->section_name}} Program
            @endif
        </button>
  @endforeach
    <br />
    <button
            @if(!in_array(auth()->user()->role_id,\App\Models\Program::GO_LIVE_ACCESS)) disabled="disabled" @endif
            data-action='{{route('admin.modal.display',['view' => 'live.merge-selection','program' => $row->getKey(),'live' => $live_program->getKey()])}}{{--route('admin.program.live_program.merge.view', [$row->id, $live_program->id])--}}'
            data-bs-toggle='modal' data-bs-target='#mergeSession'
            class='btn btn-info btn-sm mb-1 ajax-modal @if(!in_array(auth()->user()->role_id,\App\Models\Program::GO_LIVE_ACCESS)) disabled @endif'>
        Merge
    </button>
@endif
