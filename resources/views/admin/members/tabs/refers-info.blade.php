@php
    /** @var  \App\Models\Member $member */
    $refers = \App\Models\MemberRefers::where('member_id',$member->getKey())->get();
@endphp

    <!-- Project table -->
<div class="card mb-4">
    <h5 class="card-header">Refer Lists</h5>

    <div class="table-responsive mb-3">
        <table class="table datatable-project border-top">
            <thead>
            <tr>
                <th>Full Name</th>
                <th class="text-nowrap">Phone Number</th>
                <th>Email Address</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
                @foreach ($refers as $refer)
                    <tr>
                        <td>{{$refer->full_name}}</td>
                        <td>{{$refer->phone_number}}</td>
                        <td>{{$refer->email_address}}</td>
                        <td>
                            {!! \App\Models\MemberRefers::STATUS_DISPLAY[$refer->status] !!}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<x-modal modal="ticketHistory"></x-modal>
