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
                    <a class="nav-link d-flex align-items-center" id="account-tab" data-toggle="tab"
                        href="#account" aria-controls="account" role="tab" aria-selected="true">
                        <i class="bx bx-info-circle mr-25"></i>
                        <span class="d-none d-sm-block">Personal Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="account-tab" data-toggle="tab"
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
                    <form enctype="multipart/form-data" method="post" class="form-validate" action="{{ route('users.submit_user_verification',['user_id'=>encrypt($user_detail->id)]) }}">
                        @csrf
                        <div class="row bg-warning">
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            First Name
                                            <span class='required text-danger'>*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="First Name *"
                                            value="{{ $user_detail->first_name }}" disabled
                                           >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Last Name
                                            <span class='required text-danger'>*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Last Name *"
                                            value="{{ $user_detail->last_name }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-warning">
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Pet Name
                                    </label>
                                    <input type='text' class='form-control' name='pet_name' value="{{ old('pet_name') }}" />
                                </div>
                            </div>    
                        </div>
                        <div class='row mt-2'>
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Document Type
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <select class="form-control" name='document_type'>
                                        <option value="Citizenship" @if(old('document_type') == "Citizenship") selected @endif>Citizenship</option>
                                        <option value='Passport' @if(old('document_type') == "Password") selected @endif>Passport</option>
                                        <option value='Driving' @if(old('document_type') == "Driving") selected @endif>Driving License</option>
                                        <option value='PAN CARD' @if(old('document_type') == "PAN CARD") selected @endif>PAN Card</option>
                                        <option value='ID' @if(old('document_type') == "ID") selected @endif>ID Card</option>
                                        <option value='Other' @if(old('document_type') == "Other") selected @endif>Other</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-6 col-sm-6">
                                <div class="form-group"><br />
                                    <div class="custom-file">
                                    <label class='custom-file-label'>
                                        Select File
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <input type='file' name='document_file' class='custom-file-input' />
                                    

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Gaurdian / Parent Name
                                    </label>
                                    <input type='text' name='gaurdian_name' value="{{ old('gaurdian_name') }}" class='form-control' />
                                </div>
                            </div>

                            <div class="col-6 col-sm-6">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Gaurdian / Parent Phone Number
                                    </label>
                                    <input type='text' name='gaurdian_phone' value="{{ old('gaurdian_phone') }}" class='form-control' />
                                    
                                </div>
                            </div>
                        </div>
                        <h5 class='text-center'>OR</h5>
                        <div class='row mt-2'>
                            <div class='col-12'>
                                <div class='form-group'>
                                    <label class='control-label'>
                                        Search Gaurdian In Our Database
                                    </label>
                                    <input type='text' value="{{ old('gaurdian_search') }}" placeholder="Search By Name, Email or Phone Number" name='gaurdian_search' class='form-control' />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save & Continue</button>
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