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
                <form id="absent_filter" method="post" action="{{ route('users.sadhak.admin_absent_filter_record_view') }}">
                    @csrf
                    <h4>Filter Record</h4>
                    <div class='row'>
                        <div class='col-md-6'>
                            <label class='label-control'>Event</label>
                            <select name="event" class='form-control'>
                                @foreach ($sibir_records as $record)
                                    <option value='{{ $record->id }}'> {{ $record->sibir_title }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-6'>
                            <label class='label-control'>Filter</label>
                            <select name="filter" class='form-control'>
                                <option value='3'>All Record</option>
                                <option value='1'>Approved</option>
                                <option value="0" selected>Pending</option>
                                <option value='2'>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class='col-md-12 mt-2'>
                            <button type="submit" id="filter_attendance" class='btn btn-primary btn-block'>
                                <i class='fas fa-filter'></i> Filter Record
                            </button>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive" id='user_list'>
                            <p>Filter the Record to Display data.</p>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section("page_js")
    <script type="text/javascript">
        $('form#absent_filter').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type : $(this).attr('method'),
                url : $(this).attr('action'),
                data : $(this).serializeArray(),
                success: function (response) {
                    $("#user_list").html(response);
                }
            })
        })
    </script>
@endsection