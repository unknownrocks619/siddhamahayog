@extends('layouts.admin')

@section('page_css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <!-- END: Vendor CSS-->
    <style type="text/css">
        #overlay {
        background: #ffffff;
        color: #666666;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 10%;
        opacity: .80;
        }
        
        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endSection()

@section('content')
<div id="overlay" style="display:none;">
        <div class="spinner"></div>
        <br/>
            <h4 id="loading_text">Please wait... Verifying Information...</h4>
    </div>
<section id="headers">
    <div class="row">
        <div class='card card-body'>
            <h4>Filter Record</h4>
            <div class='row'>
                <div class='col-md-2'>
                    <label class='label-control'>Event</label>
                    <input type="text" readonly value="{{$sibir->sibir_title}}" class='form-control' />
                </div>
                <div class='col-md-4'>
                    <label class='label-control'>From Date</label>
                    <input type="date" class='form-control' name='from_date' />
                </div>
                <div class='col-md-4'>
                    <label class='label-control'>To Date</label>
                    <input type="date" class='form-control' name='to_date' />
                </div>
                <div class='col-md-2'>
                    <label class='label-control'>Record Per Page</label>
                    <select name='record_per_page' class='form-control'>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="350">350</option>
                        <option value="500">500</option>
                        <option value="500">700</option>

                    </select>
                </div>
                <div class='col-md-12 mt-2'>
                    <button type="button" id="filter_attendance" class='btn btn-primary btn-sm btn-block'>
                        <i class='fas fa-filter'></i> Filter Record
                    </button>
                </div>
                
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User List</h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive" id='user_list'>
                        
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
        <script>
            $("#filter_attendance").click( function () {
                let from_date = $("input[name='from_date']").val()
                let to_end = $("input[name='to_date']").val();
                let record_per_page = $("select[name='record_per_page']").val();
                $.ajax({
                    type : "GET",
                    url : "{{ route('users.sadhak.admin_sadhak_attendance_view',[$sibir->id]) }}",
                    data : "from_date="+from_date+"&end_date="+to_end+"&record_per_page="+record_per_page,
                    success : function (response) {
                        $("#user_list").html(response);
                    }
                })
            })
        </script>
        <script>
            $(document).ajaxStart(function() {
                $("#overlay").fadeIn(function() {
                    $("#loading_text").html("Please wait... Processing request ");
                });
            });

            $(document).ajaxStop( function() {
                $("#overlay").fadeOut();
            });
        </script>
@endSection()