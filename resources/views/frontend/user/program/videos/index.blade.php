@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Program /</span>
        <span class="text-muted fw-light"><a href="{{ route('user.account.programs.program.index') }}">{{ $program->program_name }}</a> /</span>
        Offline Videos
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start align-items-sm-center gap-4 justify-content-between">
                    <h5>
                        Available Videos for <span class="fs-4 text-primary">`{{ $program->program_name }}`</span>
                    </h5>
                    <div class="dropdown">
                        <button data-href="{{ route('user.account.programs.program.index') }}" class="clickable btn btn-danger" type="button" id="orederStatistics">
                            <i class="bx bx-block"></i>
                            Close
                        </button>
                    </div>
                </div>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div class="button-wrapper">
                            <p class="text-muted mb-0">Offline Videos for {{$program->program_name}} will be available here.</p>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 bg-footer-theme d-none d-md-block">
                            <h4 class="pt-4 ps-3">Courses</h4>
                            <div class="row pb-4">
                                <div class="accordion mt-3" id="accordionExample">
                                    @forelse ($program->videoCourses as $courses)
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button type="button" class="accordion-button border-bottom bg-secondary text-white" data-bs-toggle="collapse" data-bs-target="#{{ $courses->slug }}" aria-expanded="true" aria-controls="accordionTwo">
                                                {{ $courses->course_name }}
                                            </button>
                                        </h2>
                                        <div id="{{ $courses->slug }}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @if($courses->lession)
                                                <ul class="list-group lms-list">
                                                    @endif
                                                    @forelse ($courses->lession as $lession)
                                                    <li class="list-group-item border-bottom-1 border-start-0 border-end-0 border-top-0 rounded-0">
                                                        <button class="btn btn-link ps-0 watchLession" data-href="{{ route('user.account.programs.videos.show',[$program->id,$courses->id,$lession->id]) }}" type="button"><i class='bx bxs-movie-play me-2'></i> {{ $lession->lession_name }}</button>
                                                    </li>
                                                    @empty
                                                    <div class="alert alert-danger mt-3">
                                                        Lessions for {{ $courses->course_name }} is currently unavailable.

                                                    </div>
                                                    @endforelse
                                                    @if($courses->lession)
                                                </ul>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header bg-primary">
                                            <button type="button" class="accordion-button bg-primary text-white" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="true" aria-controls="accordionTwo">
                                                {{ $program->program_name }}
                                            </button>
                                        </h2>
                                        <div id="accordionTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="alert alert-info">
                                                    Videos for {{ $program->program_name }} is currently unavailable.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 border-end border-bottom border-top">
                            <div style="position:relative" class="w-100 h-100">
                                <div class="progress mt-5" style="height:25px;position:absolute;z-index:9">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 100%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div id="videoContent">
                                    @if($program->last_video_history)
                                    @include("frontend.user.program.videos.modal.history",["watchHistory" => $program->last_video_history])
                                    @else
                                    @include("frontend.user.program.videos.modal.no-history")
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 bg-footer-theme d-sm-none">
                            <h4 class="pt-4 ps-3">Courses</h4>
                            <div class="row">
                                <div class="accordion mt-3" id="accordionExample">
                                    @forelse ($program->videoCourses as $courses)
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button type="button" class="accordion-button border-bottom bg-secondary text-white" data-bs-toggle="collapse" data-bs-target="#{{ $courses->slug }}" aria-expanded="true" aria-controls="accordionTwo">
                                                {{ $courses->course_name }}
                                            </button>
                                        </h2>
                                        <div id="{{ $courses->slug }}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @if($courses->lession)
                                                <ul class="list-group">
                                                    @endif
                                                    @forelse ($courses->lession as $lession)
                                                    <li class="list-group-item border-bottom-1 border-start-0 border-end-0 border-top-0 rounded-0">
                                                        <button class="btn btn-link ps-0 watchLession" data-href="{{ route('user.account.programs.videos.show',[$program->id,$courses->id,$lession->id]) }}" type="button"><i class='bx bxs-movie-play me-2'></i> {{ $lession->lession_name }}</button>
                                                    </li>
                                                    @empty
                                                    <div class="alert alert-danger mt-3">
                                                        Lessions for {{ $courses->course_name }} is currently unavailable.

                                                    </div>
                                                    @endforelse
                                                    @if($courses->lession)
                                                </ul>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header bg-primary">
                                            <button type="button" class="accordion-button bg-primary" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="true" aria-controls="accordionTwo">
                                                {{ $program->program_name }}
                                            </button>
                                        </h2>
                                        <div id="accordionTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="alert alert-info">
                                                    Videos for {{ $program->program_name }} is currently unavailable.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- /Content -->
@endsection

@push("custom_script")
<script type="text/javascript">
    $(document).ajaxStart(function() {
        $('.progress').fadeIn('fast', function() {
            $(this).removeClass('d-none');
        });

    }).ajaxStop(function() {
        $(".progress").fadeOut('medium', function() {
            $(this).addClass("d-none");
        })
    });

    $(".watchLession").click(function(event) {
        event.preventDefault();
        $("ul.lms-list li").removeClass("text-success")
        $(this).addClass('text-success');
        $.ajax({
            type: "get",
            url: $(this).data("href"),
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            },
            success: function(response) {
                $("#videoContent").html(response);
            }
        })
    })
</script>
@endpush