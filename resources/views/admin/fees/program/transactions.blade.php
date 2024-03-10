@extends('layouts.admin.master')
@push('page_title') Program  > Fee > Transactions @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_detail',['program' => $program])}}"> Programs</a> / </span> Transactions
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between">
            <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            {{-- <button data-bs-target="#quickUserView" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'programs.guests.index','program' => $program->getKey()])}}" class="btn btn-primary btn-icon ajax-modal">
                <i class="fas fa-plus"></i>
            </button> --}}
        </div>
    </div>

    @if(adminUser()->role()->isSuperAdmin())
        @include('admin.fees.program.partials.stat')
    @endif
    <div class="row">
        <div class="@if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin()) col-md-10 @else col-md-12 @endif">
            <!-- Responsive Datatable -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Transaction Overviews</h5>
                        <a href="{{route('admin.members.create')}}" class="btn btn-primary">Add Transaction</a>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table class="dt-responsive table" id="program_fee_overview">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>
                            @if($program->getKey() == 5) Voucher Number @else Category @endif
                            </th>
                            <th>Status</th>
                            <th>Tx Info</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Tx Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Responsive Datatable -->

        </div>
        <div class="@if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin()) col-md-2 @else col-md-2 d-none @endif">
            @include('admin.fees.program.partials.quick-navigation',['program' => $program])
        </div>
    </div>
    <x-modal modal="imageFile"></x-modal>
@endsection

@push('page_script')
    <script>
        $('#program_fee_overview').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{url()->full()}}',
            aaSorting: [],
            pageLength: 250,
            columns: [
                {
                    data: 'member_name',
                    name: "member_name"
                },
                {
                    data: "category",
                    name: "category"
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "media",
                    name: "media"
                },
                {
                    data: "source",
                    name: "source"
                },
                {
                    data: 'transaction_amount',
                    name: 'transaction_amount'
                },

                {
                    data: 'transaction_date',
                    name: "transaction_date"
                },
                {
                    data: "action",
                    name: "action"
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

    </script>
@endpush
