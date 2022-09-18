<div class="card-body">
    <ul class="p-0 m-0 mt-3 list-unstyled">
        @forelse ($enrolledPrograms as $program)
        <li class=" mb-4 pb-1 border-bottom @if($loop->iteration % 2 ) bg-light @endif">
            <div class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">{{ $program->program->program_name }}</h6>
                        <small class="text-muted">{{ ($program->live) ? "Started at" .  date('H:i A', strtotime($program->live->create_at)) : Null }}</small>
                    </div>
                    <div class="user-progress">
                        @if($program->program && $program->program->program_type == "paid" && ! $program->program->student_admission_fee)
                        <?php

                        $url = url()->temporarySignedRoute('vedanta.payment.create', now()->addMinute(10), $program->id);
                        ?>
                        <button type="button" data-href="{{ $url }}" class="fw-semibold btn btn-sm btn-success clickable">
                            Pay now
                        </button>
                        @else
                        @if( $program->live && $program->live->section_id == $program->program_section_id)
                        <form action="{{ route('user.account.event.live',[$program->program->id,$program->live->id]) }}" method="post">
                            @csrf
                            <button onclick="this.disabled=true;this.value='Joining...'" type="submit" class="fw-semibold btn btn-sm btn-success">
                                Join Now
                            </button>
                        </form>
                        @elseif($program->live && !$program->live->section_id)
                        <form action="{{ route('user.account.event.live',[$program->program->id,$program->live->id]) }}" method="post">
                            @csrf
                            <button type="submit" onclick="this.disabled=true;this.innerText='Joining...';this.form.submit();" class="fw-semibold btn btn-sm btn-success">
                                Join Now
                            </button>
                        </form>
                        @else
                        <small class="fw-semibold btn btn-sm btn-secondary">
                            Not Available
                        </small>
                        @endif
                        @endif
                        <button data-href="{{ route('user.account.programs.program.request.create',$program->program->id) }}" class="clickable fw-semibold btn btn-sm btn-outline-warning d-inline mt-2">
                            Absent Form
                        </button>
                    </div>
                </div>
            </div>
            @if($program->program && $program->program->program_type == "paid" && ! $program->program->student_admission_fee)
            <p class="text-danger w-100 text-end">

                Your admission for `{{ $program->program->program_name }}` is pending. Please submit your admission fee.
            </p>
            @endif
        </li>
        @empty
        <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                    <h6 class="mb-0">Program not Found</h6>
                </div>
                <div class="user-progress">
                    <small class="fw-semibold btn btn-sm btn-secondary">
                        Not Available
                    </small>
                </div>
            </div>
        </li>
        @endforelse
    </ul>
</div>