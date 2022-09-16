<div class="modal-header bg-secondary text-white">
    <h5 class="modal-title text-white" id="modalFullTitle">{{ $program->program_name }} - {{ $programResource->resource_title }}</h5>
    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    @if($programResource->description)
    <div class="fs-5 text-dark">
        {!! $programResource->description !!}
    </div>
    @endif
    <div class="text-center"><img src="{{ asset($programResource->resource->path) }}" class="img-fluid text-center" /></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
        Close
    </button>
</div>