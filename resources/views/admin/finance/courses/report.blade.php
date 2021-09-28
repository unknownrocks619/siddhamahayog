@extends('layouts.admin')

@section("page_css")
<link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/pages/dashboard-analytics.min.css') }}">

@endsection

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
                <div class="card">
                    <div class='card-body'>
                        <p class="card-text text-right">
                            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                            <a href="{{-- route('users.sadhak.list') --}}" class='btn btn-info'>
                                <i class='fas fa-plus'></i>
                                Go Back
                            </a>
                        </p>
                    </div>

                    <div class='card-body bg-light'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="greeting-text">Admission Collection</h3>
                                        <p class="mb-0">NRs. {{ number_format($admission_amount,2) }}</p>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                            <h1 class="text-primary font-large-2 text-bold-500">
                                                <a href="{{-- route('users.sadhak.admin_user_view_sibir_participants',['sibir'=>$sibir->id]) --}}">
                                                    {{-- $sibir->total_registrations->count() --}}
                                                </a>
                                            </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                    <h3 class="greeting-text">Scholarship(s)</h3>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                                <p class="mb-0">
                                                    NRs. {{ number_format($scholarship,2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                    <h3 class="greeting-text">Total Fee Collected</h3>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                                <p class='mb-0'>
                                                    NRs.{{ number_format($total_fee,2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <h4>Filter Result</h4>
                                <form>
                                    <div class='row form-group'>
                                        <div class='col-md-2'>
                                            <label class='label-control'>
                                                Year
                                            </label>
                                            <select name="year" class='form-control'>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2022</option>
                                                <option value="2024">2023</option>
                                            </select>
                                        </div>
                                        <div class='col-md-3'>
                                            <label class='label-control'>
                                                Month
                                            </label>
                                            <select name="month" class='form-control'>
                                                <option value="0">Select Month</option>
                                                <option value="01">JAN</option>
                                                <option value="02">FEB</option>
                                                <option value="03">MAR</option>
                                                <option value="04">APR</option>
                                                <option value="05">MAY</option>
                                                <option value="06">JUN</option>
                                                <option value="07">JUL</option>
                                                <option value="08">AUG</option>
                                                <option value="09">SEP</option>
                                                <option value="10">OCT</option>
                                                <option value="11">NOV</option>
                                                <option value="12">DEC</option>
                                            </select>
                                        </div>
                                        <div class='col-md-3'>
                                            <label class='label-control'>
                                                Record Type
                                            </label>
                                            <select name="record_type" class='form-control'>
                                                <option value="all">All</option>
                                                <option value="transaction">Transaction</option>
                                                <option value="overview" selected>Overview</option>
                                            </select>
                                        </div>
                                        <div class='col-md-3'>
                                            <label class='label-control'>
                                                Login ID / Email
                                            </label>
                                            <input type="text" class='form-control' placeholder="Login ID / Email" name="sadhak" />
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-2'>
                                            <button type="submit" class='btn btn-primary'>Filter Record</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class='card-body' id="filter_content"></div>
                </div>
        </div>
    </div>
</section>
@endSection()
@section("page_js")
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{-- asset('admin/app-assets/vendors/js/extensions/dragula.min.js') --}}"></script>
    <script src="{{ asset ('admin/app-assets/js/scripts/customizer.min.js') }}"></script>

    <!-- END: Page Vendor JS-->
    <script type="text/javascript">
        $("form").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type : "GET",
                data : $(this).serialize(),
                url : "{{ route('courses.admin_course_generate_report',[$course->id]) }}",
                success : function (response) {
                    // console.log(response);
                    $("#filter_content").html(response);
                    // if (response.success == true) {
                    //     $("#filter_content").html(response.data);
                    // } else {
                    //     $("#filter_content").html(response.message);
                    // }
                }
            });
        })
    </script>
@endsection