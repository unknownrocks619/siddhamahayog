@extends("frontend.theme.portal")

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light">
            <a href="{{ route('user.account.programs.program.index') }}">Program</a> /
        </span>
        <span class="text-muted fw-light">
            Holiday Request
        </span>
    </h4>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Holiday Request for `{{ $program->program_name }}`</h5>
                <small class="text-muted"><br /></small>
            </div>
            <div class="dropdown">
                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics" style="">
                    <button class="dropdown-item clickable" data-href="{{ route('user.account.programs.program.request.create',$program->id) }}">Request New Holiday</button>
                    <a class="dropdown-item text-danger" href="javascript:void(0);">Delete All</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover-table-bordered">
                <thead>
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leave_requests as $leave)
                    <tr>
                        <td>{{ $leave->start_date }}</td>
                        <td>{{ $leave->end_date }}</td>
                        <td>{!! __("holiday.".$leave->status) !!}</td>
                        <td>View | Delete</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            You don't have any holiday request.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection