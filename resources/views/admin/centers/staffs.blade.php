@extends('layouts.admin.master')
@push('page_title')Center Staffs @endpush

@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{route('admin.centers.list')}}">Centers</a> / {{$center->center_name}} /</span> Staff List
            </h4>
            <div>
                <button type="button"
                data-bs-toggle="modal"
                data-bs-target="#userList"
                 data-action="{{route('admin.modal.display',['view' => 'users.list','center' => $center->getKey()])}}" class="btn btn-primary ajax-modal">
                    <i class="fas fa-plus me-1"></i> Add Existing Staffs
                </button>
                
                <a href="{{route('admin.users.create',['center' => $center])}}" class=" mx-1 btn btn-primary btn-icon">
                    <i class="fas fa-plus"></i>
                </a>

                <a href="{{route('admin.centers.list')}}" class="btn btn-danger btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Staff for {{$center->center_name}} </h5>
        </div>

        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="StaffListTable">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Tagline</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($staffs as $staff)
                        <tr>
                            <td>
                                <a href="{{route('admin.users.edit',['user' => $staff,'center' => $center])}}">
                                    {{$staff->full_name()}}
                                </a>
                            </td>
                            <td>{{$staff->email}}</td>
                            <td>{{$staff->tagline}}</td>
                            <td>
                                @if($staff->active)    
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('admin.users.edit',['user' => $staff,'center' => $center])}}" class="btn btn-primary btn-icon">
                                    <i class="fas fa-pencil"></i>
                                </a>

                                <button 
                                    data-method="post"
                                    data-action="{{route('admin.users.delete',['user' => $staff,'center' => $center])}}"
                                    data-confirm="All User Associated with this staff will be dismissed. You may need to re-assign their for login permission." class="btn btn-danger data-confirm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-modal modal="userList"></x-modal>
@endsection

@push('page_script')
    <script>
        $('#StaffListTable').DataTable();
    </script>
@endpush
