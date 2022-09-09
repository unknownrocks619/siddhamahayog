@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Programs/</span> My Programs</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header text-danger">Enrolled Programs</h5>
                <!-- Account -->
                <div class="card-body">
                    @forelse ($programs as $program )
                    <div class="card accordion-item">
                        <h2 class="accordion-header fs-3" id="{{ $program->program->slug }}Heading">
                            <button type="button" class="accordion-button fs-3 collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $program->program->slug }}" aria-expanded="true" aria-controls="{{ $program->program->slug }}">
                                {{$program->program->program_name}}
                            </button>
                        </h2>

                        <div id="{{ $program->program->slug }}" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <a href="" class="btn btn-primary mx-3">Reading Material</a>
                                <a href="" class="btn btn-info mx-2">Offline Videos</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-info">
                        You don't have any subscribed program.
                    </div>
                    @endforelse
                </div>
                <hr class="my-0" />

                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection