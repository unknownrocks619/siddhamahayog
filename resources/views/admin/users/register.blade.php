@extends('layouts.admin')

@section('page_css')
 <!-- BEGIN: Page CSS-->
 <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/widgets.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/pages/dashboard-analytics.min.css') }}">
    <!-- END: Page CSS-->
@endSection()

@section('content')
<section class="users-edit">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab"
                        href="#account" aria-controls="account" role="tab" aria-selected="true">
                        <i class="bx bx-info-circle mr-25"></i>
                        <span class="d-none d-sm-block">Personal Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center disabled" data-toggle="tab"
                         aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">User Verification</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center disabled" 
                     aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center disabled" 
                     aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Sewa</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <!-- users edit account form start -->
                    <form method="POST" action="{{ route('users.submit_registration') }}" class="form-validate">
                        @csrf
                        <input type='hidden' name='source' value='admin' />
                        <div class="row bg-warning">
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            First Name
                                            <span class='required text-danger'>*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="First Name *"
                                            value="{{ old('first_name') }}"
                                            name="first_name" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Middle Name
                                        </label>
                                        <input type="text" class="form-control" placeholder="Middle Name"
                                            value="{{ old('middle_name') }}"
                                            name="middle_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Last Name
                                            <span class='required text-danger'>*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Last Name *"
                                            value="{{ old('last_name') }}"
                                            name="last_name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row bg-warning">
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Gender
                                        <span class='text-danger required'>*</span>
                                    </label>
                                    <select class="form-control" name='gender'>
                                        <option value="Male" @if( old("gender") == "Male") selected @endif >Male</option>
                                        <option value="Female"  @if( old("gender") == "Female") selected @endif>Female</option>
                                        <option value="Other"  @if( old("gender") == "Other") selected @endif>Other</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Date of Birth
                                        <span class='text-danger required'>*</span>
                                    </label>
                                    <input required type="text" name='date_of_birth_nepali' value="{{ old('date_of_birth_nep') }}" class='form-control' placeholder='YYYY-MM-DD' />
                                </div>
                            </div>
                            <div class="col-2 col-sm-2">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Is Date of Birth In Nepali ?
                                    </label>
                                    <input class="checkbox-input" type="checkbox" @if( old('dob_eng') ) checked @endif name='dob_eng' value='1' id='date_of_birth_option' />
                                    
                                </div>
                            </div>          
                        </div>

                        <div class='row mt-2'>
                            <div class='col-6 col-sm-6'>
                                <div class="form-group">
                                    <label class='control-label'>
                                        Phone Number
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <input required type='text' name='phone_number' class='form-control' value="{{ old('phone_number') }}" />                                    
                                </div>
                            </div>
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <label class='control-label'>
                                        User Category
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <select class="form-control" name='user_type'>
                                       @foreach($user_types as $user_type)
                                        <option value='{{ $user_type->user_type }}' 
                                            @if(old('user_type') == $user_type->user_type)
                                                selected
                                            @endif
                                        >
                                            {{ $user_type->user_type }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-6 col-sm-6'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        Country
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <input name="country" type='text' required class='form-control' value="{{ old('country') }}" />
                                </div>
                            </div>
                            <div class='col-6 col-sm-6'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        City
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <input type='text' name='city' class='form-control' value="{{ old('city') }}" />
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-6 col-sm-6'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        Education Qualification
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <input type='text' name='education_level' class='form-control' value="" />
                                </div>
                            </div>
                            <div class='col-6 col-sm-6'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        Profession
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <input type='text' name='profession' required class='form-control' value="{{ old('profession') }}" />
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-6 col-sm-6'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        Maritial Status
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <select name='marritial_status' class="form-control">
                                        <option value="Married" @if(old('marital_status') == "Married") selected @endif>Married</option>
                                        <option value="Unmarried" @if(old('marital_status') == "Unmarried") selected @endif>Unmarried</option>
                                        <option value='Other' @if(old('marital_status') == 'Other') selected @endif>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-6 col-sm-6'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        Spouse / Husband Name
                                    </label>
                                    <input type='text' class='form-control' name='married_to_id' value="{{ old('married_to_id') }}" />
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-6 col-sm-6'>

                                <div class="form-group">
                                    <div class="controls">
                                        <label>E-mail</label>
                                        <input type="email" class="form-control" placeholder="Email"
                                            value="{{ old('email') }}"
                                            name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name='user_role'>
                                        <option value="visitors" @if(old('roles')) selected @endif>Visitors</option>
                                        <option value='volunteers' @if(old('roles') == 'volunteers') selected @endif>Volunteer</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                <button type="submit" class="btn btn-success glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save & Continue</button>
                                <button type="reset" class="btn btn-light">Cancel</button>
                            </div>
                        </div>

                    </form>
                    <!-- users edit account form ends -->
                </div>
            </div>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
<!-- <script src="{{ asset ('admin/app-assets/js/scripts/pages/dashboard-analytics.min.js') }}"></script> -->
@endSection()