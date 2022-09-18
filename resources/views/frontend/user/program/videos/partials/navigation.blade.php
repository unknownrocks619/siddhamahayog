<div class="row pb-4">
    <div class="accordion mt-3" id="accordionExample">
        @forelse ($program->videoCourses as $courses)
        <div class="card accordion-item">
            <h2 class="accordion-header">
                <button type="button" class="accordion-button border-bottom bg-secondary text-white" data-bs-toggle="collapse" data-bs-target="#{{ $courses->slug }}" aria-expanded="true" aria-controls="accordionTwo">
                    {{ $courses->course_name }}
                </button>
            </h2>
            <div id="{{ $courses->slug }}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
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
            <div id="accordionTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
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