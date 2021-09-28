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
                    <div class="card-header">
                        <h4 class="card-title">
                            Report for '{{ $sibir->sibir_title }}'
                        </h4>
                    </div>
                    <div class='card-body'>

                        <p class="card-text text-right">
                            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                            <a href="{{ route('users.sadhak.list') }}" class='btn btn-info'>
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
                                        <h3 class="greeting-text">Total Sadhak</h3>
                                        <p class="mb-0">Total Signup for {{ $sibir->sibir_title }}</p>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                            <h1 class="text-primary font-large-2 text-bold-500">
                                                <a href="{{ route('users.sadhak.admin_user_view_sibir_participants',['sibir'=>$sibir->id]) }}">
                                                    {{ $sibir->total_registrations->count() }}
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
                                    <h3 class="greeting-text">Total Male</h3>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                                <h1 class="text-primary font-large-2 text-bold-500">
                                                    @php
                                                        echo ($sibir->total_registration && $sibir->total_registration->userDetail) ? $sibir->total_registration->userDetail->male()->count() : 0

                                                        // $user_id = ($sibir->total_registration) ? $sibir->total_registration->user_detail_id : 0;
                                                        // if ($user_id){
                                                        //    $user_detail = \App\Models\userDetail::find($user_detail);

                                                        //    echo ($user_detail->male()) ? $user_detail->male()->count() : 0;
                                                        // } else{
                                                        //    echo 0;
                                                        // }
                                                    @endphp
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                    <h3 class="greeting-text">Total Female</h3>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                                <h1 class="text-primary font-large-2 text-bold-500">
                                                    @php
                                                        echo ($sibir->total_registration && $sibir->total_registration->userDetail) ? $sibir->total_registration->userDetail->female()->count() : 0
                                                        // $user_id = ($sibir->total_registration) ? $sibir->total_registration->user_detail_id : 0;
                                                        // if ($user_id){
                                                        //    $user_detail = \App\Models\userDetail::find($user_detail);
                                                        //    echo ($user_detail->female()) ? $user_detail->male()->count() : 0;
                                                        // } else{
                                                        //    echo 0;
                                                        // }
                                                    @endphp
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                    <h3 class="greeting-text">People with Mental Health Problem</h3>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                            <h1 class="text-primary font-large-2 text-bold-500">
                                            @php
                                                echo ($sibir->total_registration && $sibir->total_registration->userDetail) ? $sibir->total_registration->userDetail->male()->count() : 0; 
                                                // $user_id = ($sibir->total_registration) ? $sibir->total_registration->user_detail_id : 0;
                                                // if ($user_id){
                                                //    $user_detail = \App\Models\userDetail::find($user_detail);

                                                //    echo ($user_detail->male()) ? $user_detail->male()->count() : 0;
                                                // } else{
                                                //    echo 0;
                                                // }
                                            @endphp
                                            </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                    <h3 class="greeting-text">People with health problem</h3>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                                <h1 class="text-primary font-large-2 text-bold-500">
                                                    @php
                                                    echo ($sibir->total_registration && $sibir->total_registration->userDetail) ? $sibir->total_registration->userDetail->female()->count() : 0
                                                    @endphp
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="greeting-text">Event Attendance</h3>
                                        <p class="mb-0">View {{ $sibir->sibir_title }} user status</p>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="dashboard-content-left">
                                            <h1 class="text-primary font-large-2 text-bold-500">
                                                <a href="{{ route('users.sadhak.admin_sadhak_attendance_view',['sibir'=>$sibir->id]) }}">
                                                    View
                                                </a>
                                            </h1>
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
                                <table class='table table-bordered table-hover'>
                                    <thead>
                                        <tr>
                                            <th>Center Name</th>
                                            <th>Total Registration</th>
                                            <th>Total Male </th>
                                            <th>Total Female</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sibir->branches as $branch_record)
                                            @php
                                                $model = new \App\Models\UserSadhakRegistration;
                                                $total_registration = $model::where('branch_id',$branch_record->branch_id)
                                                                        ->where('sibir_record_id',$sibir->id)
                                                                        ->get();
                                                $total_male = 0;
                                                $total_female = 0;
                                                foreach ($total_registration as $user_record) {
                                                    if ($user_record->gender == "male") {
                                                        $total_male ++;
                                                    } else if ($user_record->gender == "female") {
                                                        $total_female ++;
                                                    }
                                                }
                                                
                                            @endphp
                                            <tr>
                                                <td>{{ $branch_record->branch->name }}</td>
                                                <td>
                                                    {{ $total_registration->count() }}
                                                </td>
                                                <td>
                                                    {{ $total_male }}
                                                </td>
                                                <td>
                                                    {{ $total_female }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col-md-12'>
                                @if($sibir->active)
                                    <form method="post" action=" {{ route('users.sadhak.update_sibir_status',$sibir->id) }} ">
                                        @csrf
                                        <button type='submit' class='btn btn-block btn-danger'>Close Application Report</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
@endSection()
@section("page_js")
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset ('admin/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{-- asset('admin/app-assets/vendors/js/extensions/dragula.min.js') --}}"></script>
    <script src="{{ asset ('admin/app-assets/js/scripts/customizer.min.js') }}"></script>

    <!-- END: Page Vendor JS-->
    <script src="{{ asset ('admin/app-assets/js/scripts/pages/dashboard-analytics.min.js') }}"></script>

@endsection