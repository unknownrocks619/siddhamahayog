@php
    $dharmasala = request()->dharmasala ? true  : false;
    $program = false;
    $formAction = route('admin.members.create');
    if ($dharmasala) {
        $formAction = route('admin.members.create',['dharmasala' => true]);
    }

@endphp
@extends('layouts.admin.master')
@push('page_title') Account Verification @endpush

@section('main')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-3">
                @if($source == 'registration')
                    <a href="{{route('admin.members.create',['member' => $member->getKey()])}}" class="btn btn-danger btn-icon">
                        <i class="fas fa-arrow-left"></i></a>

                @elseif ($source == 'profile')
                    <a href="{{route('admin.members.show',['member' => $member])}}" class="btn btn-danger btn-icon">
                        <i class="fas fa-arrow-left"></i></a>
                @else
                    <a href="{{route('admin.members.all')}}" class="btn btn-danger btn-icon">
                        <i class="fas fa-arrow-left"></i></a>
                @endif
            </div>
        </div>

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="{{route('admin.members.all')}}">Member</a> /</span>
            <a href="{{route('admin.members.create')}}">Create New Member</a>
        </h4>
        <!-- Sticky Actions -->
        <div class="row">
            <div class="col-12">
                <form action="{{$formAction}}" method="post" class="ajax-component-form ajax-append member-registration">
                    <div class="card step_one_search_option" @if($member) style="display:none" @endif>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mx-auto">
                                    <h4 class="mb-4 text-danger"><a href="#" onclick="window.memberRegistration.newRegistration({dharmasala:'{{$dharmasala}}'});return false" class="text-danger">1. New Registration</a></h4>
                                    <div class="row g-3 m-3">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary"  onclick="window.memberRegistration.newRegistration({dharmasala:'{{$dharmasala}}'})" type="button">
                                                New Registration
                                                <i class="fas fa-users ms-2"></i>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mx-auto">
                                    <!-- 1. Delivery Address -->
                                    <h4 class="mb-4 text-danger">2. Search Registered User</h4>
                                    <div class="row g-3 m-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fs-4" for="first_name">Email Address / Phone Number</label>
                                                <input type="text" id="search_field" name="search_field" class="form-control fs-4" placeholder="Email / Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-end">
                                            <button class="btn btn-primary"  onclick="window.memberRegistration.verifyEmail({dharmasala:'{{$dharmasala}}'})" type="button">
                                                Check Detail
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="postVerificationPage">
                        @if($member)
                            @include('admin.members.partials.new-registration',['member' => $member])
                        @endif
                    </div>

                </form>
            </div>
        </div>
        <!-- /Sticky Actions -->
    </div>

@endsection
@push('vendor_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
@endpush
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
