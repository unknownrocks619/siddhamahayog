<?php

use App\Models\Scholarship;
?>
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
                        @if($program->live)
                        <small class="text-muted">Started at {{ date('H:i A', strtotime($program->live->created_at)) }}</small>
                        <?php
                        $user_section = null;
                        if ($program->live->merge) {
                            $user_section = user()->section->program_section_id;
                            if (isset($program->live->merge->$user_section) || $program->live->section_id == NULL || $program->live->section_id == $user_section) :
                                echo "<small class='text-info ps-2'>";
                                echo "[Merged]";
                                echo "</small>";
                            endif;
                        }
                        ?>
                        @endif
                        @if($program->live && $program->live->live)
                        <?php
                        $roles = App\Models\Role::$roles
                        ?>
                        @if(array_key_exists(user()->role_id,$roles) && $roles[user()->role_id] == 'Admin')
                        <form action="{{ route('user.account.event.live_as_admin',[$program->live->id]) }}" method="post">
                            @csrf
                            <button onclick="this.innerText='Please wait...';" type="submit" class="fw-semibold btn btn-sm btn-success">
                                Join as Host
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                    <div class="user-progress">

                        <?php

                        $scholarship = Scholarship::where('program_id', $program->program_id ?? 0)
                            ->where('student_id', $program->student_id)
                            ->first();

                        ?>
                        <?php if ($program->program && $program->program->program_type == "paid" && $program->live && $program->live->live && $scholarship) : ?>

                            <form id="joinSessionForm" action="{{ route('user.account.event.live',[$program->program->id,$program->live->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="join_button fw-semibold btn btn-sm btn-success">
                                    Join Now
                                </button>
                            </form>

                        <?php elseif ($program->program && $program->program->program_type == "paid" && !$program->program->student_admission_fee && \App\Models\UnpaidAccess::totalAccess(user(), $program->program) <= site_settings('unpaid_access')) : ?>
                            <form id="joinSessionForm" action="{{ route('user.account.event.live',[$program->program->id,$program->live->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="join_button fw-semibold btn btn-sm btn-success">
                                    Join Now
                                </button>
                            </form>

                        <?php
                        elseif ($program->program && $program->program->program_type == "paid" && !$program->program->student_admission_fee) :
                            $url = route('user.account.programs.courses.fee.list', $program->program->id);
                        ?>
                            <button type="button" data-href="{{ $url }}" class="fw-semibold btn btn-sm btn-success clickable">
                                Pay now
                            </button>
                        <?php else : ?>
                            @if( $program->live && $program->live->section_id == $program->program_section_id)
                            <form id="joinSessionForm" action="{{ route('user.account.event.live',[$program->program->id,$program->live->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="join_button fw-semibold btn btn-sm btn-success">
                                    Join Now
                                </button>
                            </form>
                            @elseif($program->live && !$program->live->section_id)
                            <form id="joinSessionForm" action="{{ route('user.account.event.live',[$program->program->id,$program->live->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="fw-semibold btn btn-sm btn-success join_button">
                                    Join Now
                                </button>
                            </form>
                            @else
                            <?php
                            if (isset($user_section) && $user_section) {
                                $program_section_id = (isset($program->live) && isset($program->live->section_id)) ? $program->live->section_id : null;
                                if (isset($program->live->merge->$user_section) && $program->live || ($program->live->section_id == NULL || $program->live->section_id == $user_section)) :
                                    echo '<form id="joinSessionForm" action="' . route('user.account.event.live', [$program->program->id, $program->live->id]) . '" method="post">';
                                    echo csrf_field();
                                    echo '<button type="submit" class="fw-semibold btn btn-sm btn-success">';
                                    echo 'Join Now';
                                    echo '</button>';
                                    echo '</form>';
                                else :
                                    echo '<small class="fw-semibold btn btn-sm btn-secondary">';
                                    echo 'Not Available';
                                    echo '</small>';
                                endif;
                            } else {
                                echo '<small class="fw-semibold btn btn-sm btn-secondary">';
                                echo 'Not Available';
                                echo '</small>';
                            }
                            ?>

                            @endif
                        <?php endif; ?>
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
                    <h6 class="mb-0 fs-5">
                        सीताराम!!! हालै सुरु हुन गईरहेको अर्थपञ्चकको दोस्रो संस्करणमा
                        आफू वा आफ्नालाई सहभागी गराउनका लागि निम्न उल्लिखित लिङ्कमा गएर आफ्नो सम्पूर्ण विवरण खुलाएर फारम भर्नुहोला।
                    </h6>
                </div>
                <div class="user-progress">
                    <a href="{{ route('vedanta.create') }}" class="fw-semibold btn btn-primary clickable">
                        Sign Up
                    </a>
                </div>
            </div>
        </li>
        @endforelse
        @foreach ($openProgram as $open_program)
        @foreach($open_program->liveProgram as $live)
        <li class=" mb-4 pb-1 border-bottom @if($loop->iteration % 2 ) bg-light @endif">
            <div class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">{{ $open_program->program_name }}</h6>
                        <small class="text-muted">Started at {{ date('H:i A', strtotime($live->created_at)) }}</small>
                    </div>
                    <div class="user-progress">
                        <form id="joinSessionForm" action="{{ route('user.account.event.live_open',[$open_program->id,$live->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="join_button fw-semibold btn btn-sm btn-success">
                                Join Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
        @endforeach
    </ul>
</div>

<!-- / Content -->
@if(user()->role_id == 8)
<x-modal modal='userPopOption'>
    <div class="modal-body">
        <h6 class="header">
            Please select How would you like to join the session
        </h6>
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    @csrf
                    <label for="role">Select Your Role
                        <sup class="text-danger">*</sup>
                    </label>
                    <select name="role" id="role" class="form-control">
                        <option value="user">{{ user()->full_name }}</option>
                        <option value="ram-das">Ram Das</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4 py-3 bg-light">
                    <button type="submit" class="btn btn-primary">
                        Join Session
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-modal>
@endif