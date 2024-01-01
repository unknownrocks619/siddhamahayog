@extends('layouts.admin.master')
@push('page_title') Member > Transaction > {{ $member->full_name }} @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}"> Programs</a> / <a href="">Transactions</a> / </span> {{$member->full_name}}
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between">

            <a href="{{ route('admin.program.fee.admin_fee_overview_by_program', ['program' => $program])   }}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            <button data-bs-target="#quickUserView" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'programs.guests.index','program' => $program->getKey()])}}" class="btn btn-primary btn-icon ajax-modal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <!-- Responsive Datatable -->
            <div class="card">
                <h5 class="card-header">Transaction Overviews</h5>

                <div class="card-datatable table-responsive">
                    <table class="dt-responsive table" id="program_fee_overview">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Media</th>
                            <th>Amount</th>
                            <th>Tx Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($transaction->transactions as $all_detail_transaction)
                            <tr>
                                <td>
                                    @php
                                        $category_explode = explode('_',$all_detail_transaction->amount_category);
                                        foreach ( $category_explode as $category):
                                        echo ucwords(strtolower($category)) . " ";
                                        endforeach
                                    @endphp
                                </td>

                                <td>
                                    {{ $all_detail_transaction->source }}
                                    <hr />
                                    {!! $all_detail_transaction->source_detail !!}
                                </td>

                                <td>
                                    @if($all_detail_transaction->verified)
                                        <span class="badge bg-label-success">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Transaction Verified" title="Transaction Verified">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </span>
                                    @else
                                        <span class="badge bg-label-danger">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Transaction Rejected" title="Rejected">
                                                <i class="fas fa-close"></i>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($all_detail_transaction->file)

                                    @else

                                    @endif
                                    <?php
                                        // if ($all_detail_transaction->file) {
                                        //     $file_object = $all_detail_transaction->file;
                                        //     echo "<a href='" . asset($file_object->path) . "'>" . $all_detail_transaction->type . "</a>";
                                        // } else {
                                        //     echo "N/A";
                                        // }
                                    ?>
                                </td>
                                <td>
                                    {{ default_currency($all_detail_transaction->amount) }}
                                </td>

                                <td>
                                    {{ date("Y-m-d", strtotime($all_detail_transaction->created_at)) }}
                                </td>

                                <td>

                                    @if ($all_detail_transaction->verified)
                                        <button data-method='PUT' data-confirm='You are about to change the transaction status to `Unverified` state. User will be notified about the change. Are you sure you want to continue ?' data-action="{{route('admin.program.fee.api_update_fee_detail', ['fee_detail' => $all_detail_transaction->id])}}" type='button' class='btn btn-danger data-confirm btn-sm'>Reject</button>
                                    @else
                                        <button data-method="PUT" type='button' data-confirm='You are about to update the transaction status to `Verified`. User will be notified about the changes. Do you wish to continue your action ?' data-action="{{route('admin.program.fee.api_update_fee_detail', ['fee_detail' => $all_detail_transaction->id])}}" class='data-confirm btn btn-success btn-sm'>Verify</button>;
                                    @endif

                                    <button type='button' data-action="{{route('admin.program.fee.api_delete_fee', $all_detail_transaction->id)}}" data-method="DELETE" data-confir="You are about to delete selected transaction. This action cannot be undone. Do you wish to continue your action ?" class='btn btn-danger btn-sm data-confirm'><i class='fas fa-trash'></i></button>
                                </td>
                            </tr>
                        @endforeach
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
        $('#program_fee_overview').DataTable();

    </script>
@endpush
