@if( ! $program->live)
    <a class="btn btn-danger" href="{{route('admin.program.store_live',[$program->getKey()])}}" data-bs-toggle='modal' data-bs-target='#goLive'>
        Go Live {{ $program->program_name}} - {{$program->getKey()}} [{{ $program->id}}]
    </a>
<x-modal modal="goLive">
    <div id="modal_content">

    </div>
</x-modal>
@else
<form action="{{route('admin.program.live_program.end',[$program->live->getKey()])}}" method="post">
    @csrf
    <button class="btn btn-warning" type="submit">
        End Session
    </button>
</form>
@endif
