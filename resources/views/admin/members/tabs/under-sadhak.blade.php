@php
    /** @var  \App\Models\Member $member */
    $memberSessions = $member->mySession()->get();
@endphp

<!-- Project table -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="card-title mb-0">
            {{ $member->full_name }} Trained Sadhak's</h5>
        <button type='button' class="js-toggle-view btn btn-primary me-2" data-target='#memberRegistration'><i
                class="fas fa-plus"></i> Register New Sadhak</button>
    </div>

    <div class="card-body">
        @include('frontend.user.members.partials.registration')
        <div class="table-responsive mb-3">
            <table class="table datatable-project border-top dataTable">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th class="text-nowrap">Phone Number</th>
                        <th>Registration Date</th>
                        <th>Training Info</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($memberSessions as $memberSession)
                        @foreach ($memberSession->enrolledUsers ?? [] as $sadhakMember)
                            <tr>
                                <td>{{ $sadhakMember->full_name }}</td>
                                <td>{{ $sadhakMember->phone_number }}</td>
                                <td>{{ $sadhakMember->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $memberSession->course_group_name }}</strong>
                                </td>
                                <td>
                                    <br />
                                    <p>{{ $member->address?->street_address }},{{ $memberSession->city }},{{ $memberSession->countries?->name }}
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex ">

                                        <a href="{{ route('admin.members.show', ['member' => $sadhakMember->getKey(), '_ref' => 'teacher', '_refID' => $member->getKey()]) }}"
                                            class="btn btn-primary btn-icon btn-sm me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- <a href="" class="btn btn-sm btn-icon btn-danger data-confirm"
                                            data-confirm="This will only unlink the user from {{ $member->full_name }}. Do you wish to continue ?">
                                            <i class="fas fa-trash"></i>
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
