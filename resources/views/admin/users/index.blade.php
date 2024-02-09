@extends('layouts.admin.master')
@push('page_title')Staff List @endpush

@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Users /</span> Staff
            </h4>
            <a href="{{route('admin.users.create')}}" class="btn btn-primary btn-icon">
                <i class="fas fa-plus"></i>
            </a>
        
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">All Staffs </h5>
        </div>

        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="program-table">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Tagline</th>
                    <th>Email</th>
                    <th>Super Admin</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->full_name()}}</td>
                            <td>{{$user->tagline}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <span class="badge bg-label-success">Yes</span>
                                @else
                                    <span class="badge bg-label-danger">No</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
