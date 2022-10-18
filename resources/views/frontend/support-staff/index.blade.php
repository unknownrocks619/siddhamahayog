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
    <x-alert></x-alert>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Support Ticket</h5>
                <small class="text-muted">Response your customer tickets</small>
            </div>
            <div class="dropdown">
                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics" style="">
                    <a class="dropdown-item" href="{{ route('supports.staff.tickets.index',['status'=>'open']) }}">Open Ticket</a>
                    <a class="dropdown-item" href="{{ route('supports.staff.tickets.index',['status'=>'waiting_response']) }}">Customer Response</a>
                    <a class="dropdown-item" href="{{ route('supports.staff.tickets.index',['status' => 'completed']) }}">Closed Ticket</a>
                    <a class="dropdown-item" href="{{ route('supports.staff.tickets.index',['category'=>'technical_support']) }}">Technical Issue</a>
                    <a class="dropdown-item" href="{{ route('supports.staff.tickets.index',['category' => 'admission']) }}">Admission Issue</a>
                    <a class="dropdown-item" href="{{ route('supports.staff.tickets.index',['category' => 'other']) }}">Other Issue</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>

                            <th>
                                Date
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                #Issue
                            </th>
                            <th>
                                Member Name
                            </th>
                            <th>

                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_tickets as $ticket)
                        <tr>

                            <td>
                                <?php
                                $date = \Carbon\Carbon::parse($ticket->updated_at);
                                echo $date->format('Y-m-d H:i');
                                ?>
                            </td>
                            <td>
                                @if($ticket->status == "completed" || $ticket->statu == "rejected")
                                <span href="{{ route('supports.staff.tickets.show',$ticket->id) }}" class="btn btn-primary">
                                    <i class="bx bx-edit-alt"></i>
                                    Completed
                                </span>
                                @else
                                <a href="{{ route('supports.staff.tickets.show',$ticket->id) }}">{!! __("support.".$ticket->status) !!}</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('supports.staff.tickets.show',$ticket->id) }}" class="fs-5">{{ $ticket->title }}</a>
                                <br />
                                {!! __("support.".$ticket->priority) !!}
                                {!! __("support.".$ticket->category) !!}
                            </td>
                            <td>
                                {{ $ticket->user->full_name }}
                            </td>
                            <td>
                                @if($ticket->status != "completed" && $ticket->statu != "rejected")
                                <form action="{{ route('supports.staff.tickets.destroy',$ticket->id) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger btn-sm">Close Ticket</button>
                                </form>
                                @else
                                <span class="btn btn-sm btn-outline-danger">Closed</span>

                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="5" class="text-center">Ohm ! You don't have any tickets.</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection