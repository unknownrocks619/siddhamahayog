@extends('frontend.theme.portal')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Programs/</span> My Programs</h4>

        <div class="row">
            <div class="col-md-12">
                <h4>
                    My Enrolled Programs
                </h4>
            </div>
        </div>
        @forelse($programs as $program)
            <div class="row mb-1">
                <div class="col-md-12  bg-white py-2 d-flex justify-content-between align-content-center">
                    <h5 class="mb-0 mt-2">{{ $program->program->program_name }}</h5>
                    <div>
                        <button
                            class="btn btn-primary @if ($program->active) clickable @else disabled @endif"
                            @if ($program->active) data-href="{{ route('user.account.programs.resources.index', $program->program->id) }} @endif">Reading
                            Material</button>
                        <button
                            class="btn btn-info @if ($program->active) clickable @else disabled @endif"
                            @if ($program->active) data-href="{{ route('user.account.programs.videos.index', $program->program->id) }}" @endif>Offline
                            Videos</button>
                        <button
                            @if ($program->active) data-href="{{ route('user.account.programs.program.request.index', $program->program->id) }}" @endif
                        class="@if ($program->active) clickable @else disabled @endif btn btn-info">Absent
                            Form</button>
                        <button
                            data-href="{{ route('user.account.programs.courses.fee.list', $program->program->id) }}"
                            class="clickable btn btn-primary">My Payment</button>
                        <button
                            data-href="{{ route('frontend.jaap.index', $program->program->id) }}"
                            class="clickable btn btn-primary">My Mantra Count</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                You don't have any subscribed program.
            </div>
        @endforelse
    </div>
    <!-- / Content -->
@endsection
