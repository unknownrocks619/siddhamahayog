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
            Absent List
        </span>
    </h4>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Holiday Request for `{{ $program->program_name }}`</h5>
                <small class="text-muted"><br /></small>
            </div>
            <div>
                <button class="btn btn-danger clickable" data-href="{{ route('user.account.programs.program.index') }}" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-block"></i> Close
                </button>
                <button class="btn btn-success clickable" data-href="{{ route('user.account.programs.program.request.create',$program->id) }}" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-list-plus'></i> New Request
                </button>
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