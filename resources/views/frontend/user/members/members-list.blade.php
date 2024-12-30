@extends('frontend.theme.portal')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <x-alert></x-alert>
            @include('frontend.user.dashboard.incomplete')
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="">
                <div class="card alert alert-danger">
                    <div class="card-header mb-0 pb-0 alert-title">
                        <h4>Register New Sadhak</h4>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="card-headerps-0 d-flex justify-content-between align-items-center  border-1 border-bottom pb-3 mb-3">
                            <h4>Members</h4>
                            <div>
                                <a href="{{route('user.my-member')}}" class="btn btn-primary btn-icon"><i class="menu-icon bx bx-arrow-from-right ms-1"></i></a>
                                <button class="btn btn-primary js-toggle-view" type="button"
                                    data-target="#memberRegistration">New
                                    Member</button>
                            </div>
                        </div>
                        @include('frontend.user.members.partials.registration')
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="underLinksMembersLists" data-action="">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Address </th>
                                        <th>Phone Number</th>
                                        <th data-sorting='false'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($members as $member)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $member->full_name() }}
                                            </td>
                                            <td>
                                                {{ $member->address?->street_address }} , {{ $member->city }},
                                                {{ $member->countries?->name }}
                                            </td>
                                            <td>
                                                {{ $member->phone_number }}
                                            </td>
                                            <td class="text-end">
                                                {{-- <a href="" class="btn btn-primary">
                                                    View Members
                                                </a> --}}
                                                <a href="{{route('user.account.list',['member'=> $member])}}" class="btn  btn-primary"><i
                                                        class="menu-icon bx bx-pencil me-0"></i> Edit</a>
                                                <a href="" class="btn  btn-danger"><i
                                                        class="menu-icon bx bx-trash me-0"></i> Delete</a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
    <x-modal modal='newSession'>
        @include('frontend.user.members.modals.new-session')
    </x-modal>
@endsection

@push('custom_script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" />
@endpush
