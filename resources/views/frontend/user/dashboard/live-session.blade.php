<?php

use App\Models\Scholarship;
?>
<div class="card-body">
    <ul class="p-0 m-0 mt-3 list-unstyled">
        @forelse ($enrolledPrograms as $program)
        <li class=" mb-4 pb-1 border-bottom @if ($loop->iteration % 2) bg-light @endif">
            <div class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">{{ $program->program->program_name }}</h6>
                        @include('frontend.live.dashboard.live-merged', compact('program'))

                        @include('frontend.live.dashboard.host', compact('program'))
                    </div>
                    <div class="user-progress">
                        @include('frontend.user.dashboard.button', compact('program'))
                        @includeWhen(
                        $program->active,
                        'frontend.live.dashboard.absent-form',
                        ['program' => $program])
                    </div>
                </div>
            </div>

            @if (\App\Models\Role::ACTING_ADMIN == user()->role_id || \App\Models\Role::SUPER_ADMIN == user()->role_id)
            @include('frontend.user.dashboard.buttons.admin', ['program' => $program])
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
                        आफू वा आफ्नालाई सहभागी गराउनका लागि निम्न उल्लिखित लिङ्कमा गएर आफ्नो सम्पूर्ण विवरण खुलाएर
                        फारम भर्नुहोला।
                    </h6>
                </div>
                <div class="user-progress">
                    <a href="{{ route('vedanta.index') }}" class="fw-semibold btn btn-primary clickable">
                        Sign Up
                    </a>
                </div>
            </div>
        </li>
        @endforelse

        @foreach ($openProgram as $open_program)
        @foreach ($open_program->liveProgram as $live)
        <li class=" mb-4 pb-1 border-bottom @if ($loop->iteration % 2) bg-light @endif">
            <div class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary"><i
                            class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">{{ $open_program->program_name }}</h6>
                        <small class="text-muted">Started at
                            {{ date('H:i A', strtotime($live->created_at)) }}</small>
                    </div>
                    <div class="user-progress">
                        <form id="joinSessionForm"
                            action="{{ route('user.account.event.live_open', [$open_program->id, $live->id]) }}"
                            method="post">
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
@if (user()->role_id == 8)
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