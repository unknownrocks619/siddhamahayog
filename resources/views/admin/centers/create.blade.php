@extends('layouts.admin.master')
@push('page_title')New Center @endpush

@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href='{{route("admin.centers.list")}}'>Centers</a> /</span> Update
            </h4>
            <a href="{{route('admin.centers.list')}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <form class="ajax-form" action="{{route('admin.centers.create')}}" method="post">
            <div class="card-body">
                <div class="bg-light p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="center_name">Center Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="center_name"  id="center_name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="center_location">Address
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="center_location"  id="center_location" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="center_email_address">Center Official Email
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="email" name="center_email_address"  id="center_email_address" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Active
                                </label>
                                <select name="active" id="active" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-group">
                                <label for="password">Default Currency</label>
                                <select name="default_currency" id="default_currency" class="form-control">
                                    <option value="NPR" selected>NPR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="USD">USD</option>
                                    <option value="CAD">CAD</option>
                                    <option value="AUD">AUD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4>
                            Add New Center
                        </h4>
                    </div>
                </div>

                
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary">
                            Create New Center
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
