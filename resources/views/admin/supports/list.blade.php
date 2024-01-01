@extends('layouts.admin.master')
@push('page_title') Program List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Supports/</span> All
    </h4>
    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Customer Issue Tickets</h5>

        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="program-table">
                <thead>
                <tr>
                    <th>Priority</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>
                            {!! __("support.".$ticket->priority) !!}
                        </td>
                        <td>
                            {!! __("support.".$ticket->category) !!}
                        </td>
                        <td>
                            {!! __("support.".$ticket->status) !!}
                        </td>
                        <td>
                            {{ $ticket->user->first_name }} {{ $ticket->middle_name }}
                            {{ $ticket->user->last_name }}
                        </td>
                        <td>
                            {{ date('Y-m-d', strtotime($ticket->created_at)) }}
                        </td>
                        <td>
                            <a class="btn btn-primary btn-info" href="{{ route('admin.supports.tickets.show',['ticket' => $ticket,'type'=>request()->type,'filter'=>request()->filter]) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button data-method="post" data-action="{{route('admin.supports.tickets.close',['ticket'=>$ticket])}}" type="submit" class="btn btn-danger btn-icon data-confirm" data-confirm="You are about to close the ticket which is in `{{ strip_tags(__("support.".$ticket->status))}}` state. An update will be sent to customer. Are you sure ?">
                                <i class="fas fa-close"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('page_script')
    <script>$('#program-table').DataTable();</script>
@endpush
