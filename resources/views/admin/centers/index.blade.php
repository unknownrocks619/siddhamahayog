@extends('layouts.admin.master')
@push('page_title')Center List @endpush

@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Centers /</span> List
            </h4>
            <a href="{{route('admin.centers.create')}}" class="btn btn-primary btn-icon">
                <i class="fas fa-plus"></i>
            </a>
        
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">All Centers </h5>
        </div>

        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="centersListTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Total Staffs</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($centers as $center)
                        <tr>
                            <td>
                                <a href="{{route('admin.centers.list',['center' => $center])}}">
                                    {{$center->center_name}}
                                </a>
                            </td>
                            <td>{{$center->center_location}}</td>
                            <td>{{$center->center_email_address}}</td>
                            <td>
                                @if($center->active)    
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                <span class="badge bg-label-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{$center->staffs_count}}
                            </td>
                            <td>
                                <a href="{{route('admin.centers.edit',['center' => $center])}}" class="btn btn-primary btn-icon">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button 
                                    data-method="post"
                                    data-action="{{route('admin.centers.delete',['center' => $center])}}"
                                    data-confirm="All User Associated with this center will be dismissed. You may need to re-assign their for login permission." class="btn btn-danger data-confirm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        $('#centersListTable').DataTable();
    </script>
@endpush
