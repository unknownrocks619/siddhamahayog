@extends('layouts.admin.master')
@push('page_title')
    All Members
@endpush
@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href='{{ route('admin.members.all') }}'>Members</a>/Teachers/</span> All
            </h4>
            <div>
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary me-2"><i class="fas fa-plus"></i> Create
                    New Member</a>
                <a href="{{ route('admin.members.quick-add') }}" data-bs-target="#quickAdd" data-bs-toggle="modal"
                    class="btn btn-primary "><i class="fas fa-plus"></i> Quick New Registration</a>

            </div>
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Teacher List</h5>
        <div class="card-datatable table-responsive">
            @if (
                !in_array(adminUser()->role(), [
                    App\Classes\Helpers\Roles\Rule::SUPER_ADMIN,
                    App\Classes\Helpers\Roles\Rule::ADMIN,
                    App\Classes\Helpers\Roles\Rule::CENTER,
                    App\Classes\Helpers\Roles\Rule::CENTER_ADMIN,
                ]))
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-secondary">
                                You do not have permission to view this page.
                            </h5>
                        </div>
                    </div>
                </div>
            @else
                <table class="dt-responsive table" id="teachers-table">
                    <thead>
                        <tr>
                            <th>Full name</th>
                            <th>Phone</th>
                            <th>Training Date</th>
                            <th>Total Session</th>
                            <th>Total Student</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach (\App\Models\Member::where('role_id', \App\Models\Role::TEACHER)->get() as $member)
                            <tr>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->phone_number }}</td>
                                <td>{{ $member->training_date }}</td>
                                <td>{{ $member->total_session }}</td>
                                <td>{{ $member->total_student }}</td>
                                <td>
                                    <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-info"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Full name</th>
                            <th>Phone</th>
                            <th>Training Date</th>
                            <th>Total Session</th>
                            <th>Total Student</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>
@endsection
