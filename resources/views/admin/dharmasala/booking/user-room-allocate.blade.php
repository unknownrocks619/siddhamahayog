@extends('layouts.admin.master')
@push('page_title') Dharmasala > Booking > Room Confirmation @endpush

@section('main')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light"><a href="">Dharmasal</a>/<a href=""> Booking </a></span>
            Room Confirmation
        </h4>
        <!-- Sticky Actions -->
        <div class="row">
            <div class="col-12">
                <form action="" method="post" class="ajax-component-form ajax-append">
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
                                </div>
                            </div>
                        </div>
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
