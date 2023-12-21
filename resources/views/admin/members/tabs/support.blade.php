@php
    /** @var  \App\Models\Member $member */
    $supportTickets = \App\Models\SupportTicket::where('member_id',$member->getKey())
                                                ->with('user')
                                                ->whereNull('parent_id')
                                                ->orderBy('updated_at','DESC')
                                                ->get();
@endphp

    <!-- Project table -->
<div class="card mb-4">
    <h5 class="card-header">Support Tickets</h5>

    <div class="table-responsive mb-3">
        <table class="table datatable-project border-top">
            <thead>
            <tr>
                <th>Title</th>
                <th class="text-nowrap">Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
                @foreach ($supportTickets as $ticket)
                    <tr>
                        <td> {{$ticket->title}} </td>
                        <td>
                            {!! __("support.".$ticket->status) !!}
                        </td>
                        <td>
                            <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Close Ticket" data-confirm="You are about to close a ticket. Notice Status notification will be sent to customer. Do you wish to continue ?" class="btn btn-icon btn-danger data-confirm" data-action="{{route('admin.supports.tickets.close',$ticket->getKey())}}" data-method="post">
                                <i class="ti ti-square-letter-x"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-info ajax-modal"  data-bs-target="#ticketHistory" data-bs-toggle="modal" data-bs-original-title="Reply Support Ticket" data-action="{{route('admin.modal.display',['view' => 'programs.reply-support','ticket' => $ticket->getKey()])}}" data-method="post">
                                <i class="ti ti-message-2-share"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<x-modal modal="ticketHistory"></x-modal>
