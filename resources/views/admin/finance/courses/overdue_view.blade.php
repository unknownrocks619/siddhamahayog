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

                    <div class='card-body'>
                        <div class='row bg-light p-1'>
                            <div class='col-md-12'>
                                <h4>Filter Result</h4>
                                <form>
                                    @csrf
                                    <div class='row form-group'>
                                        <div class='col-md-4'>
                                            <label class='label-control'>Course</label>
                                            <select name="courses" class="form-control">
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class='col-md-4'>
                                            <label class='label-control'>
                                                Login ID / Email
                                            </label>
                                            <input type="text" class='form-control' placeholder="Login ID / Email" name="sadhak" />
                                        </div>

                                        <div class='col-md-4'>
                                            <label class='label-control'>
                                                Record Type
                                            </label>
                                            <select name="record_type" class="form-control">
                                                <option value="1">Admission</option>
                                                <option value="0" selected>Monthly</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class='row form-group'>
                                        <div class='col-md-6'>
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

                                        <div class='col-md-6'>
                                            <label class='label-control'>
                                                Month
                                            </label>
                                            <select name="month" class='form-control'>
                                                <option value="01" @if(date("m") == "01") selected @endif>JAN</option>
                                                <option value="02" @if(date("m") == "02") selected @endif>FEB</option>
                                                <option value="03" @if(date("m") == "03") selected @endif>MAR</option>
                                                <option value="04" @if(date("m") == "04") selected @endif>APR</option>
                                                <option value="05" @if(date("m") == "05") selected @endif>MAY</option>
                                                <option value="06" @if(date("m") == "06") selected @endif>JUN</option>
                                                <option value="07" @if(date("m") == "07") selected @endif>JUL</option>
                                                <option value="08" @if(date("m") == "08") selected @endif>AUG</option>
                                                <option value="09" @if(date("m") == "09") selected @endif>SEP</option>
                                                <option value="10" @if(date("m") == "10") selected @endif>OCT</option>
                                                <option value="11" @if(date("m") == "11") selected @endif>NOV</option>
                                                <option value="12" @if(date("m") == "12") selected @endif>DEC</option>
                                            </select>
                                        </div>                                       
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <button type="submit" class='btn btn-primary'>View Overdue Record.</button>
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
                type : "POST",
                data : $(this).serialize(),
                url : "{{ route('courses.admin_payment_overdue_report') }}",
                
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