@extends("frontend.theme.portal")

@section("title")
Support Ticket
@endsection

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        Support
    </h4>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Support Ticket</h5>
                <small class="text-muted">Report your problem.</small>
            </div>
            <div class="dropdown">
                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics" style="">
                    <a class="dropdown-item" href="{{ route('user.account.support.ticket.create') }}">Create New Ticket</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th>
                                Status
                            </th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($tickets as $ticket)
                        <tr>
                            <td>
                                @if($ticket->status != "completed" && $ticket->statu != "rejected")
                                <a href="{{ route('user.account.support.ticket.show',$ticket->id) }}" class="btn btn-primary">
                                    <i class="bx bx-edit-alt"></i>
                                    Reply
                                </a>
                                @else
                                <a href="#" class="btn btn-secondary">Closed</a>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('user.account.support.ticket.show',$ticket->id) }}">{{ $ticket->title }}</a>
                                <br />
                                {!! __("support.".$ticket->priority) !!}
                                {!! __("support.".$ticket->category) !!}
                            </td>

                            <td>
                                {!! __("support.".$ticket->status) !!}
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $ticket->total_count }}</span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No Active tickets</td>
                        </tr>
                    </tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection