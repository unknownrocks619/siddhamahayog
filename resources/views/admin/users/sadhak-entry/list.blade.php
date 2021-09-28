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
                    <h4 class="card-title">Sadhak Registrations</h4>
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
                                <th>Selected Center</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $users as $user )
                                    <tr @if($user->user_preferences->pending) class='bg-warning text-white'  @elseif($user->user_preferences->confirmed) class='bg-info text-white' @elseif($user->user_preferences->completed) class='bg-success text-white' @else class='bg-danger text-white' @endif>
                                        <td>
                                            <a href="{{ route('users.view-user-detail',$user->userDetail->id) }}" class='text-primary'>
                                            {{ $user->userDetail->full_name() }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ address($user->userDetail->address()) }}
                                        </td>
                                        <td>
                                            {{ $user->userDetail->phone_number }}

                                        </td>
                                        <td>
                                            Profession : {{ $user->userDetail->profession }}
                                        </td>

                                        <td>
                                            {{ $user->branch->name }}
                                        </td>
                                        <td>
                                            @if( $user->user_preferences->pending)
                                                <a class='btn btn-primary' href='{{ route("users.sadhak.admin-sadhak-detail",[$user->id]) }}'>
                                                View 
                                                </a>

                                                <!-- <a href='#' class='btn btn-success mt-1'>
                                                Approve
                                                </a> -->
                                            @endif

                                            @if( $user->user_preferences->confired)
                                                
                                                Cancel
                                                Completed
                                            @endif

                                            @if ( $user->user_preferences->cancelled)
                                                Reimbursed
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No Registration</td>
                                    </tr>
                                @endforelse
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