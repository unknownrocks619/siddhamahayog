@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Program /</span>
        <span class="text-muted fw-light"><a href="{{ route('user.account.programs.program.index') }}">{{ $program->program_name }}</a> /</span>
        Resources
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Available Resources for <span class="fs-4 text-primary">`{{ $program->program_name }}`</span></h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div class="button-wrapper">
                            <p class="text-muted mb-0">All Your resources for {{$program->program_name}} will be available here.</p>
                        </div>
                    </div>
                    <table class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($program->courses as $resource)
                            <tr>
                                <td>
                                    {{ $resource->resource_title }}
                                </td>
                                <td>
                                    @if($resource->resource_type == "image")
                                    @if( ! $resource->lock)
                                    <button data-href="{{ route('user.account.programs.resources.show',[$program->id,$resource->id]) }}" data-bs-toggle="modal" data-bs-target="#resourceImage" class="btn btn-link">
                                        @endif
                                        <i class="bx bx-image-alt fs-1"></i>
                                        View
                                        @if( ! $resource->lock)
                                    </button>
                                    @endif
                                    @elseif($resource->resource_type == "pdf")
                                    @if( ! $resource->lock)
                                    <button data-href="{{ route('user.account.programs.resources.show',[$program->id,$resource->id]) }}" class="btn btn-link clickable">
                                        @endif
                                        <i class="bx bxs-file-pdf fs-1"></i>
                                        Download
                                        @if( ! $resource->lock)
                                    </button>
                                    @endif
                                    @else
                                    @if( ! $resource->lock)
                                    <button data-href="{{ route('user.account.programs.resources.show',[$program->id,$resource->id]) }}" data-bs-toggle="modal" data-bs-target="#resourceImage" class="btn btn-link">
                                        @endif
                                        <i class='bx bxs-file-txt fs-1'></i> Read
                                        @if( ! $resource->lock)

                                    </button>
                                    @endif


                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr class="my-0" />
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resourceImage" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content" id="resourceContent">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFullTitle">{{ $program->program_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            Please wait while loading your content...
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@push("custom_script")
<script type="text/javascript">
    $("#resourceImage").on("shown.bs.modal", function(event) {
        $.ajax({
            method: "get",
            url: event.relatedTarget.dataset.href,
            success: function(response) {
                $("#resourceContent").html(response);
            }
        })
    });
</script>
@endpush