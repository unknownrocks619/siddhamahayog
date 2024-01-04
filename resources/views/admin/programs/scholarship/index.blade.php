@extends('layouts.admin.master')
@push('page_title') Program  > Special Access & Permission @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Programs / </span> Special Access & Permission
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between">
            <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            <a data-bs-target="#quickUserView" data-bs-toggle="modal" href="{{route('admin.program.admin_program_list')}}" class="btn btn-primary btn-icon">
                <i class="fas fa-plus"></i>
            </a>
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
                    <th>Scholarship Type</th>
                    <th>Phone Number</th>
                    <th>Email Address</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
                </thead>
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->students?->full_name }} </td>
                        <td>
                            @if(isset(\App\Models\Scholarship::TYPES[$student->scholar_type]) )
                                {{\App\Models\Scholarship::TYPES[$student->scholar_type]}}

                            @else
                                <span class="badge bg-label-danger">Not Defined</span>
                            @endif
                        </td>
                        <td>{{ $student->students?->phone_number }}</td>
                        <td>{{ $student->students?->email }}</td>
                        <td>{{ $student->remarks }}</td>
                        <td>
                            <button
                                data-method="POST"
                                data-action="{{ route('admin.program.scholarship.remove',[$program->getKey(),$student->students->getKey()]) }}"
                                type="button"
                                class="btn btn-danger data-confirm btn-icon"
                                data-confirm="You are about to remove selected student from scholarship list. This action cannot be undone. Are you sure ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="quickUserView" data-dropdown="quickUserView">
        @include('admin.modal.programs.scholarship.create',['members' => $enrolledStudent,'program' => $program])
    </x-modal>
@endsection

@push('page_script')
    <script>
        $('#program-table').DataTable();
    </script>
@endpush
