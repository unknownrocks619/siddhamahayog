@extends("frontend.theme.portal")

@section("content")
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Programs/</span> My Programs</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4"  style="box-shadow:none">
                <!-- Account -->
                <div class="card-body">
                    <div class="card mb-2">
                        <h2 class="fs-3" id="">
                                {{$program->program_name}}
                        </h2>
                        <p>
                             Oops ! You are not authorized to view this page.
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-primary clickable" data-href="{{ route('user.account.programs.program.index') }}">
                        <x-arrow-left>
                                    Go Back
                        </x-arrow-left>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- / Content -->
@endsection
