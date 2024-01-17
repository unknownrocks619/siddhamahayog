@php
    $dharmasala = request()->dharmasala ? true  : false;
    $program = false;
@endphp

@extends('layouts.admin.master')
@push('page_title') Register New Member @endpush
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Member/</span>
            Create New Member
        </h4>
        <!-- Sticky Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div id="sticky-wrapper" class="sticky-wrapper" style="height: 86.0625px;">
                        <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row" style="width: 1392px;">
                            <h5 class="card-title mb-sm-0 me-2">Action Bar</h5>
                            <div class="action-btns">
                                <button class="btn btn-label-primary me-3 waves-effect">
                                    <span class="align-middle"> Back</span>
                                </button>
                                <button class="btn btn-primary waves-effect waves-light">
                                    Create new Member
                                </button>
                            </div>
                    </div>
                </div>
                    <form action="" method="post" class="ajax-component-form ajax-append">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mx-auto">
                                    <!-- 1. Delivery Address -->
                                    <h5 class="mb-4">1. Personal Info</h5>

                                    <div class="row g-3 m-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="first_name">First Name</label>
                                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="middle_name">Middle Name</label>
                                                <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Middle Name">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="last_name">Last Name</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 m-3">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="date_of_birth">Date of Birth</label>
                                                <input type="date" name="date_of_birth" id="date_od_birth" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Gender</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="phone_number">Phone Number</label>
                                                <input type="text" id="phone_number" name="phone_number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea name="address" class="form-control" id="address" rows="2" placeholder="1456, Mall Road"></textarea>
                                        </div>
                                    </div>

                                    <div class="row g-3 m-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <select name="country" id="country" class="form-control">
                                                    @foreach (\App\Models\Country::get() as $country)
                                                        <option value="{{$country->getKey()}}" @if($country->getKey() == 153) selected @endif>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="city">City / State / Province</label>
                                                <input type="text" name="city" id="city" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 m-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="street_address">Street Address</label>
                                                <textarea name="street_address" id="street_address"
                                                          class="form-control textarea"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-3 g-3">
                                        <label class="form-check-label">
                                            Enable Online Login
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <div class="col mt-2">
                                            <div class="form-check form-check-inline">
                                                <input name="enable_login" onchange="window.memberRegistration.enableOnlineLogin(this)" class="form-check-input" type="radio" value="1" id="enable-online-login-yes" checked="">
                                                <label class="form-check-label" for="enable-online-login-yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="enable_login" onchange="window.memberRegistration.enableOnlineLogin(this)" class="form-check-input" type="radio" value="0" id="enable-online-login-yes-no">
                                                <label class="form-check-label" for="enable-online-login-no"> No </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-3 g-3" id="passwordFields">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">
                                                    Password
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <input type="password" name="password" id="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                Confirm Password
                                                <sup class="text-danger">*</sup>
                                            </div>
                                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" />
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                                            <label class="form-check-label me-1">Email Password : </label>
                                            <div class="form-check form-check-inline">
                                                <input name="email_user" onchange="window.memberRegistration.enableOnlineLogin(this)" class="form-check-input" type="radio" value="1" id="email-password-yes" checked="">
                                                <label class="form-check-label" for="email-password-yes"> Yes </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="email_user" onchange="window.memberRegistration.enableOnlineLogin(this)" class="form-check-input" type="radio" value="0" id="email-password-no">
                                                <label class="form-check-label" for="email-password-no"> No </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    @if($dharmasala == true)

                                        <div class="row border-bottom d-none clone-family-detail">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="full_name">Full Name <sup class="text-danger">*</sup></label>
                                                    <input type="text" data-name="connectorFullName[]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="relation">Relation <sup class="text-danger">*</sup></label>
                                                    <input type="text" data-name="relation[]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="phone_number">Phone Number</label>
                                                    <input type="text" data-name="relationPhoneNumber[]"
                                                           class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="border">
                                                        <video width="640" height="480" autoplay playsinline></video>
                                                    </div>
                                                    Camera
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row gy-3 m-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="room_number" class="mb-4">Room Number</label>
                                                    <div class="my-3">
                                                        <select name="room_number" id="room_number"
                                                                class="form-control">
                                                            @foreach (\App\Models\Dharmasala\DharmasalaBuildingRoom::where('is_available',true)->get() as $room)
                                                                <option value="{{$room->getKey()}}">{{$room->room_number}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row gy-3 m-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_card" class="d-flex justify-content-between align-items-center">
                                                        <span>ID Card</span>
                                                        <span>
                                                            <button class="btn btn-primary btn-icon">
                                                                <i class="fas fa-camera"></i>
                                                            </button>
                                                        </span>
                                                    </label>
                                                    <div class="my-2" id="id_card_upload">
                                                        <input type="file" name="id_card" id="id_card" class="form-control" />
                                                    </div>

                                                    <div class="my-2 d-none" id="id_card_picture">
                                                        <input type="hidden" name="id_card_image" id="id_card" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end d-none" id="idCameraContainer">
                                                <div id="idCameraCapture" class="border" style="min-height: 300px; min-width: 100%"></div>
                                                <h4 class="text-center">ID Card</h4>
                                            </div>
                                        </div>
                                        <hr />
                                        <h5 class="my-4">3. Live Photo</h5>

                                        <div class="row gy-3 m-3">
                                            <div class="col-md-6">
                                                <div id="cameraArea" class="border">
                                                    <video id="webcam" width="640" height="480" autoplay playsinline></video>
                                                </div>
                                                <h4 class="text-center">Webcam Preview</h4>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <button class="btn btn-primary">
                                                    Start Camera
                                                </button>
                                                <button class="btn btn-danger capture-image">
                                                    Capture Image
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cameraCapture" class="border" style="min-height: 300px; min-width: 100%"></div>
                                                <h4 class="text-center">Captured Image</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-2 text-center"></div>
                                            <div class="col-md-4 text-end d-none" id="idCameraContainer">
                                                <div id="idCameraCapture" class="border" style="min-height: 300px; min-width: 100%"></div>
                                                <h4 class="text-center">ID Card</h4>
                                            </div>
                                        </div>
                                        <hr />
                                    <div class="d-flex justify-content between align-items-center">
                                        <h5 class="my-4">
                                            4. Family & Friends
                                        </h5>
                                        <button type="button" class="btn btn-primary btn-icon" onclick="window.memberRegistration.addMoreMembers()"><i class="fas fa-plus"></i></button>
                                    </div>
                                        <div id="familyMembers"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Sticky Actions -->
    </div>

@endsection

@push('page_css')
    <style>
        video {
            display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            height: auto;
        }

        canvas {
            display: block;
            margin: 10px auto;
            border: 1px solid #ccc;
            max-width: 600px;
        }

        button {
            display: block;
            margin: 10px auto;
            padding: 10px;
        }
        #loading-bar {
            display: none;
            background-color: #3490dc;
            height: 4px;
            width: 0%;
            transition: width 1s ease-in-out;
        }
    </style>
@endpush
