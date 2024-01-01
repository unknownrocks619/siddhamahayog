@extends('layouts.admin.master')
@push('page_title') Program  > Special Access & Permission @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Programs / </span> Guest List
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

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Scholarship & Permission Management List</h5>

        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="program-table">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Access Code</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($guestLists as $list)
                    <tr>
                        <td>
                            {{ $list->first_name }} {{ $list->last_name }}
                        </td>
                        <td class="bg-primary text-white">
                            <span class="access_code">{{ $list->access_code }}</span>
                        </td>
                        <td>
                            @if(! $list->liveProgram || ! $list->liveProgram->live)
                                <span class="badge bg-label-warning">
                                            Not Available
                                        </span>
                            @elseif ($list->used)
                                <span class="badge bg-label-danger">
                                    Used
                                </span>
                            @else
                                <span class="badge bg-label-success">
                                    Not Used
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($list->used)
                                    <?php
                                    $detail = (array) $list->access_detail;
                                    ?>
                                IP: {{ $detail[0]->ip }}
                                <br />
                                Browser : {{ $detail[0]->browser }}
                            @else
                                Not Used
                            @endif
                        </td>
                        <td>
                            <button data-action="{{ route('admin.program.guest.delete',[$program->getKey(),$list->getKey()]) }}" data-method="post" type="button" data-confirm="You are about to remove guest access list. It will not impact the guest who is already in class room. This action cannot be undone." class="btn btn-danger btn-sm data-confirm btn-icon" >
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
    <x-modal modal="quickUserView">
    </x-modal>
@endsection

@push('page_script')
    <script>
        $('#program-table').DataTable();
    </script>
@endpush
