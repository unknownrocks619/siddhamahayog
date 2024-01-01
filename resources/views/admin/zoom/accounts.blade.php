@extends('layouts.admin.master')
@push('page_title') Zoom Accounts @endpush
@section('main')
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Zoom/</span> Accounts
            </h4>
            <button data-bs-target="#createAccount" data-bs-toggle="modal" class="btn btn-primary"><i class="fas fa-plus"></i>Add New Account</button>
        </div>
    </div>

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">All Accounts</h5>

        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="program-table">
                <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Zoom ID</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td>{{ $account->account_name }}</td>
                            <td>{{ $account->account_username }}</td>
                            <td>
                                <a href="#">{{ ucwords($account->account_status) }}</a>
                            </td>
                            <td>
                                <a href='{{route("admin.zoom.admin_zoom_account_edit",["zoom" => $account])}}' class='btn btn-primary btn-icon'>
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button data-method="post" data-action="{{route('admin.zoom.delete',['zoom'=> $account])}}" class="data-confirm btn btn-danger btn-icon" >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="createAccount">
        @include('admin.modal.zoom.create')
    </x-modal>
@endsection

@push('page_script')
    <script src="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

    <script>
        $('#program-table').DataTable();
    </script>
@endpush

@push('vendor_css')
    <link rel="stylesheet" href="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />

@endpush
