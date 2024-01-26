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
            <button data-bs-target="#quickUserView" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'programs.guests.index','program' => $program->getKey()])}}" class="btn btn-primary btn-icon ajax-modal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    @include('admin.fees.program.partials.stat')
    <div class="row">
        <div class="col-md-10">
            <!-- Responsive Datatable -->
            <div class="card">
                <h5 class="card-header">Transaction Overviews</h5>

                <div class="card-datatable table-responsive">
                    <table class="dt-responsive table" id="program_fee_overview">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
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
        <div class="col-md-2">
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
