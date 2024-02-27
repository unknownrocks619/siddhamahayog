@extends('layouts.admin.master')

@section('main')
    <div class="row">
        <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="cart-title mb-1">
                            Request Permission
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-border table-hover" id="permission_request_table">
                                <thead>
                                <tr>
                                    <th>Center</th>
                                    <th>Staff</th>
                                    <th>Request Type</th>
                                    <th>Request Section</th>
                                    <th>Old Value</th>
                                    <th>New Value</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissionRequests as $permission)
                                        <tr>
                                            <td>
                                                {{$permission->center->center_name}}
                                            </td>
                                            <td>
                                                {{ $permission->staffUser->full_name() }}
                                            </td>
                                            <td>
                                                @if($permission->request_type === 'update')
                                                    <span class="badge bg-label-warning">Update</span>
                                                @else
                                                    <span class="badge bg-label-danger">Delete</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($permission->update_column === 'amount')
                                                    Transcation Amount
                                                @elseif($permission->update_column === 'transaction_verification')
                                                    Transaction Verification
                                                @elseif($permission->update_column == 'transaction_voucher_number')
                                                    Voucher Number
                                                @elseif($permission->update_column == 'transaction_delete')
                                                    Delete Transaction
                                                @else
                                                    Other
                                                @endif

                                            </td>
                                            <td>
                                                @if($permission->update_column === 'amount')
                                                    {{$permission->old_value}}
                                                @elseif($permission->update_column === 'transaction_verification')
                                                    {{$permission->old_value}}
                                                @elseif($permission->update_column == 'transaction_voucher_number')
                                                    {{$permission->old_value}}
                                                @else
                                                    NRs. {{  $permission->row_old_value['amount']}}
                                                @endif
                                            </td>

                                            <td>
                                                @if($permission->update_column === 'amount')
                                                    {{$permission->new_value}}
                                                @elseif($permission->update_column === 'transaction_verification')
                                                    {{$permission->new_value}}
                                                @elseif($permission->update_column == 'transaction_voucher_number')
                                                    {{$permission->new_value}}
                                                @else
                                                    NRs. 0
                                                @endif
                                            </td>
                                            <th>
                                                <button data-confirm="You are about to approve the request made by center. You will not be able revert the changes. Do you still wish to continue ?" data-method="post" data-action="{{route('admin.permission-request.list',['permission'=>$permission,'type'=>2])}}" class="btn btn-primary data-confirm">Approve</button>
                                                <a href="" class="btn btn-danger">Reject</a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
    </div>
@endsection

@push('page_script')
    <script src="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

    <script>
        $('#permission_request_table').DataTable()
    </script>
@endpush
