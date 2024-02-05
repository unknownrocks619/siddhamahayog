@php
    $dharmasala = request()->dharmasala ? true  : false;
    $program = false;
    $formAction = route('admin.members.create');
    if ($dharmasala) {
        $formAction = route('admin.members.create',['dharmasala' => true]);
    }
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
                <form action="{{$formAction}}" method="post" class="ajax-component-form ajax-append member-registration">
                    <div class="card">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mx-auto">
                                        <!-- 1. Delivery Address -->
                                        <h4 class="mb-4 text-danger">1. Email / Phone Number Verification</h4>
                                        <div class="row g-3 m-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fs-4" for="first_name">Email Address / Phone Number</label>
                                                    <input type="text" id="search_field" name="search_field" class="form-control fs-4" placeholder="Email / Phone Number">
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end">
                                                <button class="btn btn-primary"  onclick="window.memberRegistration.newRegistration({dharmasala:'{{$dharmasala}}'})" type="button">
                                                    New Registration
                                                    <i class="fas fa-users ms-2"></i>
                                                </button>
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
