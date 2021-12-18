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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered complex-headers" id="user_table">
                            <thead>
              
                                <tr class=''>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($participants as $participant)
                                    @if($participant->userDetail)
                                    <tr>
                                        <td>
                                            {{ $participant->userDetail->full_name()}};
                                            {{ $participant->userDetail->id }}
                                        </td>
                                        <td>
                                            @if($participant->userDetail)
                                                {{ $participant->userDetail->phone_number }}
                                            @else
                                                "No detail";
                                            @endif
                                        </td>
                                        <td>
                                            @if($participant->userDetail->userlogin)
                                                {{ $participant->userDetail->userlogin->email }}
                                            @else 
                                                "No Detail";
                                            @endif
                                        </td>
                                        <td>
                                            @if((int) $participant->userDetail->country && (int) $participant->userDetail->city)
                                                {{ address([$participant->userDetail->country,$participant->userDetail->city]) }};
                                            @else
                                                {{ $participant->userDetail->country }}
                                            @endif
                                        </td>
                                    </tr>
                                    @else
                                        <tr>
                                            <td>No Name {{ $participant->id }}</td>
                                            <td>no_data</td>
                                            <td>no_data</td>
                                            <td>no_data</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                     
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
                $("#user_table").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]

                });
            });
        </script>
@endSection()