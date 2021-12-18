@extends('layouts.admin')

@section('page_css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <!-- END: Vendor CSS-->

@endSection()

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User List</h4>
                </div>
                <div class="card-body card-dashboard">
                    <p class="card-text text-right">
                        <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                        <a href="{{ route('users.new_user_registration') }}" class='btn btn-info'>
                            <i class='fas fa-plus'></i>
                            Add New User
                        </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered complex-headers" id="user_table">
                            <thead>
                                <tr>
                                <th colspan="3" class="text-center bg-dark text-white">Personal Information</th>
                                <th colspan="2" class='text-center  bg-dark text-white'>Other Information</th>
                                <th rowspan="2" class='bg-success'>Action</th>
                                </tr>
                                <tr class=''>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Profession</th>
                                <th>Skills</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ( $users as $user)
                                <tr @if( ! $user->userverification || ! $user->userverification->parent_name || ! $user->userverification->parent_phone || !$user->userverification->verification_type || ! $user->userverification->document_file_detail ) class='text-danger' @endif>
                                    <td>
                                        
                                        <a href="{{ route('users.view-user-detail',$user->id) }}">
                                            {{ $user->full_name() }}
                                        </a>
                                        @if($user->user_role == "visitor" || $user->user_role == null)
                                            <br />
                                            <span class='badge badge-primary'>Visitor</span>
                                        @endif
                                        @if ($user->user_room_allotment)
                                            <br />
                                            <span class='badge badge-danger'>Priority</span>
                                        @endif
                                    </td>
                                    <td> {{-- $user->address() --}} {{ ((int)$user->country && $user->country_name) ? $user->country_name->name : $user->country}}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ ucwords($user->gender) }}</td>
                                    <td>{{ ucwords($user->profession) }}</td>
                                    <td>
                                        <a href="{{ route('users.edit_user_detail',$user->id) }}">
                                        Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Profession</th>
                                <th>Skills</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
        <!-- END: Page Vendor JS-->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#user_table").DataTable();
            });
        </script>
@endSection()